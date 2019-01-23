<?php
ob_start();
include("funciones.php");
checkAcceso();
$cadxml = '';
include("../config/db_pdo.php");
$id_usuario	= trim($_POST["session_id_usuario"]);
$tema		= trim($_POST["tema"]);
$token = isset($_POST["token"]) ? trim($_POST["token"]) : '';
if($token != ''){
	session_start();
	$_SESSION["accesos"][$token]["tema_usuarios"] = $tema;
	session_write_close();//close flush session
	$qry = sprintf("update simple_seguridad.usuarios set tema='%s' where id=%s",$tema,$id_usuario);
	$qryBloqueo = "select * from simple_seguridad.usuarios where id=$id_usuario for update";	
	include("ABC_query_xml_pdo.php");

}
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
