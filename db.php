<?php
declare(strict_types=1);
/**
 * GestorDB shared database connection.
 * Private configuration is stored in the parent of the app directory.
 * Can also use GESTORDB_DB_* environment variables.
 */
$configPath = dirname(__DIR__) . '/gestordb-config.php';
$config = is_file($configPath) ? require $configPath : [
    'host' => getenv('GESTORDB_DB_HOST') ?: '127.0.0.1',
    'user' => getenv('GESTORDB_DB_USER') ?: '',
    'password' => getenv('GESTORDB_DB_PASSWORD') ?: '',
    'database' => getenv('GESTORDB_DB_NAME') ?: '',
    'port' => (int)(getenv('GESTORDB_DB_PORT') ?: 3306),
];
if (!is_array($config) || empty($config['user']) || empty($config['database'])) {
    http_response_code(503);
    exit('GestorDB database configuration is missing.');
}
$servidor = (string)$config['host'];
$usuario = (string)$config['user'];
$clave = (string)$config['password'];
$basedatos = (string)$config['database'];
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $db_connection = mysqli_connect($servidor, $usuario, $clave, $basedatos, (int)($config['port'] ?? 3306));
    mysqli_set_charset($db_connection, 'utf8mb4');
} catch (mysqli_sql_exception $exception) {
    error_log('GestorDB database connection error: ' . $exception->getMessage());
    http_response_code(503);
    exit('Database connection unavailable.');
}
