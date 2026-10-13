<?php
declare(strict_types=1);
session_start();
header('Cache-Control: no-store');
require_once __DIR__.'/db.php';
require_once __DIR__.'/SchemaHierarchy.php';
require_once __DIR__.'/GestorAccess.php';
$identity=GestorAccess::requireIdentity();
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
if (($identity['mode']??'')==='user') {
    $schema=array_filter($schema,static fn($item)=>GestorAccess::ownerColumn($item,(string)$identity['table'])!==null);
    if($table!==''&&!isset($schema[$table])){http_response_code(403);exit('Tabla no autorizada');}
    $meta=$table!==''?$schema[$table]:null;
    if($action!=='see'){http_response_code(403);exit('Edición de usuario no habilitada');}
}
if ($meta && $action==='see') {
    try {
        $cols=array_keys($meta['columns']);
        $sql='SELECT * FROM '.$quote($table);
        if(($identity['mode']??'')==='user') {
            $owner=GestorAccess::ownerColumn($meta,(string)$identity['table']);
            $sql.=' WHERE '.$quote($owner).'=? LIMIT 100';
            $stmt=$db_connection->prepare($sql);
            $stmt->bind_param('s',$identity['id']);
            $stmt->execute();
            $result=$stmt->get_result();
        }else{$result=$db_connection->query($sql.' LIMIT 100');}
        $rows=$result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    } catch(Throwable $ex) {error_log($ex->getMessage());$error='No se pudo consultar la tabla.';}
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>GestorDB · Esquema dinámico</title><link rel="stylesheet" href="assets/gestordb.css"></head>
<body><div class="layout"><?php include __DIR__.'/main05.php'; ?>
<main class="content"><header><h1><?= $meta?$e($table):'Base de datos' ?></h1><span><?= count($schema) ?> tablas detectadas</span></header>
<?php if(($identity['mode']??'')==='admin'): ?>
<section class="panel"><h2>Administrar estructura MySQL</h2><p>Crear tabla, agregar columna o cambiar posición. Las modificaciones se reflejan al recargar el menú y la tabla.</p>
<form method="post" action="schema-process.php" class="edit-form">
<input type="hidden" name="csrf" value="<?=$e($_SESSION['gestordb_csrf'])?>">
<label>Operación<select name="op"><option value="create">Crear tabla</option><option value="add">Agregar columna</option><option value="move">Mover columna (simple)</option></select></label>
<label>Tabla<input name="table" value="<?=$e($table)?>" required></label>
<label>Columna<input name="column" required></label>
<label>Tipo de dato<select name="type"><option>VARCHAR</option><option>INT</option><option>BIGINT</option><option>TEXT</option><option>DATE</option><option>DATETIME</option><option>DECIMAL</option><option>BOOLEAN</option></select></label>
<label>Longitud VARCHAR<input name="length" type="number" min="1" max="4096" value="255"></label>
<label>Posición<select name="after"><option value="">Al final</option><option value="__FIRST__">Al principio</option><?php if($meta):foreach($meta['columns'] as $name=>$column):?><option value="<?=$e($name)?>">Después de <?=$e($name)?></option><?php endforeach;endif;?></select></label>
<button type="submit">Aplicar cambio al esquema</button>
</form><p class="warning">DDL puede bloquear tablas. No se ejecutan eliminaciones ni modificaciones destructivas automáticas. Haz respaldo antes de cambiar producción.</p></section>
<?php endif; ?>
<?php if(($identity['mode']??'')==='admin' && $meta): ?>
<section class="panel"><h2>Claves e índices de <?= $e($table) ?></h2>
<p>Agrega una clave primaria, un índice o una relación foránea. MySQL validará restricciones y registros existentes.</p>
<form method="post" action="schema-keys-process.php" class="edit-form">
<input type="hidden" name="csrf" value="<?=$e($_SESSION['gestordb_csrf'])?>">
<input type="hidden" name="table" value="<?=$e($table)?>">
<label>Operación<select name="op" required><option value="primary">Agregar clave primaria</option><option value="index">Agregar índice</option><option value="foreign">Agregar clave foránea</option></select></label>
<label>Columna local<select name="column" required><?php foreach($meta['columns'] as $name=>$col):?><option value="<?=$e($name)?>"><?=$e($name)?></option><?php endforeach;?></select></label>
<label>Nombre del índice<input name="index_name" placeholder="idx_nombre"></label>
<label>Tabla relacionada<select name="parent"><option value="">Selecciona tabla</option><?php foreach($schema as $name=>$tbl):?><option value="<?=$e($name)?>"><?=$e($name)?></option><?php endforeach;?></select></label>
<label>Columna relacionada<input name="parent_column" placeholder="id"></label>
<label>Nombre de la restricción FK<input name="constraint" placeholder="fk_tabla_relacion"></label>
<label><input type="checkbox" name="confirm" value="yes" required> Confirmo que tengo respaldo de mi base antes de cambiar índices o claves.</label>
<button type="submit">Aplicar cambio</button></form>
<p class="warning">No modifica ni elimina las claves existentes. Las relaciones utilizan RESTRICT para evitar borrados y actualizaciones en cascada.</p>
</section><?php endif; ?>
<?php if (!$meta): ?>
<section class="panel"><h2>Tablas maestras y detalles</h2><p>Selecciona una tabla en el menú. La jerarquía utiliza las claves foráneas reales del esquema MySQL.</p>
<p>Una tabla con dos relaciones representa dos dependencias; no implica automáticamente dos aprobaciones humanas.</p></section>
<?php else: ?>
<section class="panel"><div class="toolbar">
<a href="?table=<?=rawurlencode($table)?>&action=see">Registros</a>
<?php if(($identity['mode']??'')==='admin'): ?><a href="?table=<?=rawurlencode($table)?>&action=add">Agregar</a><?php endif; ?>
<?php if(($identity['mode']??'')==='admin' && count($pk)===1): ?><a href="?table=<?=rawurlencode($table)?>&action=edit">Editar</a>
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