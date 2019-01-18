<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$accion       	 = $_POST["accion"];
$id_accesos 	 = $_POST["id_accesos"];
//$appid 			 = $_POST['appid'];
$perfiles_id 	 = $_POST["perfiles_id"];
$permisos 		 = isset($_POST["permiso"]) ? implode(",",(array)$_POST["permiso"]) : '';
include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';

if($accion=="agregar"){
	$qry = "insert into simple_seguridad.accesos (perfiles_id,permisos) values ('$perfiles_id','$permisos')";
}
if($accion=="consultar"){
	$qry = "select id as valor, nombre as texto  from simple_seguridad.perfiles where nombre<>'Administrador' order by nombre";
	
	$cadxml .= "<select_perfil>";
	if($recordset = $vinculo->query($qry)){
		$modulo = 'perfiles';
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cadxml .= "<$modulo>";
			foreach($row as $key=>$val){
				$cadxml .= "<$key><![CDATA[$val]]></$key>";
			};
			$cadxml .= "</$modulo>";
		}
		$recordset->closeCursor();
	}	
	$cadxml .= "</select_perfil>";
	
	$qry = "select * from simple_seguridad.accesos where id=$id_accesos limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from simple_seguridad.accesos where id=$id_accesos for update";
	$qry = "update simple_seguridad.accesos set perfiles_id='$perfiles_id',permisos='$permisos'";
	$qry = $qry." where id=$id_accesos";
}
if($accion=="eliminar"){
	$qryBloqueo = "select * from simple_seguridad.accesos where id=$id_accesos for update";
	$qry = "delete from simple_seguridad.accesos where id=$id_accesos";
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
