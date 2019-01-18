<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$accion       	 = $_POST["accion"];
$id_clientes  	 = $_POST["id"];
$nombre  = $_POST["nombre"];



include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';


if($accion=="agregar"){
	$qry = "insert into clientes (nombre) values ('$nombre')";
}
if($accion=="consultar"){

	$qry = "select * from clientes where id=$id_clientes limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from clientes where id=$id_clientes for update";
	$qry = "update clientes set nombre='$nombre'";
	$qry = $qry." where id=$id_clientes";
}

if($accion=="eliminar"){
	$qryBloqueo = "select * from clientes where id=$id_clientes for update";
	$qry = "delete from clientes where id=$id_clientes";
}

include("../core/ABC_query_xml_pdo.php");
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
