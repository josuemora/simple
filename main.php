<?php
ob_start();
//ini_set("display_errors",0);
//error_reporting(0);

include("core/funciones.php");
checkAcceso('login.php');
//include("inicia_session_segura.php");



$appid = isset($_REQUEST["appid"]) ? $_REQUEST["appid"] : 0;//Default 0 = home
$token = isset($_REQUEST["token"]) ? $_REQUEST["token"] : '';
$version = date('YmdHis').substr((string)microtime(), 1, 8); //0.001
$tema_usuarios = $_SESSION['accesos'][$token]["tema_usuarios"];


include("config/apps.php");
checkApp($aApps,$appid,'login.php');


ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/html');
?>
<!doctype html>
<html>
<!-- html manifest="appcache.php<?php echo '?v='.$version; ?>" -->

<head>
<meta charset="utf-8">
<title>Manufactura</title>
	<!-- Add jQuery library -->
		<?php
		$dir_url	 = $config_apps['jquery-ui_temas_dir_url'];
		$archivo_css = $config_apps['jquery-ui_temas_archivo'];
		$directorio  = $_SERVER['DOCUMENT_ROOT'].$dir_url;
		$tema = '';
		$temaurl = '';
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
			
			if(trim($tema_usuarios)!=='' && in_array(trim($tema_usuarios),$temas)){
				$temaurl = $dir_url.trim($tema_usuarios)."/".$archivo_css;
				$tema = trim($tema_usuarios);
			}
			
			if(count($temas)>0 && $tema==''){
				$tema = $temas[0];
				$temaurl = $dir_url.$tema."/".$archivo_css;
			}
						
		}
		?>	


		
<link rel="stylesheet" href="<?php echo $config_apps['fontawesome-free_url']; ?>">    

<link id="estilo1" type="text/css" href="<?php echo $temaurl; ?>" rel="stylesheet" />
	
<script type="text/javascript" src="<?php echo $config_apps['jquery_url']; ?>"></script>
<script type="text/javascript" src="<?php echo $config_apps['jquery-ui_url']; ?>"></script>
<script type="text/javascript" src="core/base.js<?php echo '?v='.$version; ?>"></script>

<link type="text/css" href="core/base.css<?php echo '?v='.$version; ?>" rel="stylesheet" />


<?php
//libs_css
foreach($config_apps['libs_css_url'] as $url){
	echo '<link type="text/css" href="'.$url.'?v='.$version.'" rel="stylesheet" />'."\n";
};


$modulos_php = array();
$appActual = array();
foreach($aApps as $app){
	if($app['appid']==$appid){
		$appActual = $app;
		break;
	}
}
$dir_modulos_php = $config_apps['dir_modulos_php'];
foreach($appActual['modulos'] as $modulo){
	if(file_exists("$dir_modulos_php$modulo.php")){
		if(strpos($_SESSION['accesos'][$token]["botones_usuarios"], $modulo.'-acceso') !== false || $_SESSION['accesos'][$token]["perfil_usuarios"]=='Administrador'){
			$modulos_php[] = $modulo;
		}
	}
}

if($_SESSION['accesos'][$token]["perfil_usuarios"]=='Administrador' && $appActual['appid']=='home000'){
	$modulos_php[] = 'perfiles';
	$modulos_php[] = 'usuarios';
	$modulos_php[] = 'accesos';
}



if($_SESSION['accesos'][$token]["perfil_usuarios"]=='Administrador'){
	$aBtns = Array();
	if ($handle = opendir($dir_modulos_php)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".." && substr(trim($entry),-4,4)=='.php') {
				$part = explode('.',$entry);
				$modulo = $part[0];
				if($modulo != 'accesos'){
					ob_start();
					include("$dir_modulos_php$entry");
					$contenido = ob_get_clean();
					//preg_match_all('/seg_'.$modulo.'-(.*?)" /', $contenido, $match);
					preg_match_all('/<!--seguridad-(.*?)<!--\/seguridad-->/', $contenido, $match);
					if(count($match[1]) >0 ){
						//$aBtns[$modulo] = $match[1];
						
						foreach($match[1] as $tmpcad){
							$aBtns[$modulo][] = explode('-->',$tmpcad)[0];
						}
						if(count($aBtns[$modulo])>0){
							$aBtns[$modulo] = array_unique($aBtns[$modulo]);
						}
						
						
					}
					
				}
				
			}
		}
		closedir($handle);
	}
