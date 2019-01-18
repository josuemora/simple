<?php
ob_start();
$cadxml = '';
include("../conf_pdo.php");
$accion       	 = $_POST["accion"];
$id_grupos  	 = $_POST["id_grupos"];
$grado  = $_POST["grado"];
$salon 	= $_POST["salon"];
$turno	= $_POST["turno"];

$qryBloqueo = '';


if($accion=="agregar"){
	$qry = "insert into grupos (grado,salon,turno) values ($grado,'$salon','$turno')";
}
if($accion=="consultar"){
	$qry = "select * from grupos where id=$id_grupos limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from grupos where id=$id_grupos for update";
	$qry = "update grupos set grado=$grado,salon='$salon',turno='$turno'";
	$qry = $qry." where id=$id_grupos";
}

if($accion=="eliminar"){
	$qryBloqueo = "select * from grupos where id=$id_grupos for update";
	$qry = "delete from grupos where id=$id_grupos";
}

include("ABC_query_xml_pdo.php");
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
