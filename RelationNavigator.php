<?php
declare(strict_types=1);

/** Relationship browser driven by declared FOREIGN KEY metadata. */
final class RelationNavigator {
    public function __construct(private mysqli $db, private array $schema) {}
    private static function q(string $name): string {
        return '`'.str_replace('`','``',$name).'`';
    }
    public function children(string $parent): array {
        $children=[];
        foreach($this->schema as $name=>$meta) {
            foreach($meta['parents'] as $constraint=>$rel) {
                if($rel['table']===$parent) $children[]=['table'=>$name,'constraint'=>$constraint,'mapping'=>$rel['mapping']];
            }
        }
        return $children;
    }
    public function scope(string $child, string $constraint, array $identity): array {
        if(($identity['mode']??'')!=='admin') throw new RuntimeException('Relation browsing requires administrator access');
        $meta=$this->schema[$child]??null;
        $rel=$meta['parents'][$constraint]??null;
        if(!$rel) throw new InvalidArgumentException('Unknown relationship');
        $parent=$rel['table'];
        $pk=$this->schema[$parent]['pk']??[];
        if(!$pk) throw new InvalidArgumentException('Parent has no primary key');
        $input=$_GET['parent_pk']??null;
        if(!is_array($input)||count($input)!==count($pk)) throw new InvalidArgumentException('Incomplete parent identity');
        $values=[];
        foreach($pk as $key) {
            if(!isset($input[$key])||!is_string($input[$key])||$input[$key]==='') throw new InvalidArgumentException('Missing parent key');
            $values[]=$input[$key];
        }
        $where=implode(' AND ',array_map(static fn($key)=>self::q($key).'=?',$pk));
        $stmt=$this->db->prepare('SELECT * FROM '.self::q($parent).' WHERE '.$where.' LIMIT 2');
        $types=str_repeat('s',count($values));$stmt->bind_param($types,...$values);$stmt->execute();
        $parents=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);$stmt->close();
        if(count($parents)!==1) throw new InvalidArgumentException('Parent record not found');
        $filters=[];
        foreach($rel['mapping'] as $local=>$remote) {
            if(!array_key_exists($remote,$parents[0])||$parents[0][$remote]===null) throw new InvalidArgumentException('Missing reference value');
            $filters[$local]=(string)$parents[0][$remote];
        }
        return ['parent'=>$parent,'filters'=>$filters];
    }
}