//print_r($aBtns);
	$aBtnsTodos = Array();
	foreach($aBtns as $permisos){
		foreach($permisos as $permiso){
				$aBtnsTodos[] = $permiso;
		}
	}
	$aBtnsTodos = array_unique($aBtnsTodos);
//print_r($aBtnsTodos);
/*
//echo "<br><br>con etiqueta seguridad<br><br><br><br>";
//print_r($aBtns);
$atmp = array();
foreach($aBtns as $modulo=>$permisos){
	foreach($permisos as $permiso){
		$atmp[]="$modulo-$permiso";
	}
}
echo '<script type="text/javascript" > var abtns='.json_encode($atmp).';</script>'."\n";
*/

}
?>





</head>
<body>
<input type="hidden" id="session_nombre_usuario" name="session_nombre_usuario" value="<?php	echo $_SESSION['accesos'][$token]["nombre_usuarios"]; ?>" />
<input type="hidden" id="session_id_usuario" name="session_id_usuario" value="<?php	echo $_SESSION['accesos'][$token]["id_usuarios"]; ?>" />
<input type="hidden" id="session_tema_usuario" name="session_tema_usuario" value="<?php	echo $_SESSION['accesos'][$token]["tema_usuarios"]; ?>" />
<input type="hidden" id="session_botones_usuario" name="session_botones_usuario" value="<?php	echo $_SESSION['accesos'][$token]["botones_usuarios"]; ?>" />
<input type="hidden" id="token" name="token" value="<?php echo $token; ?>" />
<input type="hidden" id="appid" name="appid" value="<?php echo $appid; ?>" />

<div id="tabs">
	<div id="bar_usuario">
		<!-- div id="btnMenu" class="ui-button ui-widget ui-state-default ui-corner-all" onClick="menu('izq')"-->
			<button  id="btnMenu"  onClick="menu('izq');">
			<!-- icon de Font-awesome -->
			<i class="fa fa-bars"></i>
			</button>
			
			<!--
			<div class="btnMenu-capa">
			<div class="raya"></div>
			<div class="raya"></div>
			<div class="raya"></div>
			</div>
			-->

		<!-- /div-->
	<div id="titulo" >Manufactura<br><span style="font-size:0.5em;font-style:italic; ">Aplicaci&oacute;n para registros generales</span></div>
	<div class="campos_usuario"><button id="btn_salir" onclick="logout()">Salir</button></div>
	<div class="campos_usuario">Usuario: <?php echo $_SESSION['accesos'][$token]["nombre_usuarios"]; ?></div>

    
    <div class="campos_usuario">


    </div>

</div>


<?php
$cabecera_tabs = '';
$cuerpo_tabs = '';

$i = 1;
foreach($modulos_php as $modulo){
	ob_start();
	include("$dir_modulos_php$modulo.php");
	$contenido = ob_get_clean();

	$titulo = isset($aDat['aDlg']['titulo']) ? $aDat['aDlg']['titulo'] : $modulo;
	$cabecera_tabs .=  '<li class="seguridad seg_'.$modulo.'-acceso"><a href="#tabs_'.$i.'"  accesskey="'.$i.'" modulo="'.$modulo.'">'.ucfirst($titulo).'</a></li>'."\n";

	
	//aplica permisos
	if($_SESSION['accesos'][$token]["perfil_usuarios"] != 'Administrador'){
		preg_match_all('/<!--seguridad-(.*?)<!--\/seguridad-->/', $contenido, $match);
		$botones = array();
		foreach($match[1] as $tmpcad){
			$botones[] = explode('-->',$tmpcad)[0];
		}
		foreach($botones as $permiso){
			//if(strpos($_SESSION['accesos'][$token]["botones_usuarios"], $modulo.'-'.$permiso) === false){
			if(strpos($_SESSION['accesos'][$token]["botones_usuarios"], $permiso) === false){
				$contenido = preg_replace(array('/<!--seguridad-'.$permiso.'-->(.*?)<!--\/seguridad-->/'), array(''), $contenido);
			}
		}
	}
	
	$cuerpo_tabs .= '<div id="tabs_'.$i.'">'."\n";
	$cuerpo_tabs .= $contenido;
	$cuerpo_tabs .= "</div>\n";
	$i = $i + 1;
	$aDat = null;
}

