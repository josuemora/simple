<?php
ob_start();
include("funciones.php");
checkAcceso();
$cadxml 	= "";
$exportarExcel = isset($_REQUEST["exportarExcel"]) ? $_REQUEST["exportarExcel"] : '0' ;
$modulo 	= $_REQUEST["modulo"];
$token 		= $_REQUEST["token"];
$limite 	= intval($_REQUEST["limite"]);
$pagina		= intval($_REQUEST["pagina"]);

$pagina = $pagina<=0 ? 0 : $pagina;
$limite = $limite<=0 ? 5 : $limite;
$offset = $pagina * $limite;// - $limite;

$where = '';
$orderby = '';
$aordenby = array();



if(isset($_REQUEST['filtro_oplogico'])){
	foreach($_REQUEST['filtro_oplogico'] as $key=>$val){
		$cadw = $key==0 ? '' : " $val ";
		$cadw .= $_REQUEST['filtro_campo'][$key];
		if($_REQUEST['filtro_opcomparacion'][$key]=='LIKE'){
			$cadw .= " LIKE '%".$_REQUEST['filtro_valor'][$key]."%'";
		}else{
			$cadw .= " ".$_REQUEST['filtro_opcomparacion'][$key]." '".$_REQUEST['filtro_valor'][$key]."'";
		}
		$where .= $cadw;
		
		if($_REQUEST['filtro_ordenable'][$key] !== ''){
			$aordenby[] = $_REQUEST['filtro_campo'][$key]." ".$_REQUEST['filtro_ordenable'][$key];
		}	
	}
	$where = "where $where";
	$orderby = count($aordenby) == 0 ? '' : "Order by ".implode(',',$aordenby);
}
//echo $where;exit();


include("../config/db_pdo.php");
include("../consultas/QuerysPorModulo.php");

$qry = sprintf($aModqry[$modulo]." %s %s",$where,$orderby);

if($exportarExcel == '0'){
	
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
	exit();

}elseif($exportarExcel == '1'){//exportarExcel == '1'

  // filename for download
  $filename = $modulo."_" . date('Ymd') . ".csv";
  ob_end_clean();
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv; charset=UTF-16LE");

  $out = fopen("php://output", 'w');

  $flag = false;
  if($recordset = $vinculo->query($qry)){
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		if(!$flag) {
		  // display field/column names as first row
		  fputcsv($out, array_keys($row), ',', '"');
		  $flag = true;
		};
		array_walk($row, __NAMESPACE__ . '\cleanData');
		fputcsv($out, array_values($row), ',', '"');
	};
	$recordset->closeCursor();
  };

  fclose($out);
  exit();
 }; 
		/*
		$rowid = $offset;
		$cadxml = '<table>';
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cadxml .= "<tr>";
			$rowid = $rowid + 1;
			$cadxml .= "<td>$rowid</td>";
			foreach($row as $key=>$val){
				$cadxml .= "<td>$val</td>";
			};
			$cadxml .= "</tr>";
		}
		$cadxml .= '</table>';
		$recordset->closeCursor();
		*/

/*
  if($recordset = $vinculo->query($qry)){
		$flag = false;
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			if (!$flag) {
				// display field/column names as first row
				$cadxml .= implode("\t", array_keys($row)) . "\r\n";
				$flag = true;
			}
			$cadxml .= implode("\t", array_values($row)) . "\r\n";
		}
		$recordset->closeCursor();
		
		
		
	}

	ob_end_clean();
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$modulo.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $cadxml;
*/

?>
