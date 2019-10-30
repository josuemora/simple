<?php
ob_start();
include("funciones.php");
checkAcceso();
$cadxml 	= "";
$modulo 	= $_POST["modulo"];
$token 		= $_POST["token"];
$limite 	= intval($_POST["limite"]);
$pagina		= intval($_POST["pagina"]);

$pagina = $pagina<=0 ? 0 : $pagina;
$limite = $limite<=0 ? 5 : $limite;
$offset = $pagina * $limite;// - $limite;

$where = '';
$orderby = '';
$aordenby = array();

if(isset($_POST['filtro_oplogico'])){
	foreach($_POST['filtro_oplogico'] as $key=>$val){
		$cadw = $key==0 ? '' : " $val ";
		$cadw .= $_POST['filtro_campo'][$key];
		if($_POST['filtro_opcomparacion'][$key]=='LIKE'){
			$cadw .= " LIKE '%".$_POST['filtro_valor'][$key]."%'";
		}else{
			$cadw .= " ".$_POST['filtro_opcomparacion'][$key]." '".$_POST['filtro_valor'][$key]."'";
		}
		$where .= $cadw;
		
		if($_POST['filtro_ordenable'][$key] !== ''){
			$aordenby[] = $_POST['filtro_campo'][$key]." ".$_POST['filtro_ordenable'][$key];
		}	
	}
	$where = "where $where";
	$orderby = count($aordenby) == 0 ? '' : "Order by ".implode(',',$aordenby);
}
//echo $where;exit();


include("../config/db_pdo.php");
include("../consultas/QuerysPorModulo.php");

$qry = sprintf($aModqry[$modulo]." %s %s limit %s,%s",$where,$orderby,$offset,$limite);
$qryCount = sprintf("select count(*) as rowsCount from (".$aModqry[$modulo]." %s ) as CuentaRen",$where);


if($recordset = $vinculo->query($qry)){
	$rowid = $offset;
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		$cadxml .= "<$modulo>";
		$rowid = $rowid + 1;
		$cadxml .= "<rowid><![CDATA[$rowid]]></rowid>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	}
	$recordset->closeCursor();
}


if($recordset = $vinculo->query($qryCount)){
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
	}
	$recordset->closeCursor();
}


if(isset($aModTotqry[$modulo])){
	$qry2 = sprintf($aModTotqry[$modulo]." %s",$where);

	if($recordset = $vinculo->query($qry2)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cadxml .= "<$modulo>";
			foreach($row as $key=>$val){
				$cadxml .= "<$key><![CDATA[$val]]></$key>";
			};
			$cadxml .= "</$modulo>";
		}
		$recordset->closeCursor();
	}
}




$vinculo = null;

//sleep(1);

$cadxml = '<?xml version="1.0" encoding="utf-8"?><root>'.$cadxml.'<qry><![CDATA['.$qry.']]></qry><qry2><![CDATA['.$qry2.']]></qry2><qry3><![CDATA['.$qryCount.']]></qry3></root>';
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
