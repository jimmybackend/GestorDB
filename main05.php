<?php
/** Dynamic hierarchy navigation. $schema comes from SchemaHierarchy::inspect(). */
if (!isset($schema) || !is_array($schema)) { http_response_code(500); exit('Schema unavailable'); }
$esc = static fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$lastLevel = null;
?>
<aside class="sidebar"><a class="brand" href="dashboard.php">GestorDB</a>
<div class="nav-caption">Jerarquía de tablas</div>
<?php foreach ($schema as $table): ?>
<?php if ($lastLevel !== $table['level']): $lastLevel=$table['level']; ?>
<div class="level-caption">Nivel <?= $esc($lastLevel) ?> · <?= $lastLevel === 0 ? 'Maestras' : 'Detalles' ?></div>
<?php endif; ?>
<a class="table-link" href="dashboard.php?table=<?= rawurlencode($table['name']) ?>">
<span><?= $esc($table['name']) ?></span>
<small><?= count($table['parents']) ?> relación(es)<?= $table['cycle'] ? ' · ciclo' : '' ?></small></a>
<?php endforeach; ?>
</aside>
