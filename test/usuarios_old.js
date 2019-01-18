	$('#dlg_usuarios').dialog({
		autoOpen: false,
		width: 1000,
		modal: true,
		buttons: {
			"Ok": function() {
				ABC_usuarios($(this));
			},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	});
////


function agregar_usuario(){
	limpia_usuario("agregar");
	/*
	if($('#dlg_perfil_usuarios option').size() == 0){
		llena_select_perfil("");
	}else{
		$('#dlg_perfil_usuarios').val(0);
	}
	*/
	$("#dlg_usuarios").dialog("option","title","Agregar Usuario");
	$("#dlg_usuarios").dialog("open");
}

function cambiar_eliminar_usuario(pid_usuarios,ptipo){
	$("#mensajes").html('<img width="24" height="24" src="images/fancybox_loading.gif"/> Leyendo');
	$("#dlg_general").dialog("option","title",$.ucwords(ptipo)+" Usuario");
	$("#dlg_general").dialog("open");
	limpia_usuario(ptipo);
	$("#dlg_accion_usuarios").val("consultar");
	$("#dlg_id_usuarios").val(pid_usuarios);
	$.ajax({
		url: "consultas/ABC_usuarios.php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_usuarios").serialize(),
	    beforeSend: function(){
			//var imagen ="<img src='images/fancybox_loading.gif'>"; 
			//$("#mensajes").html(imagen+"Cargando");
	    },
		error: function(){
			$("#dlg_general").dialog("close");
		},
		success: function( xml ) {
			$("#dlg_general").dialog("close");
			//console.log($(xml).find("estatus").text());
			if($(xml).find("estatus").text()=="S"){
				
				$("#dlg_nombre").val($(xml).find("nombre").text());
				//$("#dlg_password").val($(xml).find("clave").text());
				$("#dlg_botones").val($(xml).find("botones").text());
				$("#dlg_id_usuarios").val($(xml).find("id").text());
				genera_botones_disponiblesx($(xml).find("botones").text());
				/*
				if($('#dlg_perfil_usuarios option').size() == 0){
					llena_select_perfil($(xml).find("id_perfiles").text());
				}else{
					$('#dlg_perfil_usuarios').val($(xml).find("id_perfiles").text());
				}
				*/
				
				$("#dlg_accion_usuarios").val(ptipo);
				
				$("#dlg_usuarios").dialog("option","title",$.ucwords(ptipo)+" Usuario");
				$("#dlg_usuarios").dialog("open");
			}else{
				$("#dlg_mensaje_usuarios").hide();
				$("#dlg_mensaje_usuarios").html($(xml).find("mensaje").text());
				$("#dlg_mensaje_usuarios").show("fast");
			};
		}
	});
	
}


function limpia_usuario(ptipo){
	$("#fdlg_usuarios input:text, input:password").each(function(){
		//alert($(this).attr("name"));
		$(this).val("");
		
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
		
	})
	$("#fdlg_usuarios input:checkbox").each(function(){
		$(this).prop("checked","");
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
	})
	$("#dlg_id_usuarios").prop("readonly",true);
	//$("#dlg_botones").prop("readonly",true);
	//$("#dlg_size").prop("readonly",true);
	if(ptipo=="agregar"){
		$("#row_id_usuarios").css("visibility","hidden");
		//$("#dlg_ruta_serv").val("/omni/omnilife.com/http/pantalla_cedis/common/");
		//$("#dlg_imagen").val("https://www.omnilife.com/kiosco_ipad/images/logo_omnilife.png");
	}else{
		$("#row_id_usuarios").css("visibility","visible");
	}
	$("#dlg_accion_usuarios").val(ptipo);
	$("#dlg_mensaje_usuarios").hide();
}


function ABC_usuarios(dlg_obj){
	$.ajax({
		url: "consultas/ABC_usuarios.php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_usuarios").serialize(),
	    beforeSend: function(){
			//var imagen ="<img src='images/fancybox_loading.gif'>"; 
			//$("#mensajes").html(imagen+"Cargando");
	    },
		success: function( xml ) {
			//alert('paso');
			//console.log($(xml).find("estatus").text());
			if($(xml).find("estatus").text()=="S"){
				$(dlg_obj).dialog("close");
				buscar('usuarios');
			}else{
				$("#dlg_mensaje_usuarios").hide();
				$("#dlg_mensaje_usuarios").html($(xml).find("mensaje").text());
				$("#dlg_mensaje_usuarios").show("fast");
			};
		}
	});
	
}




function genera_botones_disponiblesx(btns_activados){
	var cad = '<table>';
	var t = 0,cadx='';
	for(i in abtns){
		activa = btns_activados.indexOf(abtns[i])!=-1 ? 'checked="checked"': '';
		cadx = cadx + '<td><input type="checkbox" name="xbtns[]" value="'+abtns[i]+'" '+activa+'>'+abtns[i]+'</td>';
		t = t + 1;
		if(t>3){t=0;cad += '<tr>'+cadx+'</tr>';cadx=''}
	}
	if(t>0){t=0;cad += '<tr>'+cadx+'</tr>';cadx=''}
	//cad += '<tr><td><input type="checkbox" name="btnacc" value=""/>SELECCIONA TODOS</td><td></td><td></td></tr>'
	cad += '</table>';
	$("#botones_disponibles").html(cad);

	
}

function poncheck(obj){
	var check = $(obj).prop("checked");
	$("#fdlg_usuarios input:checkbox").each(function(){
		$(this).prop("checked",check);
	});	
}


function llena_tabla_usuarios(cad_default,xml){
	var cad = cad_default;

	cad  = cad.replace(/##id_usuarios##/g,$(xml).find('id').text());
	cad  = cad.replace(/##nombre##/g,$(xml).find('nombre').text());
	cad  = cad.replace(/##botones##/g,$(xml).find('botones').text());
	
	return cad;
};




/*
function cargar_usuarios(dlg_obj){
	$.ajax({
		url: "cargar_usuarios.php",
		dataType: "xml",
		type : "POST",
		data: {tipo:'set'},
	    beforeSend: function(){
			var imagen ="<img src='images/fancybox_loading.gif'>"; 
			$("#mensajes").html(imagen+"Cargando");
			$("#dlg_general").dialog("option","title","Cargando Videos desde FTP");
			$("#dlg_general").dialog("open");
	    },
		success: function( xml ) {
			$("#mensajes").html("<br/>Altas: "+$(xml).find("altas").text()+"<br/><br/>Cambios: "+$(xml).find("cambios").text());
			buscar('videos');
		}
	});
	
}

*/


buscar_inicio('usuarios');
genera_botones_disponiblesx('');
