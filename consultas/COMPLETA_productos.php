<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$cadena_buscar       	= $_POST["cadena_buscar"];
$accion					= "consultar";


include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml 	= '';
$qryBloqueo = '';
$modulo 	= 'producto';


$qry = "select id,descripcion,format(precio,2) as precio from productos where id like '%$cadena_buscar%' or descripcion like '%$cadena_buscar%'";

if($recordset = $vinculo->query($qry)){
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		$cadxml .= "<$modulo>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	};
	$recordset = NULL;
};

$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>S</estatus><mensaje><![CDATA['.$qry.']]></mensaje>'.$cadxml.'</root>';
	


ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
