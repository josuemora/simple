<?php
ob_start();
$cadxml = '';
include("../conf.php");
$accion       	 = $_POST["accion"];
$id_usuarios  	 = $_POST["id_usuarios"];
$nombre = $_POST["nombre"];
$botones = $_POST["botones"];
$password	  	 = trim($_POST["password"]);

$botones = isset($_POST["xbtns"]) ? implode(",",(array)$_POST["xbtns"]) : $botones;
//var_dump($_POST["xbtns"]);

//die($_POST["xbtns"]);
/*
$correo		  	 = $_POST["correo"];
$nic		  	 = str_replace(' ','',$_POST["nic"]);
$id_perfiles 	 = $_POST["id_perfiles"];
*/
if($accion=="agregar"){
	$qry = "insert into usuarios (nombre,clave,botones) values ('$nombre',md5('$password'),'$botones')";
}
if($accion=="consultar"){
	$qry = "select * from usuarios where id=$id_usuarios limit 1";
}
if($accion=="cambiar"){
	$qry = "update usuarios set nombre='$nombre',botones='$botones'";
	$qry = $password != '' ? $qry.",clave=md5('$password')" : $qry;
	$qry = $qry." where id=$id_usuarios";
}
if($accion=="eliminar"){
	$qry = "delete from usuarios where id=$id_usuarios";
}

include("ABC_query_xml.php");

ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
