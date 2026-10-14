<?php
declare(strict_types=1);
require dirname(__DIR__).'/OwnedWriteGuard.php';
$meta=['columns'=>['record_id'=>[],'user_ref'=>[],'value'=>[]],'parents'=>['fk_user'=>['table'=>'Accounts','mapping'=>['user_ref'=>'id']]]];
function ensure(bool $ok,string $msg):void{if(!$ok)throw new RuntimeException($msg);}
ensure(OwnedWriteGuard::owner($meta,'Accounts','Documents')==='user_ref','valid ownership');
ensure(OwnedWriteGuard::insertOwner(['user_ref'=>'999','value'=>'x'],'user_ref','42')['user_ref']==='42','owner injection');
ensure(OwnedWriteGuard::scopedWhere(['a','b'],'user_ref')==='`a`=? AND `b`=? AND `user_ref`=?','composite scoped SQL');
try{OwnedWriteGuard::owner($meta,'Accounts','Accounts');throw new RuntimeException('auth table not blocked');}catch(DomainException $e){}
try{OwnedWriteGuard::owner($meta,'Wrong','Documents');throw new RuntimeException('wrong owner accepted');}catch(DomainException $e){}
try{OwnedWriteGuard::scopedWhere([],'user_ref');throw new RuntimeException('no primary key accepted');}catch(DomainException $e){}
echo "Owned writes guard tests passed\n";
