$(document).ready(function() {
	//alert('entro');
	// Initialise the first table (as before)
	//$("#table-1").tableDnD();
	// Tabs
	//$('#tabs').tabs();
	$('button').button();
	//$('#dlg_perfiles').addClass('ui-widget')
	
	
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



$.extend({
ucwords : function(str) {
    strVal = '';
    str = str.split(' ');
    for (var chr = 0; chr < str.length; chr++) {
        strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' '
    }
    return strVal
}
	
});	

cargar_botones();


	
});//DOCUMENT READY

//variable que contiene todos los botones de los modulos cargados
var abtns = [];
function cargar_botones(){
	//rutina para cargar los botonos de los modulos cargados
	var atmp,part;
	var llaves='';
	$(".seguridad").each(function(index, element) {
		//console.log($(element).attr("class"));
		atmp = $(element).attr("class").split('seg_');
		if(atmp[1].indexOf("usuarios")==-1){
			atmp[1] += " ";
			part = atmp[1].split(" ");
			if(llaves.indexOf(part[0])==-1){
				abtns.push(part[0]);
				llaves += part[0];
			}
			//console.log(atmp[1]);
		}
	});
	
	//aplica accesos...
	if($("#session_nombre_usuario").val()!=="Administrador"){
		for(i in abtns){
			desactiva = $("#session_botones_usuario").val().indexOf(abtns[i])==-1;
			if(desactiva == true){
				//console.log('ddddddd///'+abtns[i]);
				//$(".seg_"+abtns[i]).hide();
				$(".seg_"+abtns[i]).remove();
			}
		}
	}
	
}




function buscar_plus(pmodulo,psentido){
	var ipag = parseInt($('#'+pmodulo+'_pagina').val());
	var table = document.getElementById('table-'+pmodulo);
	if(table !== null){
		if(psentido=="anterior"){
			if( ipag <= 0){
				$('#'+pmodulo+'_pagina').val("0");
			}else{
				$('#'+pmodulo+'_pagina').val(ipag-1);
			}
		}else{
			var rowCount = table.rows.length - 1;
			var ilimite  = parseInt($('#'+pmodulo+'_limite').val());
			if(rowCount >= ilimite){
				$('#'+pmodulo+'_pagina').val(ipag+1);
			}
		}
	}
	buscar(pmodulo);
}

function buscar_inicio(pmodulo){
	$('#'+pmodulo+'_pagina').val("0");
	buscar(pmodulo);
}




