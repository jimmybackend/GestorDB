<?php
declare(strict_types=1);
session_start();
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');
$setupToken = getenv('GESTORDB_SETUP_TOKEN');
$configFile = dirname(__DIR__, 2) . '/gestordb-config.php';
$installed = is_file($configFile) || (getenv('GESTORDB_DB_USER') !== false && getenv('GESTORDB_DB_NAME') !== false);
if (!is_string($setupToken) || strlen($setupToken) < 24) {
    http_response_code(503);
    exit('Set GESTORDB_SETUP_TOKEN (minimum 24 characters) in the PHP runtime to enable setup.');
}
if (!isset($_SESSION['gestordb_csrf'])) {
    $_SESSION['gestordb_csrf'] = bin2hex(random_bytes(24));
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $givenToken = $_POST['setup_token'] ?? '';
    $givenCsrf = $_POST['csrf'] ?? '';
    if (!is_string($givenToken) || !hash_equals($setupToken, $givenToken) ||
        !is_string($givenCsrf) || !hash_equals($_SESSION['gestordb_csrf'], $givenCsrf)) {
        http_response_code(403);
        $error = 'Invalid setup token or session.';
    } elseif ($installed) {
        $error = 'Already configured; installer is locked.';
    } elseif (!extension_loaded('mysqli')) {
        $error = 'Missing mysqli PHP extension.';
    } else {
        $host = trim((string)($_POST['host'] ?? ''));
        $user = trim((string)($_POST['user'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $database = trim((string)($_POST['database'] ?? ''));
        $accessMode = (string)($_POST['access_mode'] ?? 'users');
        $authTable = trim((string)($_POST['auth_table'] ?? 'Users'));
        $adminIps = trim((string)($_POST['admin_ips'] ?? '127.0.0.1,::1'));
        $port = filter_var($_POST['port'] ?? 3306, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 65535]]);
        if ($host === '' || $user === '' || $database === '' || $port === false ||
            !in_array($accessMode, ['admin','users','mixed'], true) ||
            !preg_match('/^[A-Za-z_][A-Za-z0-9_]{0,63}$/D', $authTable) ||
            !preg_match('/^[0-9a-fA-F:., ]+$/D', $adminIps) ||
            !preg_match('/^[A-Za-z0-9_.:-]+$/D', $host) ||
            !preg_match('/^[A-Za-z0-9_]+$/D', $database)) {
            $error = 'Invalid connection parameters.';
        } else {
            try {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $db = mysqli_init();
                mysqli_options($db, MYSQLI_OPT_CONNECT_TIMEOUT, 5);
                mysqli_real_connect($db, $host, $user, $password, $database, (int)$port);
                mysqli_set_charset($db, 'utf8mb4');
                if ($accessMode === 'users' || $accessMode === 'mixed') {
                    $verify = $db->prepare('SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=?');
                    $verify->bind_param('s', $authTable);
                    $verify->execute();
                    $authColumns = array_column($verify->get_result()->fetch_all(MYSQLI_ASSOC), 'COLUMN_NAME');
                    $verify->close();
                    foreach (['id', 'email', 'password'] as $column) {
                        if (!in_array($column, $authColumns, true)) {
                            throw new RuntimeException('Chosen authentication table is missing a required column');
                        }
                    }
                }
                mysqli_close($db);
                $settings = [
                    'host' => $host, 'user' => $user, 'password' => $password,
                    'database' => $database, 'port' => (int)$port,
                    'access_mode' => $accessMode,
                    'auth_table' => $authTable,
                    'admin_allowed_ips' => $adminIps
                ];
                $contents = "<?php\nreturn " . var_export($settings, true) . ";\n";
                if (!is_dir(dirname($configFile)) || !is_writable(dirname($configFile))) {
                    throw new RuntimeException('Parent directory is not writable. Deploy with writable private configuration directory.');
                }
                $fp = @fopen($configFile, 'x');
                if ($fp === false) {
                    throw new RuntimeException('Configuration already exists or cannot be written.');
                }
                chmod($configFile, 0600);
                try {
                    if (fwrite($fp, $contents) !== strlen($contents)) {
                        throw new RuntimeException('Could not persist complete configuration.');
                    }
                } finally {
                    fclose($fp);
                }
                $success = 'Database connection verified and private configuration saved. Remove GESTORDB_SETUP_TOKEN and restrict access to /install/.';
                $installed = true;
            } catch (Throwable $exception) {
                error_log('GestorDB installation error: ' . $exception->getMessage());
                $error = 'Database connection or configuration failed. Check server logs.';
            }
        }
    }
}
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>GestorDB · Instalación</title>
<style>body{font:16px system-ui,sans-serif;background:#f5f7fb;color:#1b2638;margin:0;padding:2rem}.box{max-width:540px;margin:auto;background:white;padding:2rem;border-radius:14px;box-shadow:0 4px 22px #1020401a}label{display:block;margin:1rem 0 .3rem}input,select{width:100%;box-sizing:border-box;padding:.7rem;border:1px solid #abc;border-radius:7px}button{padding:.8rem 1.2rem;margin-top:1.3rem;border:0;border-radius:7px;background:#1257a0;color:white;font-weight:700}p{line-height:1.5}.notice{padding:1rem;background:#eef2f8;border-radius:7px}</style></head>
<body><main class="box"><h1>GestorDB · Instalación</h1>
<p>Configura una conexión a una <strong>base MySQL existente</strong>. No se crearán ni modificarán tablas.</p>
<?php if ($error !== ''): ?><p class="notice" role="alert"><?= e($error) ?></p><?php endif; ?>
<?php if ($success !== ''): ?><p class="notice"><?= e($success) ?></p><?php endif; ?>
<?php if ($installed): ?>
<p class="notice">Configuración existente. Instalación bloqueada para evitar sobrescrituras.</p>
<?php else: ?>
<form method="post" autocomplete="off">
<input type="hidden" name="csrf" value="<?= e($_SESSION['gestordb_csrf']) ?>">
<label>Token de instalación</label><input name="setup_token" type="password" required>
<label>Host MySQL</label><input name="host" value="127.0.0.1" required>
<label>Puerto</label><input name="port" type="number" min="1" max="65535" value="3306" required>
<label>Usuario MySQL</label><input name="user" required>
<label>Contraseña MySQL</label><input name="password" type="password">
<label>Base de datos existente</label><input name="database" required>
<label>Modo de acceso</label><select name="access_mode"><option value="users">Usuarios</option><option value="admin">Administrador, IP autorizada</option><option value="mixed">Mixto</option></select>
<label>Tabla de autenticación (id, email, password)</label><input name="auth_table" value="Users" required>
<label>IP del administrador (separadas por comas, sin cabeceras proxy)</label><input name="admin_ips" value="127.0.0.1,::1" required>
<p>El administrador directo sólo podrá entrar desde las IP indicadas. Usa VPN o un proxy con acceso restringido.</p>
<button type="submit">Verificar conexión e instalar</button>
</form>
<?php endif; ?>
<p><small>Usa únicamente HTTPS, acceso restringido y credenciales con permisos mínimos. La configuración se guarda fuera del directorio del proyecto.</small></p>
</main></body></html>
