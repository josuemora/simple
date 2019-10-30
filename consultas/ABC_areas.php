<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$accion       	 = $_POST["accion"];
$id_areas	 = $_POST["id"];
$descorta		 = $_POST["descorta"];
$descripcion	 = $_POST["descripcion"];

$modulo = 'areas';

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');


$cadxml = '';
$qryBloqueo = '';


if($accion=="agregar"){
	$qry = "insert into areas (descorta,descripcion) values ('$descorta','$descripcion')";
}
if($accion=="consultar"){

	$qry = "select * from areas where id=$id_areas limit 1";
	
	

}
if($accion=="cambiar"){
	$qryBloqueo = "select * from areas where id=$id_areas for update";
	$qry = "update areas set descorta='$descorta', descripcion='$descripcion'";
	$qry = $qry." where id=$id_areas";
}

if($accion=="eliminar"){
	$qryBloqueo = "select * from areas where id=$id_areas for update";
	$qry = "delete from areas where id=$id_areas";
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
