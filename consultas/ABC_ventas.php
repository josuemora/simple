<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$accion       	= $_POST["accion"];
$id_ventas  	= $_POST["id"];
$clientes_id  	= $_POST["clientes_id"];
$fecha			= $_POST["fecha"];

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';
/*
if($accion=="agregar"){
	$qry = "insert into alumnos (nombre,paterno,materno,grupos_id,sexo,usalentes,enfermedad,capacidaddiferente) values ('$nombre','$paterno','$materno',$grupos_id,'$sexo','$usalentes','$enfermedad','$capacidaddiferente')";
}
*/
if($accion=="consultar"){
	
	if($id_ventas=='0'){
		$qry = "insert into ventas (clientes_id,fecha) values (1,now())"; // por default se asigna al cliente 1=Varios para la integridad...
		@$vinculo->query($qry);
		$qry = "select LAST_INSERT_ID() as contador";
		if($recordset = $vinculo->query($qry)){
			$id_ventas = $recordset->fetch(PDO::FETCH_ASSOC)['contador'];
		}

	}
	
	$qry = "select v.*,c.nombre from ventas v left join clientes c on v.clientes_id=c.id where v.id=$id_ventas limit 1";
}
if($accion=="cambiar" || $accion=="agregar"){
	$qryBloqueo = "select * from ventas where id=$id_ventas for update";
	$qry = "update ventas set clientes_id=$clientes_id,fecha='$fecha'";
	$qry = $qry." where id=$id_ventas";
}
if($accion=="eliminar"){
	$qryBloqueo = "select * from ventas where id=$id_ventas for update";
	$qry = "delete from ventas where id=$id_ventas";
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
