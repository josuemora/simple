<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$guardaCache	= isset($_POST["guardaCache"]) ? $_POST["guardaCache"] : '0';
$id_ventas		= isset($_POST["id"]) ? $_POST["id"] : '0';


$accion       	= $_POST["accion"];
$clientes_id  	= $_POST["clientes_id"];
$fecha			= $_POST["fecha"];

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$aQry = Array();

if($accion=="consultar" ){
	
	if($id_ventas=='0'){
		$qry = "insert into ventas2 (clientes_id,fecha) values (1,now())"; // por default se asigna al cliente 1=Varios para la integridad...
		@$vinculo->query($qry);
		$qry = "select LAST_INSERT_ID() as contador";
		if($recordset = $vinculo->query($qry)){
			$id_ventas = $recordset->fetch(PDO::FETCH_ASSOC)['contador'];
		}

	}
	//checar si hay registros en tabla detalle...
	$qry = "select v.*,p.descripcion,format(v.cantidad*v.precio,2) as importe from detventas2 v left join productos p on v.productos_id=p.id where v.ventas_id=$id_ventas";
	
	$aRegs = array();
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$aRegs[] = $row;
		}
		$recordset->closeCursor();
	}
	if(count($aRegs)==0){
		//en caso de que no tenga registros se crea un registro en cache
		$aRegs[] = array('ren'=>1,'ventas_id'=>$ventas_id,'productos_id'=>0,'cantidad'=>0,'precio'=>0,'importe'=>0);
	}
	
	
	$modulo = 'tdventas2';
	$cadxml .= "<detventas2>";
	foreach($aRegs as $row){
		$cadxml .= "<$modulo>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	};
	$cadxml .= "</detventas2>";


$qry = "select sum(cantidad) as sumcantidad,sum(cantidad*precio) as sumimporte from detventas2 v where  v.ventas_id=$id_ventas limit 1;";

	$modulo = 'Totales';
	if($recordset = $vinculo->query($qry)){
		$cadxml .= "<$modulo>";
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			foreach($row as $key=>$val){
				$cadxml .= "<$key><![CDATA[$val]]></$key>";
			};
		};
		$cadxml .= "</$modulo>";
	};
	

	//lectura de la tabla maestra (ventas2)...
	$aQry[] = "select v.*,c.nombre from ventas2 v left join clientes c on v.clientes_id=c.id where v.id=$id_ventas limit 1";
}
if($accion=="cambiar" || $accion=="agregar"){
	$aQry[] = "select * from ventas2 where id=$id_ventas for update;";
	$aQry[] = "update ventas2 set clientes_id=$clientes_id,fecha='$fecha' where id=$id_ventas";
	$aQry[] = "select * from detventas2 where ventas_id=$id_ventas for update;";
	$aQry[] = "delete from detventas2 where ventas_id=$id_ventas;";
	if(isset($_POST['NumRen'])){
		foreach($_POST['NumRen'] as $NumRen){
			$productos_id = isset($_POST['productos_id_'.$NumRen]) ? trim($_POST['productos_id_'.$NumRen]) : '0';
			$cantidad = isset($_POST['cantidad_'.$NumRen]) ? trim($_POST['cantidad_'.$NumRen]) : '0';
			$precio = isset($_POST['precio_'.$NumRen]) ? trim($_POST['precio_'.$NumRen]) : '0';
			if(strlen($NumRen)>0 && strlen($id_ventas)>0 && strlen($productos_id)>0 && strlen($cantidad)>0 && strlen($precio)>0){
				$aQry[] = "insert into detventas2 (ren,ventas_id,productos_id,cantidad,precio) values ($NumRen,$id_ventas,$productos_id,$cantidad,$precio);";
			}
		};
	}
	$aQry[] = "select sum(cantidad) as sumcantidad,sum(cantidad*precio) as sumimporte from detventas2 v where  v.ventas_id=$id_ventas limit 1;";

	$accion="consultar";
	$cadaux1 = "Totales";

}
if($accion=="eliminar"){
	$aQry[] = "select * from detventas2 where ventas_id=$id_ventas for update;";
	$aQry[] = "delete from detventas2 where ventas_id=$id_ventas;";
	$aQry[] = "select * from ventas2 where id=$id_ventas for update;";
	$aQry[] = "delete from ventas2 where id=$id_ventas;";
}

include("../core/ABC_aquerys_xml_pdo.php");

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
