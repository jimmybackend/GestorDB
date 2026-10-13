<?php
declare(strict_types=1);
/** Schema mutations: explicitly allowlisted DDL, no destructive drops or arbitrary SQL. */
final class SchemaEditor {
 private const TYPES=['VARCHAR','INT','BIGINT','TEXT','DATE','DATETIME','DECIMAL','BOOLEAN'];
 public function __construct(private mysqli $db) {}
 private function ident(string $name):string {
  if(!preg_match('/^[A-Za-z_][A-Za-z0-9_]{0,63}$/D',$name))throw new InvalidArgumentException('Invalid identifier');
  return '`'.$name.'`';
 }
 private function type(string $type,int $length):string {
  $type=strtoupper($type);
  if(!in_array($type,self::TYPES,true))throw new InvalidArgumentException('Unsupported type');
  if($type==='VARCHAR'){if($length<1||$length>4096)throw new InvalidArgumentException('Invalid VARCHAR length');return "VARCHAR($length)";}
  if($type==='DECIMAL'){return 'DECIMAL(12,2)';}
  return $type;
 }
 private function existing(string $table):array {
  $stmt=$this->db->prepare('SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=? ORDER BY ORDINAL_POSITION');
  $stmt->bind_param('s',$table);$stmt->execute();$names=array_column($stmt->get_result()->fetch_all(MYSQLI_ASSOC),'COLUMN_NAME');$stmt->close();
  if(!$names)throw new InvalidArgumentException('Table missing or has no columns');
  return $names;
 }
 public function create(string $table,string $column,string $type,int $length):void {
  $sql='CREATE TABLE '.$this->ident($table).' ('.$this->ident($column).' '.$this->type($type,$length).' NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';
  $this->db->query($sql);
 }
 public function addColumn(string $table,string $column,string $type,int $length,?string $after):void {
  $columns=$this->existing($table);
  if(in_array($column,$columns,true))throw new InvalidArgumentException('Column already exists');
  $position=$after===null||$after===''?'':($after==='__FIRST__'?' FIRST':(in_array($after,$columns,true)?' AFTER '.$this->ident($after):throw new InvalidArgumentException('Invalid position')));
  $sql='ALTER TABLE '.$this->ident($table).' ADD COLUMN '.$this->ident($column).' '.$this->type($type,$length).' NULL'.$position;
  $this->db->query($sql);
 }
 public function moveColumn(string $table,string $column,?string $after):void {
  $columns=$this->existing($table);
  if(!in_array($column,$columns,true))throw new InvalidArgumentException('Unknown column');
  if($after===$column)throw new InvalidArgumentException('Same column');
  $stmt=$this->db->prepare('SELECT COLUMN_TYPE,IS_NULLABLE,COLUMN_DEFAULT,EXTRA,GENERATION_EXPRESSION FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=? AND COLUMN_NAME=?');
  $stmt->bind_param('ss',$table,$column);$stmt->execute();$row=$stmt->get_result()->fetch_assoc();$stmt->close();
  if(!$row||$row['COLUMN_DEFAULT']!==null||$row['EXTRA']!==''||$row['GENERATION_EXPRESSION']!=='')throw new InvalidArgumentException('Complex column definition: movement disabled to prevent metadata loss');
  $type=$row['COLUMN_TYPE'];
  if(!preg_match('/^[a-zA-Z0-9_,() ]+$/D',$type))throw new InvalidArgumentException('Unsupported column definition');
  $position=$after===null||$after===''?'':($after==='__FIRST__'?' FIRST':(in_array($after,$columns,true)?' AFTER '.$this->ident($after):throw new InvalidArgumentException('Invalid position')));
  $sql='ALTER TABLE '.$this->ident($table).' MODIFY COLUMN '.$this->ident($column).' '.$type.($row['IS_NULLABLE']==='YES'?' NULL':' NOT NULL').$position;
  $this->db->query($sql);
 }
}
