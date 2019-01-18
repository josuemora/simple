<?php
ob_start();
include("../core/funciones.php");
checkAcceso();

$accion       	 = $_POST["accion"];
$id_usuarios 	 = $_POST["id_usuarios"];
$password	  	 = trim($_POST["password"]);
$perfiles_id 	 = isset($_POST["perfiles_id"])? $_POST["perfiles_id"] : '';
$nombre 	 	 = isset($_POST["nombre"])? $_POST["nombre"] : '';
$token 			 = isset($_POST["token"]) ? $_POST["token"] : '';

include("../config/db_pdo.php");
//checkPermiso($accion,'alumnos');

$cadxml = '';
$qryBloqueo = '';

if($accion=="agregar"){
	$qry = "insert into simple_seguridad.usuarios (id,nombre,clave,perfiles_id) values ('$id_usuarios','$nombre',md5('$password'),'$perfiles_id')";
}
if($accion=="consultar"){
	$qry = "select id as valor, nombre as texto  from simple_seguridad.perfiles order by nombre";
	
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
	
	$qry = "select * from simple_seguridad.usuarios  where id=$id_usuarios limit 1";
}
if($accion=="cambiar"){
	$qryBloqueo = "select * from simple_seguridad.usuarios where id=$id_usuarios for update";
	$qry = "update simple_seguridad.usuarios set nombre='$nombre',perfiles_id='$perfiles_id'";
	$qry = $password != '' ? $qry.",clave=md5('$password')" : $qry;
	$qry = $qry." where id=$id_usuarios  and nombre<>'Administrador'";
	
	//para cambiar el password del Administrador...
	if($password != '' && $nombre=='Administrador' && $_SESSION['accesos'][$token]["nombre_usuarios"]=='Administrador'){
		$qry = "update simple_seguridad.usuarios set clave=md5('$password')  where id=$id_usuarios ";
	}
	
}
if($accion=="eliminar"){
	$qryBloqueo = "select * from simple_seguridad.usuarios where id=$id_usuarios for update";
	$qry = "delete from simple_seguridad.usuarios where id=$id_usuarios  and nombre<>'Administrador'";
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
