<?php
declare(strict_types=1);

/** Installer and runtime must target the same private file outside the web root. */
$app=dirname(__DIR__);
$installPath=dirname($app).'/gestordb-config.php';
$dbPath=dirname($app).'/gestordb-config.php';
if($installPath!==$dbPath || str_starts_with($installPath,$app.'/')){
 fwrite(STDERR,"Private configuration path check failed\n");exit(1);
}
$installer=file_get_contents($app.'/install/index.php');
$db=file_get_contents($app.'/db.php');
$access=file_get_contents($app.'/GestorAccess.php');
if(!str_contains($installer,"dirname(__DIR__, 2) . '/gestordb-config.php'")||
 !str_contains($db,"dirname(__DIR__) . '/gestordb-config.php'")||
 !str_contains($access,"dirname(__DIR__).'/gestordb-config.php'")){
 fwrite(STDERR,"Configuration paths have drifted\n");exit(1);
}
echo "Installer config path verified\n";
