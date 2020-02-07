<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$id_ventas     	= $_POST["nota_id"];
$accion			= "consultar";


include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml 	= '';
$qryBloqueo = '';
$modulo 	= 'ventas2';


$aQry[] = "select * from ventas2 where id=$id_ventas for update;";
$aQry[] = "update ventas2 set status=1 where id=$id_ventas";
$aQry[] = "select * from ventas2 where id=$id_ventas;";

include("../core/ABC_aquerys_xml_pdo.php");


ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
