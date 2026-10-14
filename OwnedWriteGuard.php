<?php
declare(strict_types=1);
final class OwnedWriteGuard {
    public static function owner(array $meta,string $authTable,string $target): string {
        require_once __DIR__.'/OwnershipPolicy.php';
        if($target===$authTable)throw new DomainException('Authentication table is protected');
        $column=OwnershipPolicy::column($meta,$authTable);
        if($column===null||!isset($meta['columns'][$column]))throw new DomainException('Ownership cannot be established');
        return $column;
    }
    public static function insertOwner(array $values,string $column,string $userId):array {
        unset($values[$column]);
        $values[$column]=$userId;
        return $values;
    }
    public static function scopedWhere(array $pk,string $owner):string {
        if(!$pk)throw new DomainException('Primary key required');
        $quote=static fn(string $name)=>'`'.str_replace('`','``',$name).'`';
        return implode(' AND ',array_map(static fn($name)=>$quote($name).'=?',$pk)).' AND '.$quote($owner).'=?';
    }
}
