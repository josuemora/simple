<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$accion       	 = $_POST["accion"];
$id_perfiles 	 = $_POST["id_perfiles"];

$nombre 	 	 = isset($_POST["nombre"])? $_POST["nombre"] : '';
$modulo = 'perfiles';

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';

if($accion=="agregar"){
	$qry = "insert into simple_seguridad.perfiles (nombre) values ('$nombre')";
}
if($accion=="consultar"){
	
	$qry = "select * from simple_seguridad.perfiles where id=$id_perfiles limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from simple_seguridad.perfiles where id=$id_perfiles for update";
	$qry = "update simple_seguridad.perfiles set nombre='$nombre'";
	$qry = $qry." where id=$id_perfiles and nombre<>'Administrador'";
}
if($accion=="eliminar"){
	$qryBloqueo = "select * from simple_seguridad.perfiles where id=$id_perfiles for update";
	$qry = "delete from simple_seguridad.perfiles where id=$id_perfiles  and nombre<>'Administrador'";
}

include("../core/ABC_query_xml_pdo.php");
//sleep(2);
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
