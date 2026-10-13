<?php
declare(strict_types=1);
require_once __DIR__.'/GestorFieldRenderer.php';

/** Normalize browser values to valid SQL parameters and safe, fixed SQL expressions. */
final class GestorFieldCodec {
 public static function decode(array $meta,mixed $input):array {
  $kind=GestorFieldRenderer::kind($meta);
  if(in_array($kind,['generated','unsupported'],true))throw new InvalidArgumentException('Column is not editable');
  if($kind==='set'){
   if(!is_array($input))throw new InvalidArgumentException('Invalid SET values');
   $allowed=GestorFieldRenderer::choices((string)$meta['COLUMN_TYPE']);
   foreach($input as $value)if(!is_string($value)||!in_array($value,$allowed,true))throw new InvalidArgumentException('Invalid SET option');
   if(count($input)!==count(array_unique($input)))throw new InvalidArgumentException('Duplicate SET values');
   return ['sql'=>'?','value'=>implode(',',$input)];
  }
  if(!is_string($input))throw new InvalidArgumentException('Expected string');
  if($kind==='enum'&&!in_array($input,GestorFieldRenderer::choices((string)$meta['COLUMN_TYPE']),true))throw new InvalidArgumentException('Invalid ENUM');
  if($kind==='json'){json_decode($input,true,512,JSON_THROW_ON_ERROR);}
  if($kind==='binary'){
   $value=base64_decode($input,true);
   if($value===false)throw new InvalidArgumentException('Invalid Base64');
   return ['sql'=>'?','value'=>$value];
  }
  if($kind==='spatial'){
   // WKT must be evaluated by a spatial constructor, never interpolated into SQL.
   if(strlen($input)>1000000||!preg_match('/^(?:POINT|LINESTRING|POLYGON|MULTIPOINT|MULTILINESTRING|MULTIPOLYGON|GEOMETRYCOLLECTION)\s*(?:EMPTY|\()/i',$input))throw new InvalidArgumentException('Invalid WKT shape');
   return ['sql'=>'ST_GeomFromText(?)','value'=>$input];
  }
  if($kind==='bit'){
   if(!preg_match('/^[01]+$/D',$input))throw new InvalidArgumentException('Invalid bits');
   $bits=(int)($meta['NUMERIC_PRECISION']??0);
   if($bits===0&&preg_match('/bit\((\d+)\)/i',(string)$meta['COLUMN_TYPE'],$m))$bits=(int)$m[1];
   if($bits>0&&strlen($input)>$bits)throw new InvalidArgumentException('Too many bits');
   return ['sql'=>'b'."'".'VALUE'."'".'','value'=>$input,'bit'=>true];
  }
  if($kind==='vector'){
   $v=json_decode($input,true,512,JSON_THROW_ON_ERROR);
   if(!is_array($v)||!array_is_list($v)||!$v)throw new InvalidArgumentException('Vector must be numeric array');
   foreach($v as $n)if(!is_int($n)&&!is_float($n))throw new InvalidArgumentException('Non-numeric vector');
   return ['sql'=>'STRING_TO_VECTOR(?)','value'=>$input];
  }
  if($kind==='number'&&!preg_match('/^[+-]?(?:\d+)(?:\.\d+)?(?:[eE][+-]?\d+)?$/D',$input))throw new InvalidArgumentException('Invalid number');
  if(in_array($kind,['date','datetime','timestamp'],true)){
   if($kind==='date'&&!preg_match('/^\d{4}-\d{2}-\d{2}$/D',$input))throw new InvalidArgumentException('Invalid date');
   if($kind!=='date'){
    if(!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}(?::\d{2}(?:\.\d{1,6})?)?$/D',$input))throw new InvalidArgumentException('Invalid datetime');
    $input=str_replace('T',' ',$input);
   }
  }
  return ['sql'=>'?','value'=>$input];
 }
}
