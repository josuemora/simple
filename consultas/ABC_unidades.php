<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$accion       	 = $_POST["accion"];
$id_unidades	 = $_POST["id"];
$descorta		 = $_POST["descorta"];
$descripcion	 = $_POST["descripcion"];


$modulo = 'unidades';

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';


if($accion=="agregar"){
	$qry = "insert into unidades (descorta,descripcion) values ('$descorta','$descripcion')";
}
if($accion=="consultar"){

	$qry = "select * from unidades where id=$id_unidades limit 1";
	
	

}
if($accion=="cambiar"){
	$qryBloqueo = "select * from unidades where id=$id_unidades for update";
	$qry = "update unidades set descorta='$descorta', descripcion='$descripcion'";
	$qry = $qry." where id=$id_unidades";
}

if($accion=="eliminar"){
	$qryBloqueo = "select * from unidades where id=$id_unidades for update";
	$qry = "delete from unidades where id=$id_unidades";
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