echo '<ul>'.$cabecera_tabs.'</ul>'."\n\n";
echo $cuerpo_tabs;

?>	

<!--    
<canvas width=380 height=300 id="foo"></canvas>
    -->

<div id="dlg_general" title="">
<div id="mensajes"></div>
</div>

<div id="dlgPDF" title="">

</div>


<?php

$dir_modulos_js = $config_apps['dir_modulos_js'];
foreach($modulos_php as $modulo){	
	if(file_exists("$dir_modulos_js$modulo.js")){
		echo '<script type="text/javascript" src="'."$dir_modulos_js$modulo.js".'?v='.$version.'"></script>'."\n";			
	}
}

?>	

<nav id="menuizq" class="ui-widget ui-widget-content ui-corner-all"> 
	<button onClick="menu('izq');"><i class="fa fa-times"></i></button>
    <button onClick="menu('der')"><i class="fa fa-arrow-left"></i></button>
    <button onClick="menu('arr')"><i class="fa fa-arrow-down"></i></button>
    <button onClick="menu('aba')"><i class="fa fa-arrow-up"></i></button>	
	<br>
	<br>
	<?php
		foreach($aApps as $app){
			$flag_ok = 0;
			foreach($app['modulos'] as $modulo){
				if(strpos($_SESSION['accesos'][$token]["botones_usuarios"], $modulo.'-acceso') !== false || $_SESSION['accesos'][$token]["perfil_usuarios"]=='Administrador'){
					$flag_ok = 1;
					break;
				}
			}
			if($flag_ok==1){
				echo "<button style=\"width:100%;\" onClick=\"window.location.replace('?appid={$app['appid']}&token={$token}');\"><i class=\"{$app['appicon']}\"></i> {$app['appdesc']}</button>\n";
			};
		}	
	?>
</nav>
<nav id="menuder" class="ui-widget ui-widget-content ui-corner-all"> 
	<button onClick="menu('der');"><i class="fa fa-times"></i></button>
    <button onClick="menu('izq')"><i class="fa fa-arrow-right"></i></button>
    <button onClick="menu('arr')"><i class="fa fa-arrow-down"></i></button>
    <button onClick="menu('aba')"><i class="fa fa-arrow-up"></i></button>	

	<div id="tema">
		<label for="xtema">Selecciona un Tema</label>
		<select id="xtema">
			<?php
			foreach($temas as $entry){
				$tmp = $entry == $tema ? "selected":"" ;
						echo "<option value='$dir_url$entry/$archivo_css' $tmp>$entry</option>"."\n";
			}
			?>
		</select>
	</div>	
	
	
</nav>
<nav id="menuarr" class="ui-widget ui-widget-content ui-corner-all"> 
	<button onClick="menu('arr');"><i class="fa fa-times"></i></button>
    <button onClick="menu('aba')"><i class="fa fa-arrow-up"></i></button>
    <button onClick="menu('der')"><i class="fa fa-arrow-left"></i></button>
    <button onClick="menu('izq')"><i class="fa fa-arrow-right"></i></button>
	<br><br><br>

