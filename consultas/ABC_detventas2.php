<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$NumRen       	= $_POST["NumRen"];
$productos_id	= $_POST["productos_id"];
$id_ventas		= $_POST["ventas_id"];
$cantidad		= $_POST["cantidad"];
$precio			= $_POST["precio"];


//validaciones
$cantidad 	= floatval($cantidad);
$precio		= floatval($precio);

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml 	= '';
$qryBloqueo = '';
$modulo 	= 'producto';


	$aQry[] = "select * from detventas2 where ren=$NumRen and ventas_id=$id_ventas for update;";
	$aQry[] = "delete from detventas2 where ren=$NumRen and ventas_id=$id_ventas;";
	$aQry[] = "insert into detventas2 (ren,ventas_id,productos_id,cantidad,precio) values ($NumRen,$id_ventas,$productos_id,$cantidad,$precio);";
	
	$aQryR[] = array("modulo"=>"Registro","qry"=>"select v.*,p.descripcion,format(v.cantidad*v.precio,2) as importe from detventas2 v left join productos p on v.productos_id=p.id where v.ren=$NumRen and v.ventas_id=$id_ventas limit 1");

	$aQryR[] = array("modulo"=>"Totales","qry"=>"select sum(cantidad) as sumcantidad,sum(cantidad*precio) as sumimporte from detventas2 where ventas_id=$id_ventas;");
	
	try {
		$vinculo->beginTransaction();
		foreach($aQry as $qry){
			$recordset = $vinculo->query($qry);
		}

		foreach($aQryR as $qryR){
			$modulo = $qryR['modulo'];
			$qry = $qryR['qry'];
			$cadxml .= "<$modulo>";
			if($recordset = $vinculo->query($qry)){
				while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
					foreach($row as $key=>$val){
						$cadxml .= "<$key><![CDATA[$val]]></$key>";
					};
				};
				$recordset = NULL;
			};
			$cadxml .= "</$modulo>";
		};

		$vinculo->commit();
		$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>S</estatus><mensaje><![CDATA['.$qry.']]></mensaje>'.$datos_consulta.$cadxml.'</root>';
	} catch (Exception $e) {
		$vinculo->rollBack();
		$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>N</estatus><mensaje><![CDATA[Error de Query ('.$qry.') ('.$e->getMessage().')]]></mensaje></root>';

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
