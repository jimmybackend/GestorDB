<?php
declare(strict_types=1);
require dirname(__DIR__).'/GestorFieldCodec.php';
function assertKind(string $type,string $kind):void{
 $actual=GestorFieldRenderer::kind(['DATA_TYPE'=>$type]);
 if($actual!==$kind)throw new RuntimeException("$type: $actual != $kind");
}
foreach(['tinyint','smallint','mediumint','int','bigint','decimal','float','double'] as $t)assertKind($t,'number');
foreach(['char','varchar','text','longtext'] as $t)assertKind($t,'text');
foreach(['tinyblob','blob','mediumblob','longblob','binary','varbinary'] as $t)assertKind($t,'binary');
foreach(['point','linestring','polygon','multipoint','multilinestring','multipolygon','geometry','geometrycollection'] as $t)assertKind($t,'spatial');
foreach(['enum','set','bit','date','datetime','timestamp','time','year','json','vector'] as $t)assertKind($t,$t);
$set=['DATA_TYPE'=>'set','COLUMN_TYPE'=>"set('red','blue')"];
if(GestorFieldCodec::decode($set,['red','blue'])['value']!=='red,blue')throw new RuntimeException('SET');
$binary=['DATA_TYPE'=>'blob'];
if(GestorFieldCodec::decode($binary,'AAE=')['value']!=="\0\1")throw new RuntimeException('BLOB');
$json=['DATA_TYPE'=>'json'];
try{GestorFieldCodec::decode($json,'{invalid');throw new RuntimeException('JSON accepted');}catch(JsonException $expected){}
$geom=['DATA_TYPE'=>'point'];
if(GestorFieldCodec::decode($geom,'POINT(1 2)')['sql']!=='ST_GeomFromText(?)')throw new RuntimeException('geometry');
$bit=['DATA_TYPE'=>'bit','COLUMN_TYPE'=>'bit(4)'];
if(GestorFieldCodec::decode($bit,'1010')['value']!=='1010')throw new RuntimeException('bit');
if(!str_contains(GestorFieldRenderer::render('foo',$set),'checkbox'))throw new RuntimeException('SET HTML');
echo "Typed field tests passed\n";
