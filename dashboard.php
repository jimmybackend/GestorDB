<?php
declare(strict_types=1);
session_start();
header('Cache-Control: no-store');
require_once __DIR__.'/db.php';
require_once __DIR__.'/SchemaHierarchy.php';
$schema=(new SchemaHierarchy($db_connection))->inspect();
if (!isset($_SESSION['gestordb_csrf'])) $_SESSION['gestordb_csrf']=bin2hex(random_bytes(24));
$e=static fn($s)=>htmlspecialchars((string)$s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
$table=(string)($_GET['table']??'');
if ($table!==''&&!isset($schema[$table])) {http_response_code(404);exit('Tabla no encontrada');}
$action=(string)($_GET['action']??'see');
if (!in_array($action,['see','add','edit','delete'],true)) $action='see';
$meta=$table!==''?$schema[$table]:null;
$quote=static fn(string $s)=>'`'.str_replace('`','``',$s).'`';
$pk=$meta['pk']??[];
$error='';
$rows=[];
if ($meta && $action==='see') {
    try {
        $cols=array_keys($meta['columns']);
        $sql='SELECT * FROM '.$quote($table).' LIMIT 100';
        $result=$db_connection->query($sql);
        $rows=$result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    } catch(Throwable $ex) {error_log($ex->getMessage());$error='No se pudo consultar la tabla.';}
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>GestorDB · Esquema dinámico</title><link rel="stylesheet" href="assets/gestordb.css"></head>
<body><div class="layout"><?php include __DIR__.'/main05.php'; ?>
<main class="content"><header><h1><?= $meta?$e($table):'Base de datos' ?></h1><span><?= count($schema) ?> tablas detectadas</span></header>
<?php if (!$meta): ?>
<section class="panel"><h2>Tablas maestras y detalles</h2><p>Selecciona una tabla en el menú. La jerarquía utiliza las claves foráneas reales del esquema MySQL.</p>
<p>Una tabla con dos relaciones representa dos dependencias; no implica automáticamente dos aprobaciones humanas.</p></section>
<?php else: ?>
<section class="panel"><div class="toolbar">
<a href="?table=<?=rawurlencode($table)?>&action=see">Registros</a>
<a href="?table=<?=rawurlencode($table)?>&action=add">Agregar</a>
<?php if(count($pk)===1): ?><a href="?table=<?=rawurlencode($table)?>&action=edit">Editar</a>
<a href="?table=<?=rawurlencode($table)?>&action=delete">Eliminar</a><?php endif; ?>
</div><p>Nivel <?= $e($meta['level']) ?> · Clave primaria: <?= $e(implode(', ', $pk)?:'sin PK') ?> · <?= count($meta['parents']) ?> relación(es) detectada(s)</p>
<?php foreach($meta['parents'] as $parent): ?><p class="rel">Depende de <strong><?= $e($parent['table']) ?></strong> mediante <?= $e(implode(', ',array_keys($parent['mapping']))) ?></p><?php endforeach; ?>
<?php if($meta['cycle']):?><p class="warning">Se detectó un ciclo de relaciones; el nivel es orientativo.</p><?php endif; ?>
<?php if($error):?><p class="warning"><?=$e($error)?></p><?php endif; ?>
<?php if($action==='see'): ?>
<div class="scroll"><table><thead><tr><?php foreach($meta['columns'] as $name=>$col):?><th><?=$e($name)?></th><?php endforeach;?></tr></thead><tbody>
<?php foreach($rows as $row):?><tr><?php foreach($meta['columns'] as $name=>$col):?><td><?=$e($row[$name]??'')?></td><?php endforeach;?></tr><?php endforeach;?></tbody></table></div>
<p>Hasta 100 registros por consulta.</p>
<?php else: ?>
<?php if(in_array($action,['edit','delete'],true)&&count($pk)!==1):?>
<p class="warning">Se requiere una clave primaria simple para esta operación.</p>
<?php else: ?>
<form action="procesar.php" method="post" class="edit-form">
<input type="hidden" name="csrf" value="<?=$e($_SESSION['gestordb_csrf'])?>">
<input type="hidden" name="table" value="<?=$e($table)?>">
<input type="hidden" name="action" value="<?=$e($action)?>">
<?php if($action!=='add'):?>
<label><?=$e($pk[0])?> (valor exacto)<input name="pk_value" required></label>
<?php endif; ?>
<?php if($action!=='delete'): ?>
<?php foreach($meta['columns'] as $name=>$col):
if(str_contains(strtolower($col['EXTRA']),'auto_increment'))continue; ?>
<label><?=$e($name)?> <small><?=$e($col['DATA_TYPE'])?><?=$col['IS_NULLABLE']==='YES'?' · permite NULL':''?></small>
<input name="field[<?=$e($name)?>]" placeholder="Valor (vacío = omitir en alta)"></label>
<?php endforeach;?>
<?php else: ?><p class="warning">Se eliminará únicamente el registro con la clave primaria indicada. Esta operación es irreversible.</p><?php endif;?>
<button type="submit"><?= $e(match($action){'add'=>'Insertar','edit'=>'Actualizar','delete'=>'Eliminar'}) ?></button>
</form>
<?php endif; ?>
<?php endif;?>
</section><?php endif;?></main></div></body></html>