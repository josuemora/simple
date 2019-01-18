	$('#dlg_mttobasico').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: {
			"Ok": function() {
				ABC_mttobasico($(this));
			},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	});

function agregar_mttobasico(){
	limpia_mttobasico("agregar");
	$("#dlg_mttobasico").dialog("option","title","Agregar mttobasico");
	$("#dlg_mttobasico").dialog("open");
}

function cambiar_eliminar_mttobasico(pid_mttobasico,ptipo){
	$("#mensajes").html('<img width="24" height="24" src="images/fancybox_loading.gif"/> Leyendo');
	$("#dlg_general").dialog("option","title",$.ucwords(ptipo)+" mttobasico");
	$("#dlg_general").dialog("open");
	limpia_mttobasico(ptipo);
	$("#dlg_accion_mttobasico").val("consultar");
	$("#dlg_id_mttobasico").val(pid_mttobasico);
	$.ajax({
		url: "consultas/ABC_mttobasico.php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_mttobasico").serialize(),
	    beforeSend: function(){
	    },
		error: function(){
			$("#dlg_general").dialog("close");
		},
		success: function( xml ) {
			$("#dlg_general").dialog("close");
			//console.log($(xml).find("estatus").text());
			if($(xml).find("estatus").text()=="S"){
				
				___regcampos___				
				$("#dlg_accion_mttobasico").val(ptipo);
				
				$("#dlg_mttobasico").dialog("option","title",$.ucwords(ptipo)+" mttobasico");
				$("#dlg_mttobasico").dialog("open");
			}else{
				$("#dlg_mensaje_mttobasico").hide();
				$("#dlg_mensaje_mttobasico").html($(xml).find("mensaje").text());
				$("#dlg_mensaje_mttobasico").show("fast");
			};
		}
	});
	
}


function limpia_mttobasico(ptipo){
	$("#fdlg_mttobasico input:text, input:password").each(function(){
		$(this).val("");
		
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
		
	})
	$("#fdlg_mttobasico input:checkbox").each(function(){
		$(this).prop("checked","");
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
	})
	$("#dlg_id_mttobasico").prop("readonly",true);
	if(ptipo=="agregar"){
		$("#row_id_mttobasico").css("visibility","hidden");
	}else{
		$("#row_id_mttobasico").css("visibility","visible");
	}
	$("#dlg_accion_mttobasico").val(ptipo);
	$("#dlg_mensaje_mttobasico").hide();
}


function ABC_mttobasico(dlg_obj){
	$.ajax({
		url: "consultas/ABC_mttobasico.php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_mttobasico").serialize(),
	    beforeSend: function(){
			//var imagen ="<img src='images/fancybox_loading.gif'>"; 
			//$("#mensajes").html(imagen+"Cargando");
	    },
		success: function( xml ) {
			if($(xml).find("estatus").text()=="S"){
				$(dlg_obj).dialog("close");
				buscar('mttobasico');
				___rutinasextras___
			}else{
				$("#dlg_mensaje_mttobasico").hide();
				$("#dlg_mensaje_mttobasico").html($(xml).find("mensaje").text());
				$("#dlg_mensaje_mttobasico").show("fast");
			};
		}
	});
	
}


function poncheck_mttobasico(obj){
	var check = $(obj).prop("checked");
	$("#fdlg_mttobasico input:checkbox").each(function(){
		$(this).prop("checked",check);
	});	
}


function llena_tabla_mttobasico(cad_default,xml){
	var cad = cad_default;

	___llenacampos___
	return cad;
};




buscar_inicio('mttobasico');
