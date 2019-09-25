<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$accion       	 = $_POST["accion"];
$id_alumnos  	 = $_POST["id"];
$nombre  = $_POST["nombre"];
$paterno = $_POST["paterno"];
$materno = $_POST["materno"];
$grupos_id = $_POST["grupos_id"];
$sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : 'm';//default m = masculino
$usalentes = isset($_POST["usalentes"]) ? 's' : 'n';//default n = no; s = si
$enfermedad = isset($_POST["enfermedad"]) ? 's' : 'n';//default n = no; s = si
$capacidaddiferente = isset($_POST["capacidaddiferente"]) ? 's' : 'n';//default n = no; s = si

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';


if($accion=="agregar"){
	$when = microtime(true);
	//$micro = sprintf("%06d", ($when - floor($when)) * 1000000);
	//$when = new \DateTime(date('Y-m-d H:i:s.'. $micro, (int) $when));

	//$numero = substr($when->format('YmdHisu'),0,20);	
	//$base62 = convBase($numero, '0123456789', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
	
	$qry = "insert into alumnos (id,nombre,paterno,materno,grupos_id,sexo,usalentes,enfermedad,capacidaddiferente) values ($when,'$nombre','$paterno','$materno',$grupos_id,'$sexo','$usalentes','$enfermedad','$capacidaddiferente')";
}
if($accion=="consultar"){
	$qry = "select id as valor, concat(grado,' ',salon,' ',turno) as texto  from grupos order by id desc";
	
	$cadxml .= "<select_grupo>";
	if($recordset = $vinculo->query($qry)){
		$modulo = 'grupos';
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cadxml .= "<$modulo>";
			foreach($row as $key=>$val){
				$cadxml .= "<$key><![CDATA[$val]]></$key>";
			};
			$cadxml .= "</$modulo>";
		}
		$recordset->closeCursor();
		$recordset = NULL;
	}	
	$cadxml .= "</select_grupo>";
	
	$qry = "select * from alumnos where id='$id_alumnos' limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from alumnos where id='$id_alumnos' for update";
	$qry = "update alumnos set nombre='$nombre',paterno='$paterno',materno='$materno',grupos_id=$grupos_id,sexo='$sexo',usalentes='$usalentes',enfermedad='$enfermedad',capacidaddiferente='$capacidaddiferente'";
	$qry = $qry." where id='$id_alumnos'";
}
if($accion=="eliminar"){
	$qryBloqueo = "select * from alumnos where id='$id_alumnos' for update";
	$qry = "delete from alumnos where id='$id_alumnos'";
}

include("../core/ABC_query_xml_pdo.php");
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
