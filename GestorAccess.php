<?php
declare(strict_types=1);
final class GestorAccess {
    private static function settings(): array {
        $file=dirname(__DIR__).'/gestordb-config.php';
        if(!is_file($file))return [];
        $settings=require $file;
        return is_array($settings)?$settings:[];
    }
    private static function option(string $env, string $configKey, string $fallback): string {
        $value=getenv($env);
        if(is_string($value)&&$value!=='')return $value;
        $settings=self::settings();
        return isset($settings[$configKey])&&is_string($settings[$configKey])?$settings[$configKey]:$fallback;
    }
    public static function mode(): string {
        $mode = self::option('GESTORDB_ACCESS_MODE','access_mode','users');
        return in_array($mode, ['admin','users','mixed'],true) ? $mode : 'users';
    }
    public static function adminTrusted(): bool {
        $allow = array_filter(array_map('trim',explode(',',self::option('GESTORDB_ADMIN_ALLOWED_IPS','admin_allowed_ips','127.0.0.1,::1'))));
        return in_array($_SERVER['REMOTE_ADDR'] ?? '', $allow, true);
    }
    public static function identity(): ?array {
        if (isset($_SESSION['gestordb_identity']) && is_array($_SESSION['gestordb_identity'])) return $_SESSION['gestordb_identity'];
        if (in_array(self::mode(), ['admin','mixed'],true) && self::adminTrusted()) return ['mode'=>'admin'];
        return null;
    }
    public static function requireIdentity(): array {
        $id = self::identity();
        if (!$id) { header('Location: index.php',true,303); exit; }
        return $id;
    }
    public static function usersTable(mysqli $db): ?array {
        // Never select credential-like tables by names alone. An explicit table can be configured.
        $table = self::option('GESTORDB_AUTH_TABLE','auth_table','Users');
        $cols = [];
        $stmt=$db->prepare('SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=?');
        $stmt->bind_param('s',$table); $stmt->execute();
        foreach($stmt->get_result()->fetch_all(MYSQLI_ASSOC) as $r) $cols[]=$r['COLUMN_NAME'];
        $stmt->close();
        foreach(['id','email','password'] as $key) if(!in_array($key,$cols,true))return null;
        return ['table'=>$table,'id'=>'id','email'=>'email','password'=>'password','hasStatus'=>in_array('userstatus',$cols,true)];
    }
    public static function login(mysqli $db,string $email,string $password): bool {
        if (strlen($email)>255 || $email==='' || $password==='') return false;
        $map=self::usersTable($db);
        if (!$map) return false;
        $table='`'.str_replace('`','``',$map['table']).'`';
        $stmt=$db->prepare("SELECT `id`,`password` FROM {$table} WHERE `email`=? LIMIT 2");
        $stmt->bind_param('s',$email); $stmt->execute(); $rows=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);$stmt->close();
        if(count($rows)!==1 || !password_verify($password,(string)$rows[0]['password']))return false;
        if ($map['hasStatus']) {
            $check=$db->prepare("SELECT 1 FROM {$table} WHERE `id`=? AND `userstatus`='Activo' LIMIT 1");
            $uid=(string)$rows[0]['id'];
            $check->bind_param('s',$uid); $check->execute();
            $active=$check->get_result()->fetch_row()!==null; $check->close();
            if (!$active) return false;
        }
        session_regenerate_id(true);
        $_SESSION['gestordb_identity']=['mode'=>'user','id'=>(string)$rows[0]['id'],'table'=>$map['table']];
        return true;
    }
    public static function ownerColumn(array $meta,string $userTable): ?string {
        // Only a *declared foreign key* to the login table establishes ownership.
        $matches=[];
        foreach($meta['parents'] as $relationship) {
            if($relationship['table']!==$userTable || count($relationship['mapping'])!==1)continue;
            foreach($relationship['mapping'] as $local=>$remote) {
                if($remote==='id')$matches[]=$local;
            }
        }
        return count($matches)===1 ? $matches[0] : null;
    }
}
