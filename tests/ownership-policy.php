<?php
require dirname(__DIR__).'/OwnershipPolicy.php';
function check(bool $ok,string $name):void {if(!$ok){fwrite(STDERR,"FAILED: ".$name.PHP_EOL);exit(1);}}
$direct=['parents'=>['fk_owner'=>['table'=>'Users','mapping'=>['user_id'=>'id']]]];
check(OwnershipPolicy::column($direct,'Users')==='user_id','direct FK');
check(OwnershipPolicy::column($direct,'OtherUsers')===null,'wrong parent');
check(OwnershipPolicy::column(['parents'=>[]],'Users')===null,'missing FK');
$ambiguous=['parents'=>['first'=>['table'=>'Users','mapping'=>['user_id'=>'id']],'second'=>['table'=>'Teams','mapping'=>['team_id'=>'id']]]];
check(OwnershipPolicy::column($ambiguous,'Users')===null,'ambiguous relationship');
$compound=['parents'=>['fk'=>['table'=>'Users','mapping'=>['user_id'=>'id','tenant_id'=>'tenant_id']]]];
check(OwnershipPolicy::column($compound,'Users')===null,'compound mapping denied');
check(OwnershipPolicy::scope($direct,'Users','42')===['user_id'=>'42'],'scope parameter');
echo "Ownership policy tests passed".PHP_EOL;
