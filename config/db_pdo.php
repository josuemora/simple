<?php


/*
// Limpiamos las variables 

array_walk($_POST, 'trim_r');
//$_POST = array_map('trim', $_POST); 
if(get_magic_quotes_gpc()): 
	array_walk($_POST, 'stripslashes_r');
    //$_POST = array_map('stripslashes', $_POST); 
endif; 
//array_walk($_POST, 'mysql_real_escape_string_r');
//$_POST = array_map('mysql_real_escape_string', $_POST); 
$_POST = array_map('filterXSS',$_POST);
*/

	$dbserver 	= "localhost";
	$database 	= "simple_test";
	$user 		= "simple";
	$pswd 		= "12345";	
	
	

try {
	
  $vinculo = new PDO('mysql:host='.$dbserver.';dbname='.$database.';charset=utf8',$user,$pswd);
 
  $vinculo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $vinculo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $vinculo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
  $vinculo->setAttribute(PDO::ATTR_PERSISTENT, false);
  
} catch (Exception $e) {
  die("Falló la Conexión: " . $e->getMessage());
}




?>
