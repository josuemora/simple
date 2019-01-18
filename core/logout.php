<?php
ob_start();
$token = isset($_POST["t"]) ? trim($_POST["t"]) : '';
//session_id('simple4');
session_start();

if($token != ''){

	if(isset($_SESSION['accesos'][$token])){
		$_SESSION['ultimo_tema'] = $_SESSION["accesos"][$token]["tema_usuarios"];
		
		$_SESSION['accesos'][$token] = array();
		unset($_SESSION['accesos'][$token]);
		
			
	}
}
session_regenerate_id(true);
/*
session_unset();
session_destroy();
session_start();
*/

//ob_end_flush();
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/plain');
echo '<?xml version="1.0" encoding="utf-8"?><root><estatus>S</estatus><mensaje></mensaje></root>';
?>
