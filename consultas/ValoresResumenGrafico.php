<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$indicador       	= isset($_POST["indicador"]) ? $_POST["indicador"] : '0';;
//$Anio       		= $_POST["Anio"];
//$Mes       			= $_POST["Mes"];
$Anio = '2019';
$Mes = '12';
$accion				= "consultar";
$modulo 	= 'tablero_';

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$aMeses = array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');

$cadxml 	= '';
$qryBloqueo = '';
$modulo 	= 'ValoresGrafico';


$wAnio = trim($Anio)=='' ? '' : " and re.anio=$Anio ";
$wMes = trim($Mes)=='0' ? '' : " and rd.mes=$Mes ";

$aColors = Array('red'=>'rgb(255, 99, 132)',
	'orange'=>'rgb(255, 159, 64)',
	'yellow'=>'rgb(255, 205, 86)',
	'green'=>'rgb(75, 192, 192)',
	'blue'=>'rgb(54, 162, 235)',
	'purple'=>'rgb(153, 102, 255)',
	'grey'=>'rgb(201, 203, 207)');
	

$datasets = Array();


$qry = "select rd.mes,avg(rd.valor) as promedio,i.descripcion,u.descorta as unidad,u.descripcion as unidesc from regind_det rd left join regind_enc re on re.id=rd.regind_enc_id left join indicadores i on i.id=re.indicadores_id left join unidades u on i.unidades_id=u.id where i.indicador=$indicador group by rd.mes";

$descripcion = '';
$unidad = '';
$unidesc = '';
$dPromedio=array(0,0,0,0,0,0,0,0,0,0,0,0,null);
if($recordset = $vinculo->query($qry)){
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		$dPromedio[$row['mes']-1] = round($row['promedio'],2);
		$descripcion = $row['descripcion'];
		$unidad = '('.$row['unidad'].') '.$row['unidesc'];
		$unidesc = $row['unidesc'];
		//var_dump($row);
	};
};
//var_dump($dPromedio);
//exit();
$datasets[] = Array('type'=>'line','label'=>'Promedio Mensual','backgroundColor'=>'red','borderColor'=>'rgb(201, 203, 207)','borderWidth'=>2,'fill'=>false,'data'=>$dPromedio);

/*
$qry = "select rd.mes,sum(rd.valor) as acumulado,i.descripcion from regind_det rd left join regind_enc re on re.id=rd.regind_enc_id left join indicadores i on i.id=re.indicadores_id where i.indicador=$indicador group by rd.mes,i.descripcion";

$dAcumulado=array(0,0,0,0,0,0,0,0,0,0,0,0);
if($recordset = $vinculo->query($qry)){
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		$dAcumulado[$row['mes']-1] = $row['acumulado'];
	};
};
$datasets[] = Array('type'=>'bar','label'=>'Acumulado','borderColor'=>'white','backgroundColor'=>'red','borderWidth'=>2,'fill'=>false,'data'=>$dAcumulado);
*/

$qry = "select re.anio,rd.mes,sum(rd.valor) as valor from regind_det rd left join regind_enc re on re.id=rd.regind_enc_id left join indicadores i on i.id=re.indicadores_id where i.indicador=$indicador group by re.anio,rd.mes";

if($recordset = $vinculo->query($qry)){
	$pAnio = '';
	$dValores=array(0,0,0,0,0,0,0,0,0,0,0,0,0);
	$nC1 = 0;
	$total_anio = 0;
	$cuenta = 0;
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		if($pAnio == ''){
			$pAnio = $row['anio'];
		};
		
		if($pAnio != $row['anio']){
			$cuenta = $cuenta == 0 ? 1 : $cuenta;
			$dValores[12] = $total_anio;
			$dValores[13] = round($total_anio / $cuenta,2);
			$color1 = array_values($aColors)[$nC1];
			$datasets[] = Array('type'=>'bar','label'=>$pAnio,'borderColor'=>'white','backgroundColor'=>$color1,'borderWidth'=>2,'fill'=>false,'data'=>$dValores);
			$dValores=array(0,0,0,0,0,0,0,0,0,0,0,0,0);
			$pAnio = $row['anio'];
			$nC1 = $nC1 + 1 == count($aColors) - 1 ? 0 : $nC1 + 1;
			$total_anio = 0;
			$cuenta = 0;
		}
		$dValores[$row['mes']-1] = $row['valor'];
		$total_anio = $total_anio + $row['valor'];
		$cuenta = $row['valor'] <> 0  ? $cuenta + 1 : $cuenta;
	};
	if($pAnio != ''){
		$cuenta = $cuenta == 0 ? 1 : $cuenta;
		//$dValores[12] = $total_anio;
		$dValores[12] = round($total_anio / $cuenta,2);
		$datasets[] = Array('type'=>'bar','label'=>$pAnio,'borderColor'=>'white','backgroundColor'=>'blue','borderWidth'=>2,'fill'=>false,'data'=>$dValores);
		
	}
};
$respuesta = array('estatus'=>'S','datasets'=>$datasets,'descripcion'=>$descripcion,'unidad'=>$unidad);

ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
//echo $cadxml;
echo json_encode($respuesta);
?>
