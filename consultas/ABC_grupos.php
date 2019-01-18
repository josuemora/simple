<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$guardaCache	= isset($_POST["guardaCache"]) ? $_POST["guardaCache"] : '0';
$id_grupos		= isset($_POST["id"]) ? $_POST["id"] : '0';
$accion			= $_POST["accion"];
$grado  		= $_POST["grado"];
$salon 			= $_POST["salon"];
$turno			= $_POST["turno"];

if($guardaCache == '1' && $id_grupos != '0'){

	$cache = serialize($_POST);

	$qryBloqueo = "select * from grupos where id=$id_grupos for update";
	$qry = "update grupos set cache='$cache'";
	$qry = $qry." where id=$id_grupos";
	
};





include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';


if($accion=="agregar" && $guardaCache == '0'){
	$qry = "insert into grupos (grado,salon,turno) values ($grado,'$salon','$turno')";
}
if($accion=="consultar" && $guardaCache == '0'){
	
	$qry = "select cache from grupos where id=$id_grupos limit 1";

	$cache = array();
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cache = unserialize($row['cache']);
		}
		$recordset->closeCursor();
	}
	if(isset($cache['NumRen'])){
		$aTurnos = array();
		foreach($cache['NumRen'] as $NumRen){
			$valor = isset($cache['valor_'.$NumRen]) ? $cache['valor_'.$NumRen] : '';
			$texto = isset($cache['texto_'.$NumRen]) ? $cache['texto_'.$NumRen] : '';
			$turxo = isset($cache['turxo_'.$NumRen]) ? $cache['turxo_'.$NumRen] : '';
			$turx2o = isset($cache['turx2o_'.$NumRen]) ? $cache['turx2o_'.$NumRen] : '';
			$sexo = isset($cache['sexo_'.$NumRen]) ? $cache['sexo_'.$NumRen] : '';
			$usalentes = isset($cache['usalentes_'.$NumRen]) ? $cache['usalentes_'.$NumRen] : '';
			$usalentes = $usalentes == 'on' ? 's' : 'n';
			$aTurnos[] = array('valor'=>$valor,'texto'=>$texto,'turxo'=>$turxo,'turx2o'=>$turx2o,'sexo'=>$sexo,'usalentes'=>$usalentes);
		};
	}else{

		
		$aTurnos = array(array('valor'=>'Matutino','texto'=>'Matutino','turxo'=>'Nocturno','turx2o'=>'Vespertino','sexo'=>'f','usalentes'=>'s'),array('valor'=>'Vespertino','texto'=>'Vespertino','turxo'=>'Vespertino','turx2o'=>'Nocturno','sexo'=>'m','usalentes'=>'s'),array('valor'=>'Nocturno','texto'=>'Nocturno','turxo'=>'Nocturno','turx2o'=>'Vespertino','sexo'=>'f','usalentes'=>'n'),array('valor'=>'a','texto'=>'a','turxo'=>'','turx2o'=>'','sexo'=>'m','usalentes'=>'n'));
	}
	$modulo = 'turnos';
	$cadxml .= "<select_turno>";
	foreach($aTurnos as $row){
		$cadxml .= "<$modulo>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	};
	$cadxml .= "</select_turno>";
	
	
	
	$qry = "select * from grupos where id=$id_grupos limit 1";
}
if($accion=="cambiar" && $guardaCache == '0'){
	$qryBloqueo = "select * from grupos where id=$id_grupos for update";
	$qry = "update grupos set grado=$grado,salon='$salon',turno='$turno',cache=''";
	$qry = $qry." where id=$id_grupos";
}

if($accion=="eliminar" && $guardaCache == '0'){
	$qryBloqueo = "select * from grupos where id=$id_grupos for update";
	$qry = "delete from grupos where id=$id_grupos";
}

include("../core/ABC_query_xml_pdo.php");
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
