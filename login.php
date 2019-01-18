<?php
ob_start();
ini_set("display_errors",0);
error_reporting(0);
session_start();
session_regenerate_id(true);
include("config/apps.php");

		$dir_url	 = $config_apps['jquery-ui_temas_dir_url'];
		$archivo_css = $config_apps['jquery-ui_temas_archivo'];
		$directorio  = $_SERVER['DOCUMENT_ROOT'].$dir_url;
		$tema 		 = isset($_SESSION['ultimo_tema']) ? $_SESSION['ultimo_tema'] : '';
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
			
			if(count($temas)>0 && $tema==''){
				$tema = $temas[0];
			}
			$temaurl = $dir_url.$tema."/".$archivo_css;
			
						
		}



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
<head>
<title>Simple --Login</title>
<link id="estilo1" type="text/css" href="<?php echo $temaurl; ?>" rel="stylesheet" />
	
<script type="text/javascript" src="<?php echo $config_apps['jquery_url']; ?>"></script>
<script type="text/javascript" src="<?php echo $config_apps['jquery-ui_url']; ?>"></script>


<script type="text/javascript">
$(document).ready(function() {
	// Tabs
	$('#tabs').tabs();
	$('button').button();
	
	
	// Dialog

	$('#dlg_general').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: {
			"Ok": function() {
				$(this).dialog("close");
			}
		}
	});

	$('#cb_login').dialog({
		autoOpen: true,
		width: 300,
		modal: true,
		closeOnEscape: false,
			
		open: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
		}
	});
	
	$('#usuario').focus();

});	


function chk_login(dlg_obj){
	$("#mensajes").html("Checando acceso... favor de esperar");
	$("#dlg_general").dialog("option","title","Login");
	$("#dlg_general").dialog("open");
	$.ajax({
		url: "core/chk_login.php",
		dataType: "xml",
		type : "POST",
		data: $("#flogin").serialize(),
	    beforeSend: function(){
			/*
			var imagen ="<img src='images/fancybox_loading.gif'>"; 
			$("#mensajes").html(imagen+" Checando password");
			$("#dlg_general").dialog("option","title","Login");
			$("#dlg_general").dialog("open");
			*/
	    },
		success: function( xml ) {
			//$("#dlg_general").dialog("open");
			if($(xml).find("estatus").text()=="S"){
				window.location.replace("main.php?appid=home000&token="+$(xml).find("id").text());
			}else{
				$("#mensajes").html(" No existe usuario y/o password");
				$("#dlg_general").dialog("option","title","Login");
				$("#dlg_general").dialog("open");
			}
		}
	});
	
}

	
	




</script>
 <style>
body { font-size: 82.5%; }
label, input { display:block; }
input.text { margin-bottom:12px; width:95%; padding: .4em; }
</style>
</head>
<body>
<div id="titulo"><span style="font-size:5em;">Simple</span><br><span style="font-size:2.5em;font-style:italic; ">/Autor: Josu&eacute; Mora Ure&ntilde;a /email: joshua71@yahoo.com</span></div>
<!--
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Login</a></li>
    </ul>
    <div id="tabs-1">
-->
<div id="cb_login" class="ui-widget" title="Login">  
<form name="flogin" id="flogin" onsubmit="return false;" method="post" >
<table cellpadding="10" cellspacing="0" border="0"  class="ui-widget ui-widget-content">
<tr>
	<td width="250px"  class="ui-widget-header ">Usuario</td>
</tr>
<tr>
	<td width="250px"><input type="text" value="Administrador" name="usuario" id="usuario" class="text ui-widget-content ui-corner-all"></td>
</tr>
<tr>
	<td width="250px"  class="ui-widget-header ">Password</td>
</tr>
<tr>
	<td width="250px"><input type="password" value="simple" name="pass" id="pass" class="text ui-widget-content ui-corner-all"></td>
</tr>
<tr>
	<td align="center"><button onclick="chk_login()">Accesar</button></td>
</tr>
</table>
</form>
</div>

	</div>


<div id="dlg_general" title="">
<div id="mensajes"></div>
<!--/div-->
</body>
</html>
