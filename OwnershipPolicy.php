<?php
declare(strict_types=1);

final class OwnershipPolicy
{
    public static function column(array $metadata, string $authTable): ?string
    {
        $parents=$metadata['parents']??[];
        if(count($parents)!==1)return null;
        $relation=reset($parents);
        if(($relation['table']??null)!==$authTable)return null;
        $mapping=$relation['mapping']??[];
        if(count($mapping)!==1)return null;
        $local=array_key_first($mapping);
        return $mapping[$local]==='id' ? $local : null;
    }

    public static function scope(array $metadata, string $authTable, string $userId): array
    {
        $column=self::column($metadata,$authTable);
        if($column===null)throw new DomainException('Ownership not established');
        return [$column=>$userId];
    }
}
