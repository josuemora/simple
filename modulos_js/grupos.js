/*
	$('#dlg_grupos').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: {
			"Ok": function() {
				ABC_grupos($(this));
			},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	});

function agregar_grupo(){
	limpia_grupo("agregar");
	$("#dlg_grupos").dialog("option","title","Agregar grupo");
	$("#dlg_grupos").dialog("open");
}


function cambiar_eliminar_grupo(pid_grupos,ptipo){
	$("#mensajes").html('<img width="24" height="24" src="images/fancybox_loading.gif"/> Leyendo');
	$("#dlg_general").dialog("option","title",$.ucwords(ptipo)+" grupo");
	$("#dlg_general").dialog("open");
	limpia_grupo(ptipo);
	$("#dlg_accion_grupos").val("consultar");
	$("#dlg_id_grupos").val(pid_grupos);
	$.ajax({
		url: "consultas/ABC_grupos.php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_grupos").serialize(),
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
				
				$("#dlg_grado_grupos").val($(xml).find("grado").text());
				$("#dlg_salon_grupos").val($(xml).find("salon").text());
				$("#dlg_turno_grupos").val($(xml).find("turno").text());
				
				$("#dlg_accion_grupos").val(ptipo);
				
				$("#dlg_grupos").dialog("option","title",$.ucwords(ptipo)+" grupo");
				$("#dlg_grupos").dialog("open");
			}else{
				$("#dlg_mensaje_grupos").hide();
				$("#dlg_mensaje_grupos").html($(xml).find("mensaje").text());
				$("#dlg_mensaje_grupos").show("fast");
			};
		}
	});
	
}


function limpia_grupo(ptipo){
	$("#fdlg_grupos input:text, input:password").each(function(){
		//alert($(this).attr("name"));
		$(this).val("");
		
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
		
	})
	$("#fdlg_grupos input:checkbox").each(function(){
		$(this).prop("checked","");
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
	})
	$("#dlg_id_grupos").prop("readonly",true);
	//$("#dlg_botones").prop("readonly",true);
	//$("#dlg_size").prop("readonly",true);
	if(ptipo=="agregar"){
		$("#row_id_grupos").css("visibility","hidden");
		//$("#dlg_ruta_serv").val("/omni/omnilife.com/http/pantalla_cedis/common/");
		//$("#dlg_imagen").val("https://www.omnilife.com/kiosco_ipad/images/logo_omnilife.png");
	}else{
		$("#row_id_grupos").css("visibility","visible");
	}
	$("#dlg_accion_grupos").val(ptipo);
	$("#dlg_mensaje_grupos").hide();
}


function ABC_grupos(dlg_obj){
	$.ajax({
		url: "consultas/ABC_grupos.php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_grupos").serialize(),
	    beforeSend: function(){
			//var imagen ="<img src='images/fancybox_loading.gif'>"; 
			//$("#mensajes").html(imagen+"Cargando");
	    },
		success: function( xml ) {
			//alert('paso');
			//console.log($(xml).find("estatus").text());
			if($(xml).find("estatus").text()=="S"){
				$(dlg_obj).dialog("close");
				buscar('grupos');
				
				//buscar('alumnos');//rutina en alumnos.js
				//llena_select_grupos();//rutina en alumnos.js
			}else{
				$("#dlg_mensaje_grupos").hide();
				$("#dlg_mensaje_grupos").html($(xml).find("mensaje").text());
				$("#dlg_mensaje_grupos").show("fast");
			};
		}
	});
	
}



function poncheck_grupos(obj){
	var check = $(obj).prop("checked");
	$("#fdlg_grupos input:checkbox").each(function(){
		$(this).prop("checked",check);
	});	
}


function llena_tabla_grupos(cad_default,xml){
	var cad = cad_default;

	cad  = cad.replace(/##id_grupos##/g,$(xml).find('id').text());
	cad  = cad.replace(/##grado##/g,$(xml).find('grado').text());
	cad  = cad.replace(/##salon##/g,$(xml).find('salon').text());
	cad  = cad.replace(/##turno##/g,$(xml).find('turno').text());
	return cad;
};




buscar_inicio('grupos');


*/