function cambia_tema(dir,archivo){
	var cad = dir+"/##tema##/"+archivo;
	cad  = cad.replace(/##tema##/g,$("#xtema").val());
	$("#estilo1").attr('href',cad);	
	
	$.ajax({
		url: "consultas/login_tema.php",
		dataType: "xml",
		type : "POST",
		data: {tema:$("#xtema").val(),session_nombre_usuario:$("#session_nombre_usuario").val(),session_id_usuario:$("#session_id_usuario").val(),t:$("#token").val()},
	    beforeSend: function(){
	    },
		success: function( xml ) {
			if($(xml).find("estatus").text()=="S"){
				//window.location.replace("login.php");
			}
		},
		error: function(){
				//window.location.replace("man.php");
		}
		
	});
	
	
}


function logout(){
	$.ajax({
		url: "consultas/logout.php",
		dataType: "xml",
		type : "POST",
		data: {t:$("#token").val()},
	    beforeSend: function(){
	    },
		success: function( xml ) {
			if($(xml).find("estatus").text()=="S"){
				window.location.replace("login.php");
			}
		},
		error: function(){
				window.location.replace("login.php");
		}
		
	});
}


var xhrBuscar = [];
function buscar(modulo){
	if(xhrBuscar[modulo] && xhrBuscar[modulo].readyState != 4) { 
		xhrBuscar[modulo].abort();
	}

	xhrBuscar[modulo] = $.ajax({
		url: "consultas/lee_modulo.php",
		dataType: "xml",
		type : "POST",
		data: $("#fb_"+modulo).serialize(),
	    beforeSend: function(){
			$('#table-'+modulo+' tbody').html('<tr><td><img width="24" height="24" src="images/fancybox_loading.gif"/> buscando...</td></tr>');

	    },
		success: function( xml ) {
			$('#table-'+modulo+' tbody').html('');

			var cad_default = $('#table-default-'+modulo+' tbody').html();
			cad_default  = cad_default.replace(/##regSeleccion##/g,'regSeleccion');
			var cad = '';

				
			$(xml).find(modulo).each(function(){
				eval('cad = llena_tabla_'+modulo+'(cad_default,$(this))');
				$('#table-'+modulo+' tbody').append(cad);
			})//each
			$('button').button();
		}//sucess
	});//ajax
}


/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
function agregar_registro(pmodulo){
	limpia_campos(pmodulo,"agregar")
	$("#dlg_"+pmodulo).dialog("option","title","Agregar "+pmodulo);
	$("#dlg_"+pmodulo).dialog("open");
}



function limpia_campos(pmodulo,ptipo){
	$("#fdlg_"+pmodulo+" input:text, input:password").each(function(){
		$(this).val("");
		
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
		
	})
	$("#fdlg_"+pmodulo+" input:checkbox").each(function(){
		$(this).prop("checked","");
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
	})
	$("#dlg_id_"+pmodulo).prop("readonly",true);
	if(ptipo=="agregar"){
		$("#row_id_"+pmodulo).css("visibility","hidden");
	}else{
		$("#row_id_"+pmodulo).css("visibility","visible");
	}
	$("#dlg_accion_"+pmodulo).val(ptipo);
	$("#dlg_mensaje_"+pmodulo).hide();
}

function ABC_global(dlg_obj,pmodulo){
	if(xhrBuscar[pmodulo] && xhrBuscar[pmodulo].readyState != 4) { 
		xhrBuscar[pmodulo].abort();
	}

	xhrBuscar[pmodulo] = $.ajax({
		url: "consultas/ABC_"+pmodulo+".php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_"+pmodulo).serialize(),
	    beforeSend: function(){
			//var imagen ="<img src='images/fancybox_loading.gif'>"; 
			//$("#mensajes").html(imagen+"Cargando");
	    },
		success: function( xml ) {
			if($(xml).find("estatus").text()=="S"){
				$(dlg_obj).dialog("close");
				buscar(pmodulo);
			}else{
				$("#dlg_mensaje_"+pmodulo).hide();
				$("#dlg_mensaje_"+pmodulo).html($(xml).find("mensaje").text());
				$("#dlg_mensaje_"+pmodulo).show("fast");
			};
		}
	});
	
}

function cambiar_eliminar_registro(pid_registro,ptipo,pmodulo){
	$("#mensajes").html('<img width="24" height="24" src="images/fancybox_loading.gif"/> Leyendo');
	$("#dlg_general").dialog("option","title",$.ucwords(ptipo+" "+pmodulo));
	$("#dlg_general").dialog("open");
	limpia_campos(pmodulo,ptipo);
	$("#dlg_accion_"+pmodulo).val("consultar");
	$("#dlg_id_"+pmodulo).val(pid_registro);
	
	if(xhrBuscar[pmodulo] && xhrBuscar[pmodulo].readyState != 4) { 
		xhrBuscar[pmodulo].abort();
	}

	xhrBuscar[pmodulo] = 	$.ajax({
		url: "consultas/ABC_"+pmodulo+".php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_"+pmodulo).serialize(),
	    beforeSend: function(){
			//var imagen ="<img src='images/fancybox_loading.gif'>"; 
			//$("#mensajes").html(imagen+"Cargando");
	    },
		error: function(){
			$("#dlg_general").dialog("close");
		},
		success: function( xml ) {
			$("#dlg_general").dialog("close");
			if($(xml).find("estatus").text()=="S"){
				eval('llena_registro_'+pmodulo+'($(xml))');
				
				
				$("#dlg_accion_"+pmodulo).val(ptipo);
				
				$("#dlg_"+pmodulo).dialog("option","title",$.ucwords(ptipo+" "+pmodulo));
				$("#dlg_"+pmodulo).dialog("open");
			}else{
				$("#dlg_mensaje_"+pmodulo).hide();
				$("#dlg_mensaje_"+pmodulo).html($(xml).find("mensaje").text());
				$("#dlg_mensaje_"+pmodulo).show("fast");
			};
		}
	});
	
}


function agregar_registro_filtros(pmodulo,obj){
	alert('aadsfasdf');
	$('#table-filtros-'+pmodulo+' tbody:last').append($('#table-default-filtros-'+pmodulo+' tbody').html());
	//$('input').keyup(inputDispara);
	$('button').button();
}




var omenus = [{'t':'izq','v':'0','a':{'left': '0px'},'c':{'left': '-100%'}},
				{'t':'arr','v':'0','a':{'top': '0px'},'c':{'top': '-100%'}},
				{'t':'der','v':'0','a':{'left': '50%'},'c':{'left': '100%'}},
				{'t':'aba','v':'0','a':{'top': '0px'},'c':{'top': '100%'}}];
				
//function 				
function menu(menu){
	//alert("acceso menu");
	var leftop = '';
	var wihe   = '';
	var accion = '';
	var duracion = '100';
	for(var i in omenus){
		if(omenus[i].t == menu){
			if(omenus[i].v == 1){
				omenus[i].v = 0;
				//tmp = 'cierra'+omenus[i].t;
				otmp = omenus[i].c;
			}else{
				omenus[i].v = 1;
				//tmp = 'abre'+omenus[i].t;
				otmp = omenus[i].a;
			}
		}else{
			omenus[i].v = 0;
			//tmp = 'cierra'+omenus[i].t;
			otmp = omenus[i].c;
		}
	
		$('#menu'+omenus[i].t).animate(otmp, duracion );
		
		//console.log(tmp+' left '+$('#menu'+omenus[i].t).css('left')+' top '+$('#menu'+omenus[i].t).css('top'));
	}//for
}//function

