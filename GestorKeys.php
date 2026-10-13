<?php
declare(strict_types=1);

/** Metadata resolver for PK, FK and legacy *_id_ conventions. */
final class GestorKeys {
    public function __construct(private mysqli $db) {}
    private function quote(string $name): string {
        return '`'.str_replace('`','``',$name).'`';
    }
    public function schema(): array {
        require_once __DIR__.'/SchemaHierarchy.php';
        return (new SchemaHierarchy($this->db))->inspect();
    }
    public function describe(string $table): array {
        $schema=$this->schema();
        if(!isset($schema[$table]))throw new InvalidArgumentException('Unknown table');
        $meta=$schema[$table];
        $links=$meta['parents'];
        // Conventions are navigation hints only, never authority for user access.
        foreach(array_keys($meta['columns']) as $column) {
            if(!preg_match('/^(.+)_id_$/iD',$column,$match))continue;
            $stem=$match[1];$candidates=[$stem,ucfirst($stem),$stem.'s',ucfirst($stem).'s'];
            $hits=array_values(array_unique(array_filter($candidates,static fn($name)=>isset($schema[$name]))));
            if(count($hits)===1){
                $known=false;
                foreach($links as $link)if(array_key_exists($column,$link['mapping']))$known=true;
                if(!$known)$links['convention_'.$column]=['table'=>$hits[0],'mapping'=>[$column=>null],'inferred'=>true];
            }
        }
        return ['table'=>$table,'primary'=>$meta['pk'],'columns'=>$meta['columns'],'relations'=>$links];
    }
    public function choices(string $table,string $constraint,int $limit=100): array {
        $meta=$this->describe($table);
        $relation=$meta['relations'][$constraint]??null;
        if(!$relation || ($relation['inferred']??false))throw new InvalidArgumentException('Only declared foreign keys support automatic choices');
        $parent=$relation['table'];$schema=$this->schema();
        if(!isset($schema[$parent]))throw new InvalidArgumentException('Unknown related table');
        $cols=array_values(array_unique(array_values($relation['mapping'])));
        if(!$cols)throw new InvalidArgumentException('No referenced columns');
        foreach($cols as $col)if(!isset($schema[$parent]['columns'][$col]))throw new InvalidArgumentException('Unknown referenced column');
        $limit=max(1,min($limit,100));
        $sql='SELECT '.implode(',',array_map($this->quote(...),$cols)).' FROM '.$this->quote($parent).' LIMIT '.$limit;
        $result=$this->db->query($sql);
        $rows=$result->fetch_all(MYSQLI_ASSOC);$result->free();
        return $rows;
    }
}