</nav>
<nav id="menuaba" class="ui-widget ui-widget-content ui-corner-all"> 
	<button onClick="menu('aba');"><i class="fa fa-times"></i></button>
    <button onClick="menu('arr')"><i class="fa fa-arrow-down"></i></button>
    <button onClick="menu('der')"><i class="fa fa-arrow-left"></i></button>
    <button onClick="menu('izq')"><i class="fa fa-arrow-right"></i></button>
	<br>
	<br>

	<!--seguridad-ventas2-reporte_pdf_productos--><button id="bs_rpdf_productos" class="" onclick="reporte_pdf_productos(this)"><i class="fas fa-print">&nbsp; Clientes</i></button><!--/seguridad-->
	<br><br><br>


<div id="exportar_pdf" style='width:100%; height:80%;' >	
	<form id="frmpdf" name="frmpdf" target="ifpdf" action="core/rep_pdf.php" method="post">
	<input type="hidden" name="cadpdf" id="cadpdf" value=""/>
	</form>
 <!-- div style="float:left; width:500px; font-size:20px; margin-left:50px;">Reporte PDF</div -->
 <iframe name="ifpdf" id="ifpdf" src="blank.html" allowtransparency="yes" frameborder="0"  width="100%"  height="100%"></iframe>
 </div>
	
	
	
</nav>

<?php

foreach($config_apps['libs_js_url'] as $url){
	echo '<script type="text/javascript" src="'.$url.'?v='.$version.'" ></script>'."\n";
};

	
/*	
function toBase($num, $b=62) {
  $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $r = $num  % $b ;
  $res = $base[$r];
  $q = floor($num/$b);
  while ($q) {
    $r = $q % $b;
    $q =floor($q/$b);
    $res = $base[$r].$res;
  }
  return $res;
}

function to10( $num, $b=62) {
  $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $limit = strlen($num);
  $res=strpos($base,$num[0]);
  for($i=1;$i<$limit;$i++) {
    $res = $b * $res + strpos($base,$num[$i]);
  }
  return $res;
}	
*/
/*
//1560972732.924279 
//20190619143212924278
ini_set("precision", 16);
$when = microtime(true);
$micro = sprintf("%06d", ($when - floor($when)) * 1000000);
echo "$when $micro<br>";
$when = new \DateTime(date('Y-m-d H:i:s.'. $micro, (int) $when));
var_dump($when, $when->format('YmdHis.u'));
	echo "<br><br><br><br>";

	$numero = substr($when->format('YmdHisu'),0,20);

	$numid = alphaID($numero);
	$regid = alphaID($numid,true);
	echo sprintf("%x",(float)$numero);
	//var_dump((int)$regid);
	$comprueba = alphaID($regid);
	if($numid == $comprueba){
	echo "OK $numero $numid $regid $comprueba <br>";
	echo substr(sprintf("%f",$regid),0,8).' '.substr(sprintf("%f",$regid),8,6).' '.substr(sprintf("%f",$regid),14,6);
	echo "<br>";
	$fechahora = ($regid/10);
	//var_dump($fechahora);
	$micosegundos = ($regid/100000000000000) - intval(($regid/100000000000000));
	var_dump($micosegundos);
	echo "$fechahora $micosegundos <br>".sprintf("%x",$regid);
	echo "<br><br>";
	//echo gmp_strval((string)$regid);
echo "<br><br><br>";	
	$base62 = convBase($numero, '0123456789', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
	$decimal = convBase($base62, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', '0123456789');
	$comprueba = convBase($decimal, '0123456789', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
	echo "$numero $base62 $decimal $comprueba";
echo "<br><br><br>";	
	
	$base16 = convBase($numero, '0123456789', '0123456789ABCDEF');
	$decimal = convBase($base16, '0123456789ABCDEF', '0123456789');
	$comprueba = convBase($decimal, '0123456789', '0123456789ABCDEF');
	echo "$numero $base16 $decimal $comprueba ".sprintf("%X",$regid)." ".base_convert($numero,10,16);
echo "<br><br><br>";	
	
	echo gmp_strval ( gmp_init($numero, 10), 62 );
	
	}
*/	
?>
</body>
</html>