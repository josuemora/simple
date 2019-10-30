<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$guardaCache	= isset($_POST["guardaCache"]) ? $_POST["guardaCache"] : '0';
$id_m			= isset($_POST["id"]) ? $_POST["id"] : '0';


$accion       	= $_POST["accion"];
$comentario = $_POST["comentario"];

$modulo = 'marcos';

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$aQry = Array();

if($accion=="consultar" ){


	$aMeses = array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	//checar si hay registros en tabla detalle...
	//$qry = "select v.*,p.descripcion,format(v.cantidad*v.precio,2) as importe from detventas2 v left join productos p on v.productos_id=p.id where v.ventas_id=$id_ventas";

	$qry = "select md.* from marco_det md where md.marco_enc_id=$id_m";
	
	$aRegs = array();
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			//$row['mesd'] = $aMeses[$row['mes']];
			$aRegs[] = $row;
		}
		$recordset->closeCursor();
	}
	if(count($aRegs)==0){
		//en caso de que no tenga registros se crean los registros en cache
		for($i=1;$i<2;$i++){
		$aRegs[] = array('ren'=>$i,'marco_enc_id'=>$id_m,'ind1'=>0,'ind2'=>0,'ind3'=>0,'ind4'=>0);
		}
	}
	
	
	$modulo = 'marco_det';
	$cadxml .= "<tmarco_det>";
	foreach($aRegs as $row){
		$cadxml .= "<$modulo>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	};
	$cadxml .= "</tmarco_det>";

	//lectura de la tabla maestra (regind_enc)...
	$aQry[] = "select me.* from marco_enc me where me.id=$id_m limit 1";
}
if($accion=="cambiar" || $accion=="agregar"){
	if($accion=="agregar"){
		$qry = "insert into marco_enc (comentario) values ('$comentario')";
		try {
			$vinculo->beginTransaction();
			$recordset = $vinculo->query($qry);
			$vinculo->commit();
			$recordset->closeCursor();
			$recordset = NULL;
		} catch (Exception $e) {
			$vinculo->rollBack();
			$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>N</estatus><mensaje><![CDATA[Error de Query ('.$qry.') ('.$e->getMessage().')]]></mensaje></root>';
			ob_end_clean();
			header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
			header( 'Cache-Control: no-store, no-cache, must-revalidate' );
			header( 'Cache-Control: post-check=0, pre-check=0', false );
			header( 'Pragma: no-cache' );
			header('Content-type: text/plain');
			echo $cadxml;
			exit();

		}
		$qry = "select LAST_INSERT_ID() as contador";
		if($recordset = $vinculo->query($qry)){
			$id_m = $recordset->fetch(PDO::FETCH_ASSOC)['contador'];
		}
	};
	if($accion=="cambiar"){
		$aQry[] = "select * from marco_enc where id=$id_m for update;";
		$aQry[] = "update marco_enc set comentario='$comentario' where id=$id_m";
	};
	$aQry[] = "select * from marco_det where marco_enc_id=$id_m for update;";
	$aQry[] = "delete from marco_det where marco_enc_id=$id_m;";
	if(isset($_POST['NumRen'])){
		foreach($_POST['NumRen'] as $NumRen){
			$ind1 = isset($_POST['ind1_'.$NumRen]) ? trim($_POST['ind1_'.$NumRen]) : '0';
			$ind2 = isset($_POST['ind2_'.$NumRen]) ? trim($_POST['ind2_'.$NumRen]) : '0';
			$ind3 = isset($_POST['ind3_'.$NumRen]) ? trim($_POST['ind3_'.$NumRen]) : '0';
			$ind4 = isset($_POST['ind4_'.$NumRen]) ? trim($_POST['ind4_'.$NumRen]) : '0';
			if(strlen($NumRen)>0 && strlen($ind1)>0 && strlen($ind2)>0 && strlen($ind3)>0 && strlen($ind4)>0 ){
				$aQry[] = "insert into marco_det (ren,marco_enc_id,ind1,ind2,ind3,ind4) values ($NumRen,$id_m,$ind1,$ind2,$ind3,$ind4);";
			}
		};
	}
	//$aQry[] = "select sum(cantidad) as sumcantidad,sum(cantidad*precio) as sumimporte from detventas2 v where  v.ventas_id=$id_ventas limit 1;";
	$aQry[] = "select count(*) as numregs from marco_det md where  md.marco_enc_id=$id_m limit 1;";

	$accion="consultar";
	$cadaux1 = "Totales";

}
if($accion=="eliminar"){
	$aQry[] = "select * from marco_det where marco_enc_id=$id_m for update;";
	$aQry[] = "delete from marco_det where marco_enc_id=$id_m;";
	$aQry[] = "select * from marco_enc where id=$id_m for update;";
	$aQry[] = "delete from marco_enc where id=$id_m;";
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
