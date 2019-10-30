<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$guardaCache	= isset($_POST["guardaCache"]) ? $_POST["guardaCache"] : '0';
$id_re			= isset($_POST["id"]) ? $_POST["id"] : '0';


$accion       	= $_POST["accion"];
$indicadores_id = $_POST["indicadores_id"];
$anio			= $_POST["anio"];

$modulo = 'registro';

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$aQry = Array();

if($accion=="consultar" ){

/*	
	$aMeses = array(array('valor'=>'1','texto'=>'Ene'),array('valor'=>'2','texto'=>'Feb'),array('valor'=>'3','texto'=>'Mar'),array('valor'=>'4','texto'=>'Abr'),array('valor'=>'5','texto'=>'May'),array('valor'=>'6','texto'=>'Jun'),array('valor'=>'7','texto'=>'Jul'),array('valor'=>'8','texto'=>'Ago'),array('valor'=>'9','texto'=>'Sep'),array('valor'=>'10','texto'=>'Oct'),array('valor'=>'11','texto'=>'Nov'),array('valor'=>'12','texto'=>'Dic'));
	
	$modulo = 'lista_meses';
	$cadxml .= "<select_mes>";
	foreach($aMeses as $row){
		$cadxml .= "<$modulo>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	};
	$cadxml .= "</select_mes>";
*/	
	
	
	
/*	
	if($id_ventas=='0'){
		$qry = "insert into ventas2 (clientes_id,fecha) values (1,now())"; // por default se asigna al cliente 1=Varios para la integridad...
		@$vinculo->query($qry);
		$qry = "select LAST_INSERT_ID() as contador";
		if($recordset = $vinculo->query($qry)){
			$id_ventas = $recordset->fetch(PDO::FETCH_ASSOC)['contador'];
		}

	}
*/	

	$aMeses = array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	//checar si hay registros en tabla detalle...
	//$qry = "select v.*,p.descripcion,format(v.cantidad*v.precio,2) as importe from detventas2 v left join productos p on v.productos_id=p.id where v.ventas_id=$id_ventas";

	$qry = "select rd.* from regind_det rd where rd.regind_enc_id=$id_re";
	
	$aRegs = array();
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$row['mesd'] = $aMeses[$row['mes']];
			$aRegs[] = $row;
		}
		$recordset->closeCursor();
	}
	if(count($aRegs)==0){
		//en caso de que no tenga registros se crean los registros en cache
		for($i=1;$i<13;$i++){
		$aRegs[] = array('ren'=>$i,'regind_enc_id'=>$id_re,'mes'=>$i,'valor'=>0,'meta'=>0,'minimo'=>0,'excelente'=>0,'notas'=>'','mesd'=>$aMeses[$i]);
		}
	}
	
	
	$modulo = 'regind_det';
	$cadxml .= "<tregind_det>";
	foreach($aRegs as $row){
		$cadxml .= "<$modulo>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	};
	$cadxml .= "</tregind_det>";

/*
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
	
*/
	//lectura de la tabla maestra (regind_enc)...
	$aQry[] = "select re.*,i.indicador,i.descripcion,i.digfraccion from regind_enc re left join indicadores i on re.indicadores_id=i.id where re.id=$id_re limit 1";
}
/*
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
*/
if($accion=="cambiar" || $accion=="agregar"){
	if($accion=="agregar"){
		$qry = "insert into regind_enc (indicadores_id,anio) values ($indicadores_id,$anio)";
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
			$id_re = $recordset->fetch(PDO::FETCH_ASSOC)['contador'];
		}
	};
	if($accion=="cambiar"){
		$aQry[] = "select * from regind_enc where id=$id_re for update;";
		$aQry[] = "update regind_enc set indicadores_id=$indicadores_id,anio=$anio where id=$id_re";
	};
	$aQry[] = "select * from regind_det where regind_enc_id=$id_re for update;";
	$aQry[] = "delete from regind_det where regind_enc_id=$id_re;";
	if(isset($_POST['NumRen'])){
		foreach($_POST['NumRen'] as $NumRen){
			//$mes = isset($_POST['mes_'.$NumRen]) ? trim($_POST['mes_'.$NumRen]) : '0';
			$valor = isset($_POST['valor_'.$NumRen]) ? trim($_POST['valor_'.$NumRen]) : '0';
			$meta = isset($_POST['meta_'.$NumRen]) ? trim($_POST['meta_'.$NumRen]) : '0';
			$minimo = isset($_POST['minimo_'.$NumRen]) ? trim($_POST['minimo_'.$NumRen]) : '0';
			$excelente = isset($_POST['excelente_'.$NumRen]) ? trim($_POST['excelente_'.$NumRen]) : '0';
			$notas = isset($_POST['notas_'.$NumRen]) ? trim($_POST['notas_'.$NumRen]) : '';
			if(strlen($NumRen)>0 && strlen($id_re)>0 && strlen($valor)>0 && strlen($meta)>0 && strlen($minimo)>0 && strlen($excelente)>0){
				$aQry[] = "insert into regind_det (ren,regind_enc_id,mes,valor,meta,minimo,excelente,notas) values ($NumRen,$id_re,$NumRen,$valor,$meta,$minimo,$excelente,'$notas');";
			}
		};
	}
	//$aQry[] = "select sum(cantidad) as sumcantidad,sum(cantidad*precio) as sumimporte from detventas2 v where  v.ventas_id=$id_ventas limit 1;";
	$aQry[] = "select count(*) as numregs from regind_det rd where  rd.regind_enc_id=$id_re limit 1;";

	$accion="consultar";
	$cadaux1 = "Totales";

}
if($accion=="eliminar"){
	$aQry[] = "select * from regind_det where regind_enc_id=$id_re for update;";
	$aQry[] = "delete from regind_det where regind_enc_id=$id_re;";
	$aQry[] = "select * from regind_enc where id=$id_re for update;";
	$aQry[] = "delete from regind_enc where id=$id_re;";
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
