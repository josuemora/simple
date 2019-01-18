<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$accion       	= $_POST["accion"];
$id_detventas  	= $_POST["id"];
$ventas_id  	= $_POST["ventas_id"];
$productos_id  	= $_POST["productos_id"];
$cantidad		= $_POST["cantidad"];
$precio			= $_POST["precio"];

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';

if($accion=="agregar"){
	$qry = "insert into detventas (ventas_id,productos_id,cantidad,precio) values ($ventas_id,$productos_id,$cantidad,$precio)";
}

if($accion=="consultar"){
	/*
	if($id_ventas=='0'){
		$qry = "insert into ventas (clientes_id,fecha) values (1,now())"; // por default se asigna al cliente 1=Varios para la integridad...
		@$vinculo->query($qry);
		$qry = "select LAST_INSERT_ID() as contador";
		if($recordset = $vinculo->query($qry)){
			$id_ventas = $recordset->fetch(PDO::FETCH_ASSOC)['contador'];
		}

	}
	*/
	
	$qry = "select d.*,p.descripcion from detventas d left join productos p on d.productos_id=p.id where d.id=$id_detventas limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from detventas where id=$id_detventas for update";
	$qry = "update detventas set ventas_id=$ventas_id,productos_id=$productos_id,cantidad=$cantidad,precio=$precio";
	$qry = $qry." where id=$id_detventas";
}
if($accion=="eliminar"){
	$qryBloqueo = "select * from detventas where id=$id_detventas for update";
	$qry = "delete from detventas where id=$id_detventas";
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
