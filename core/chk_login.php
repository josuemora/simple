<?php
ob_start();
$cadxml = '';

include("funciones.php");
include("../config/db_pdo.php");
$usuario	= trim($_POST["usuario"]);
//$pass		= md5(trim($_POST["pass"]));
$pass		= trim($_POST["pass"]);

//$qry = sprintf("select id from usuarios where nombre='%s' and password=md5('%s') and activo='1'",$usuario,$pass);
//$qry = sprintf("select u.id_usuarios from usuarios u left join perfiles p on u.id_perfiles=p.id_perfiles where u.nic='%s' and u.password=md5('%s') and u.activo_usuarios='1' and p.activo_perfiles='1'",$usuario,$pass);
$qry = sprintf("select u.id,u.nombre,u.tema,a.permisos,p.nombre as perfil from simple_seguridad.usuarios u 
				left join simple_seguridad.perfiles p on p.id=u.perfiles_id 
				left join simple_seguridad.accesos a on u.perfiles_id=a.perfiles_id 
				where u.nombre='%s'  and u.clave=md5('%s')",$usuario,$pass);

//echo $qry;

//exit();

//if($recordset=mysql_query( $qry,$vinculo )){
if( $recordset = $vinculo->query($qry)){

	$row = $recordset->fetch(PDO::FETCH_ASSOC);
	if($row["nombre"]==$usuario ){
		//$row = mysql_fetch_array($recordset,MYSQL_ASSOC);
		$id_usuarios = $row["id"];
		session_start();
		session_regenerate_id(true);
		//$_SESSION = array();
		$cuenta_session = isset($_SESSION["cuenta_session"]) ? $_SESSION["cuenta_session"] + 1 : 1;
		$_SESSION["cuenta_session"] = $cuenta_session;
		$token = md5(date("Y-m-d H:i:s.u").'_'.$cuenta_session); 
		$_SESSION["accesos"][$token] = array();
		
		if(!isset($_SESSION['_USER_IP'] )){
			$_SESSION['_USER_IP']    = getRealIP();
		}
		if(!isset($_SESSION['_USER_AGENT'])){
			$_SESSION['_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
		}
		
		$_SESSION["accesos"][$token]["id_usuarios"] = $id_usuarios;
		$_SESSION["accesos"][$token]["nombre_usuarios"] = $usuario;
		$_SESSION["accesos"][$token]["tema_usuarios"] = $row["tema"];
		$_SESSION["accesos"][$token]["botones_usuarios"] = $row["permisos"];
		$_SESSION["accesos"][$token]["perfil_usuarios"] = $row["perfil"];

		$cadxml = '<?xml version="1.0" encoding="utf-8"?><root><estatus>S</estatus><mensaje></mensaje><id>'.$token.'</id></root>';
		
		
	}else{
		$cadxml = '<?xml version="1.0" encoding="utf-8"?><root><estatus>N</estatus><mensaje>no existe usuario o password '.$qry.'</mensaje></root>';
	}
	//mysqli_free_result($recordset);
	$recordset->closeCursor();
}else{
	$cadxml = '<?xml version="1.0" encoding="utf-8"?><root><estatus>N</estatus><mensaje>no hay conexion con bd</mensaje></root>';
}
//mysqli_close($vinculo);

ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo $cadxml;
?>
