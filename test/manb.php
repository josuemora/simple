<?php
ini_set("display_errors",0);
error_reporting(0);

include("func.php");
include("inicia_session_segura.php");

$token = isset($_GET["t"]) ? $_GET["t"] : '';

if(
$_SESSION['_USER_IP'] != getRealIP() ||
$_SESSION['_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] ||
 !isset($_SESSION['accesos'][$token]) || 
 !isset($_SESSION['accesos'][$token]["id_usuarios"]) || 
 !isset($_SESSION['accesos'][$token]["nombre_usuarios"]) ){
	header("location: login.php",true,301);
}
$tema_usuarios = $_SESSION['accesos'][$token]["tema_usuarios"];
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Apps con Bootstrap</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://localhost/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

	<!-- Add jQuery library -->
		<?php
		$directorio  = "jquery-ui-1.10.3.custom/css/";
		$archivo_css = "jquery-ui-1.10.3.custom.min.css";
		$tema = "";
		$temas = array();
		if ($handle = opendir($directorio)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					$entry = trim($entry);			
					$temas[] = $entry;
				}
			}
			closedir($handle);
			asort($temas);
			
			if(trim($tema_usuarios)!=="" && in_array(trim($tema_usuarios),$temas)){
				$tema = $directorio.trim($tema_usuarios)."/".$archivo_css;
				
			}
			
			foreach($temas as $entry){
					$tema = $tema == "" ? $directorio.$entry."/".$archivo_css : $tema;
			}
			
		}
		?>	
   
<link id="estilo1" type="text/css" href="<?php echo $tema; ?>" rel="stylesheet" />
	
<script type="text/javascript" src="jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>

<script type="text/javascript" src="jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>

<script type="text/javascript" src="js/baseb.js"></script>

<style>
#bar_usuario {
	width: 100%;
	float: left;
}
.campos_usuario {
	float:right;
	margin: 10px;
}
#titulo {
	float:left;
	margin: 10px;
}
.botones {
	margin: 10px 10px 0px 0px;
}

.botones button {
	margin: 10px 10px 0px 0px;
}

.tab_usuarios {
	display:block;
}

#menuizq, #menuder, #menuarr, #menuaba {
    position: fixed;
    background-color: #abc;
    margin: 0px;
    padding: 0px;
	/*border:1px solid red;*/
    z-index:9999;
}
#menuizq {
    left: -100%;
    top: 0px;
    width: 50%;
    height: 100%;
}
#menuder {
    left: 100%;;
    top: 0px;
    width: 50%;
    height: 100%;
}
#menuarr {
    top: -100%;
	left: 0px;
    width: 100%;
    height: 100%;
}
#menuaba {
	top: 100%;
	left: 0px;
    width: 100%;
    height: 100%;
}
.regSeleccionado{
	color: blue;
}
input:focus {
    background-color: #FAFAFA;
	color: black;
}
</style>

</head>
<body>
<div id="xtabs">
<!--
<div id="bar_usuario"> 
	<div id="titulo" >Control Manager</div>
	<div class="campos_usuario"><button id="btn_salir" onclick="logout()">Salir</button></div>
	<div class="campos_usuario">Usuario: <?php echo $_SESSION['accesos'][$token]["nombre_usuarios"]; ?></div>
	<div class="campos_usuario">Tema: 


	<select id="xtema" onchange="cambia_tema(<?php echo "'$directorio','$archivo_css'" ?>)">
		<?php
		foreach($temas as $entry){
			$tmp = $entry == trim($tema_usuarios) ? "selected":"" ;
					echo "<option value='$entry' $tmp>$entry</option>"."\n";
		}
		?>
	</select>
	</div>
    <div class="campos_usuario">
    <button onClick="menu('izq')">izq</button>
    <button onClick="menu('der')">der</button>
    <button onClick="menu('arr')">arr</button>
    <button onClick="menu('aba')">aba</button>
    </div>

</div>
-->

