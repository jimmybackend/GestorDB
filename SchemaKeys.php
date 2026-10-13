<?php
declare(strict_types=1);
/**
 * Restrained schema-key operations. Existing tables/columns only.
 * MySQL performs final checks for uniqueness, types and referential integrity.
 */
final class SchemaKeys {
    public function __construct(private mysqli $db) {}
    private function ident(string $value): string {
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]{0,63}$/D', $value)) {
            throw new InvalidArgumentException('Invalid SQL identifier');
        }
        return '`'.$value.'`';
    }
    private function column(string $table, string $column): array {
        $this->ident($table); $this->ident($column);
        $stmt=$this->db->prepare('SELECT DATA_TYPE,IS_NULLABLE,COLUMN_TYPE,EXTRA FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=? AND COLUMN_NAME=?');
        $stmt->bind_param('ss',$table,$column);
        $stmt->execute();$row=$stmt->get_result()->fetch_assoc();$stmt->close();
        if (!$row) throw new InvalidArgumentException('Unknown table or column');
        return $row;
    }
    private function hasPrimary(string $table): bool {
        $stmt=$this->db->prepare("SELECT COUNT(*) AS n FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=? AND CONSTRAINT_TYPE='PRIMARY KEY'");
        $stmt->bind_param('s',$table);$stmt->execute();$result=$stmt->get_result()->fetch_assoc();$stmt->close();
        return (int)($result['n']??0)>0;
    }
    public function addPrimary(string $table,string $column): void {
        $info=$this->column($table,$column);
        if ($this->hasPrimary($table)) throw new InvalidArgumentException('Primary key already exists');
        if ($info['IS_NULLABLE']!=='NO') throw new InvalidArgumentException('Primary key column must already be NOT NULL');
        $this->db->query('ALTER TABLE '.$this->ident($table).' ADD PRIMARY KEY ('.$this->ident($column).')');
    }
    public function addIndex(string $table,string $column,string $index): void {
        $this->column($table,$column);
        $sql='ALTER TABLE '.$this->ident($table).' ADD INDEX '.$this->ident($index).' ('.$this->ident($column).')';
        $this->db->query($sql);
    }
    public function addForeignKey(string $table,string $column,string $parent,string $parentColumn,string $constraint): void {
        $childInfo=$this->column($table,$column);
        $parentInfo=$this->column($parent,$parentColumn);
        if ($table===$parent && $column===$parentColumn) throw new InvalidArgumentException('Identical self reference');
        // MySQL checks referenced uniqueness, engine, signedness, charset and data integrity.
        $sql='ALTER TABLE '.$this->ident($table).' ADD CONSTRAINT '.$this->ident($constraint).
            ' FOREIGN KEY ('.$this->ident($column).') REFERENCES '.$this->ident($parent).' ('.$this->ident($parentColumn).')'.
            ' ON DELETE RESTRICT ON UPDATE RESTRICT';
        $this->db->query($sql);
    }
}
