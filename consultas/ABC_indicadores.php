<?php
ob_start();
include("../core/funciones.php");
checkAcceso();


$accion       	 = $_POST["accion"];
$id_indicadores	 = $_POST["id"];
$indicador		 = $_POST["indicador"];
$descripcion	 = $_POST["descripcion"];
$usuarios 		 = isset($_POST["usuarios"]) ? "[".implode("],[",(array)$_POST["usuarios"])."]" : '';
$digfraccion	 = $_POST["digfraccion"];
$areas_id		 = $_POST["areas_id"];
$unidades_id	 = $_POST["unidades_id"];
$graficar		 = $_POST["graficar"];

$modulo = 'indicadores';


include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';


if($accion=="agregar"){
	$qry = "insert into indicadores (indicador,descripcion,usuarios,digfraccion,areas_id,unidades_id,graficar) values ($indicador,'$descripcion','$usuarios',$digfraccion,$areas_id,$unidades_id,'$graficar')";
}
if($accion=="consultar"){

	$qry = "select u.id as usuarios_id,u.nombre from manufactura_seguridad.usuarios u left join manufactura_seguridad.perfiles p on p.id=u.perfiles_id where p.nombre<>'Administrador'";

	$modulo = 'lusuarios';
	$cadxml .= "<lista_usuarios>";
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cadxml .= "<$modulo>";
			foreach($row as $key=>$val){
				$cadxml .= "<$key><![CDATA[$val]]></$key>";
			};
			$cadxml .= "</$modulo>";
		}
		$recordset->closeCursor();
	}
	$cadxml .= "</lista_usuarios>";



	$qry = "select a.id as valor, a.descorta as texto from areas a";

	$modulo = 'areas';
	$cadxml .= "<lista_areas>";
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cadxml .= "<$modulo>";
			foreach($row as $key=>$val){
				$cadxml .= "<$key><![CDATA[$val]]></$key>";
			};
			$cadxml .= "</$modulo>";
		}
		$recordset->closeCursor();
	}
	$cadxml .= "</lista_areas>";

	$qry = "select u.id as valor, u.descorta as texto from unidades u";

	$modulo = 'unidades';
	$cadxml .= "<lista_unidades>";
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cadxml .= "<$modulo>";
			foreach($row as $key=>$val){
				$cadxml .= "<$key><![CDATA[$val]]></$key>";
			};
			$cadxml .= "</$modulo>";
		}
		$recordset->closeCursor();
	}
	$cadxml .= "</lista_unidades>";

	$aGraficar = array(array('valor'=>'Ultimo valor','texto'=>'Ultimo valor'),array('valor'=>'Promedio','texto'=>'Promedio'),array('valor'=>'Acumulado','texto'=>'Acumulado'));

	$modulo = 'lgraficar';
	$cadxml .= "<lista_graficar>";
	foreach($aGraficar as $row){
		$cadxml .= "<$modulo>";
		foreach($row as $key=>$val){
			$cadxml .= "<$key><![CDATA[$val]]></$key>";
		};
		$cadxml .= "</$modulo>";
	};
	$cadxml .= "</lista_graficar>";


	$qry = "select * from indicadores where id=$id_indicadores limit 1";
	
	

}
if($accion=="cambiar"){
	$qryBloqueo = "select * from indicadores where id=$id_indicadores for update";
	$qry = "update indicadores set indicador=$indicador, descripcion='$descripcion', usuarios='$usuarios',digfraccion=$digfraccion, areas_id=$areas_id, unidades_id=$unidades_id, graficar='$graficar'";
	$qry = $qry." where id=$id_indicadores";
}

if($accion=="eliminar"){
	$qryBloqueo = "select * from indicadores where id=$id_indicadores for update";
	$qry = "delete from indicadores where id=$id_indicadores";
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