<?php
$directorio_mod  = "modulos";
$modulos = array();
if ($handle = opendir($directorio_mod)) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != ".." && substr(trim($entry),-4,4)=='.php') {
			$entry = trim($entry);
			if($_SESSION['accesos'][$token]["nombre_usuarios"]=='Administrador'){
				$modulos[] = $entry;
			}else{
				$part = explode('.',$entry);
				$pos = strpos($_SESSION['accesos'][$token]["botones_usuarios"], $part[0].'-acceso');
				if($pos === false){
				}else{
					if($part[0]!=='usuarios'){
						$modulos[] = $entry;
					}
				}
			}
		}
	}
	closedir($handle);
}
?>	


<ul class="nav nav-tabs" role="tablist">
<?php
$i = 1;
foreach($modulos as $entry){
	$part = explode('.',$entry);
	echo '<li class="seguridad seg_'.$part[0].'-acceso nav-item"><a href="#tabs_'.$i.'"  accesskey="'.$i.'" class="nav-link" data-toggle="tab" role="tab">'.ucfirst($part[0]).'</a></li>'."\n";
	$i = $i + 1;
}
?>	
</ul>

<div class="tab-content">
<?php
$i = 1;
foreach($modulos as $entry){
	$part = explode('.',$entry);
	echo '<div class="tab-pane" id="tabs_'.$i.'" role="tabpanel">'."\n";
	include("modulos/$entry");
	echo "</div>\n";
	$i = $i + 1;
}
?>	
</div>
    
    

<div id="dlg_general" title="">
<div id="mensajes"></div>
</div>

<input type="hidden" id="session_nombre_usuario" name="session_nombre_usuario" value="<?php	echo $_SESSION['accesos'][$token]["nombre_usuarios"]; ?>" />
<input type="hidden" id="session_id_usuario" name="session_id_usuario" value="<?php	echo $_SESSION['accesos'][$token]["id_usuarios"]; ?>" />
<input type="hidden" id="session_tema_usuario" name="session_tema_usuario" value="<?php	echo $_SESSION['accesos'][$token]["tema_usuarios"]; ?>" />
<input type="hidden" id="session_botones_usuario" name="session_botones_usuario" value="<?php	echo $_SESSION['accesos'][$token]["botones_usuarios"]; ?>" />
<input type="hidden" id="token" name="token" value="<?php echo $token; ?>" />


<?php
$directorio_js  = "js";
if ($handle = opendir($directorio_js)) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != ".." && substr(trim($entry),-3,3)=='.js') {
			$entry = trim($entry);

			$part = explode('.',$entry);
		
			$lacceso = $part[0]=='usuarios' && $_SESSION['accesos'][$token]["nombre_usuarios"]!=='Administrador'?false:true;
			$lacceso = $part[0]=='base' ? false : $lacceso;
			if($lacceso){	
				echo '<script type="text/javascript" src="js/'.$entry.'"></script>'."\n";			
			}
		}
	}
	closedir($handle);
}

?>	


<nav id="menuizq"> 
	Menu izq 
	<button onClick="menu('izq');">oculta izq</button>
</nav>
<nav id="menuder"> 
	Menu Der 
	<button onClick="menu('der');">oculta der</button>
</nav>
<nav id="menuarr"> 
	Menu Arriba 
	<button onClick="menu('arr');">oculta arriba</button>
</nav>
<nav id="menuaba"> 
	menu Abajo 
	<button onClick="menu('aba');">oculta abajo</button>
</nav>
<?php
/*
var_dump($_SESSION);
echo "<br><br><br>";
var_dump($cookieParams);
*/
?>
<script>
    // handle jQuery plugin naming conflict between jQuery UI and Bootstrap
	
    $.widget.bridge('uibutton', $.ui.button);
    $.widget.bridge('uitooltip', $.ui.tooltip);
	
</script>
    <!--script src="http://localhost/bootstrap/jquery-3.2.1.slim.min.js"></script-->
    <script src="http://localhost/bootstrap/popper-1.12.3.min.js"></script>
    <script src="http://localhost/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</body>
</html>