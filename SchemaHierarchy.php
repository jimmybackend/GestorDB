<?php
declare(strict_types=1);

/** Schema metadata only. Never invent relationships from similar column names. */
final class SchemaHierarchy
{
    public function __construct(private mysqli $db) {}

    public function inspect(): array
    {
        $tables = [];
        $result = $this->db->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_TYPE = 'BASE TABLE' ORDER BY TABLE_NAME");
        while ($row = $result->fetch_assoc()) {
            $name = $row['TABLE_NAME'];
            $tables[$name] = ['name' => $name, 'pk' => [], 'parents' => [], 'columns' => [], 'level' => null, 'cycle' => false];
        }
        $result->free();
        $result = $this->db->query("SELECT TABLE_NAME,COLUMN_NAME,COLUMN_KEY,DATA_TYPE,IS_NULLABLE,EXTRA FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() ORDER BY TABLE_NAME,ORDINAL_POSITION");
        while ($row = $result->fetch_assoc()) {
            $t = $row['TABLE_NAME'];
            if (!isset($tables[$t])) continue;
            $tables[$t]['columns'][$row['COLUMN_NAME']] = $row;
        }
        $result->free();
        $sql = "SELECT TABLE_NAME,COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME,CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA=DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY TABLE_NAME,CONSTRAINT_NAME,ORDINAL_POSITION";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $t = $row['TABLE_NAME']; $p = $row['REFERENCED_TABLE_NAME'];
            if (!isset($tables[$t], $tables[$p])) continue;
            $key = $row['CONSTRAINT_NAME'];
            if (!isset($tables[$t]['parents'][$key])) {
                $tables[$t]['parents'][$key] = ['table' => $p, 'mapping' => []];
            }
            $tables[$t]['parents'][$key]['mapping'][$row['COLUMN_NAME']] = $row['REFERENCED_COLUMN_NAME'];
        }
        $result->free();
        $result = $this->db->query("SELECT TABLE_NAME,COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA=DATABASE() AND CONSTRAINT_NAME='PRIMARY' ORDER BY TABLE_NAME,ORDINAL_POSITION");
        while ($row = $result->fetch_assoc()) {
            if (isset($tables[$row['TABLE_NAME']])) {
                $tables[$row['TABLE_NAME']]['pk'][] = $row['COLUMN_NAME'];
            }
        }
        $result->free();

        $states = [];
        $levelOf = function (string $name) use (&$levelOf, &$tables, &$states): int {
            if (($states[$name] ?? 0) === 2) return $tables[$name]['level'] ?? 0;
            if (($states[$name] ?? 0) === 1) {
                $tables[$name]['cycle'] = true;
                return 0;
            }
            $states[$name] = 1;
            $level = 0;
            foreach ($tables[$name]['parents'] as $parent) {
                if ($parent['table'] === $name) {
                    $tables[$name]['cycle'] = true;
                    continue;
                }
                $level = max($level, 1 + $levelOf($parent['table']));
                if ($tables[$parent['table']]['cycle']) $tables[$name]['cycle'] = true;
            }
            $states[$name] = 2;
            $tables[$name]['level'] = $level;
            return $level;
        };
        foreach (array_keys($tables) as $name) $levelOf($name);
        uasort($tables, static fn(array $a, array $b): int => ($a['level'] <=> $b['level']) ?: strcmp($a['name'], $b['name']));
        return $tables;
    }
}
