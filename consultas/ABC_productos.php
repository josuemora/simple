<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$accion       	= $_POST["accion"];
$id_productos  	= $_POST["id"];
$descripcion  	= $_POST["descripcion"];
$precio  		= $_POST["precio"];


include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';


if($accion=="agregar"){
	$qry = "insert into productos (descripcion,precio) values ('$descripcion',$precio)";
}
if($accion=="consultar"){

	$qry = "select * from productos where id=$id_productos limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from productos where id=$id_productos for update";
	$qry = "update productos set descripcion='$descripcion',precio=$precio";
	$qry = $qry." where id=$id_productos";
}

if($accion=="eliminar"){
	$qryBloqueo = "select * from productos where id=$id_productos for update";
	$qry = "delete from productos where id=$id_productos";
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
