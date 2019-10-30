<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$indicador       	= $_POST["indicador"];
$Anio       		= $_POST["Anio"];
$Mes       			= $_POST["Mes"];
$accion				= "consultar";


include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$aMeses = array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');

$cadxml 	= '';
$qryBloqueo = '';
$modulo 	= 'ValoresGrafico';


$wAnio = trim($Anio)=='' ? '' : " and re.anio=$Anio ";
$wMes = trim($Mes)=='0' ? '' : " and rd.mes=$Mes ";

//select rd.*,re.anio,i.indicador,i.descripcion from regind_det rd left join regind_enc re on re.id=rd.regind_enc_id left join indicadores i on i.id=re.indicadores_id where i.indicador=5090 order by anio,mes;
$qry = "select rd.*,re.anio,i.indicador,i.descripcion,i.digfraccion,u.descorta from metricos0.regind_det rd left join metricos0.regind_enc re on re.id=rd.regind_enc_id left join metricos0.indicadores i on i.id=re.indicadores_id left join metricos0.unidades u on i.unidades_id=u.id where rd.valor<>0 and i.indicador=$indicador $wAnio $wMes order by anio desc,mes desc limit 1;";

if($recordset = $vinculo->query($qry)){
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		$row['mesd'] = $aMeses[$row['mes']];
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
