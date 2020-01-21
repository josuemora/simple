//varable de Relaciones entre modelos de Edicion a Listado
var aRelModelos = [];	


var confirma = false;
var objdlg;

var ultimoFocoBtn = [];
var fnBtnFoco = function() {
	//console.log('entro a Perdio el foco ');
		if($(this).length ){
		if($(this).attr('id') != null){
			var str = $(this).attr('id');
			var atemp = str.split('_');
			//console.log('Perdio el foco '+str+' '+atemp[0].indexOf('btn'));
			if(atemp[0].indexOf('btn') != -1 ){
			ultimoFocoBtn[atemp[1]] = str;
			//console.log('Perdio el foco '+str);
			};
		}
		}
	};

var fnBtnKeyDown = function(e) {
	  var code = (e.keyCode ? e.keyCode : e.which);
	  if (code == 8){ //desactiva backspace en los botones para que no se cambie de url
		e.preventDefault();
	  }

	};


$(document).ready(function() {


	//Ajax
/*	
	$.ajaxSetup({
		async: false,
		cache: false
	});	
*/	
	
	// Tabs
	$('#tabs').tabs({
		activate: function( event, ui ) {
					//var modulo = $("a",ui.newTab).html().toLowerCase();
					var modulo = $("a",ui.newTab).attr("modulo");
					if($("#" + modulo + "_pagina").length > 0){
						buscar(modulo);
					};
					if(eval('$.isFunction(window.activar_'+modulo+')')){
						eval('activar_'+modulo+'()');
					//} else {
					//	console.log('no existe la funcion de activar_'+modulo);
					}
				}
	});
	
	$('button').focusout(fnBtnFoco);
	$('button').keydown(fnBtnKeyDown);
	$('button').button();
	$('nav button').each(function(index, element){
		$(this).attr('tabindex','-1');
	});
	sigEnter_foco_inputs();
	
	
	
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

//cargar_botonesx();

//console.log(abtns);


	$('#xtema').selectmenu({
		change: function(event,ui){
			cambia_tema(ui.item.value);
		}	
	});
	$('#xtema-menu').css("max-height","400px");
	$('#xtema-button').attr("tabindex","-1");

	/*
	$('#dlg_fecha_ventas').datepicker({
      showWeek: true
    });
	*/
	
/*
        $("#dialog_confirm").dialog({
            resizable: false,
            height: 240,
            modal: true,
            autoOpen: false,
            buttons: {
                'No': function() {
					confirma = false;
                    $(this).dialog('close');
                },
                'Si': function() {
					confirma = true;
                    $(this).dialog('close');
                    
                }
            },
			open: function (event,ui){
				confirma = false;
			}
        });		
*/
	
	$.extend({ alert: function (message, title) {
	  $("<div></div>").dialog( {
		buttons: { "Ok": function () { $(this).dialog("close"); } },
		close: function (event, ui) { $(this).remove(); },
		resizable: false,
		title: title,
		modal: true
	  }).text(message);
	}
	});	

	$.extend({
		confirm: function(message, title, okAction) {
			$("<div></div>").dialog({
				// Remove the closing 'X' from the dialog
				open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); }, 
				buttons: {
					"No": function() {
						$(this).dialog("close");
					},
					"Si": function() {
						$(this).dialog("close");
						okAction();
					},
				},
				close: function(event, ui) { $(this).remove(); },
				resizable: false,
				title: title,
				modal: true
			}).text(message);
		}
	});

	
});//DOCUMENT READY

//variable que contiene todos los botones de los modulos cargados
//var abtns = [];
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
				//console.log(part[0])
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
			if(rowCount >= ilimite ){
				$('#'+pmodulo+'_pagina').val(ipag+1);
			}
		}
	}
	ultimoFocoBtn[pmodulo] = null;
	buscar(pmodulo);
}

function buscar_inicio(pmodulo){
	$('#'+pmodulo+'_pagina').val("0");
	buscar(pmodulo);
}




function cambia_tema_old(dir,archivo){
	var cad = dir+"##tema##/"+archivo;
	cad  = cad.replace(/##tema##/g,$("#xtema").val());
	$("#estilo1").attr('href',cad);	
	
	$.ajax({
		url: "core/login_tema.php",
		dataType: "xml",
		type : "POST",
		data: {tema:$("#xtema").val(),session_nombre_usuario:$("#session_nombre_usuario").val(),session_id_usuario:$("#session_id_usuario").val(),token:$("#token").val()},
	    beforeSend: function(){
	    },
		success: function( xml ) {
			if(xml==null){
				window.location.replace("login.php");
			}
			if($(xml).find("estatus").text()=="S"){
				//window.location.replace("login.php");
			}
		},
		error: function(){
				//window.location.replace("man.php");
		}
		
	});
	
	
}



function cambia_tema(url){
	//var cad = dir+"##tema##/"+archivo;
	//cad  = cad.replace(/##tema##/g,$("#xtema").val());
	//$('select option:selected').text();
	$("#estilo1").attr('href',url);	
	
	$.ajax({
		url: "core/login_tema.php",
		dataType: "xml",
		type : "POST",
		data: {tema:$("#xtema option:selected").text(),session_nombre_usuario:$("#session_nombre_usuario").val(),session_id_usuario:$("#session_id_usuario").val(),token:$("#token").val()},
	    beforeSend: function(){
	    },
		success: function( xml ) {
			if(xml==null){
				window.location.replace("login.php");
			}
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
		url: "core/logout.php",
		dataType: "xml",
		type : "POST",
		data: {t:$("#token").val()},
	    beforeSend: function(){
	    },
		success: function( xml ) {
			if($(xml).find("estatus").text()=="S" || xml==null){
				window.location.replace("login.php");
			}
		}
	});
	
}


var xhrBuscar = [];
function buscar(modulo){
	if(xhrBuscar[modulo] && xhrBuscar[modulo].readyState != 4) { 
		xhrBuscar[modulo].abort();
		xhrBuscar[modulo] = null;
	}

	xhrBuscar[modulo] = $.ajax({
		url: "core/lee_modulo.php",
		dataType: "xml",
		type : "POST",
		data: $("#fb_"+modulo).serialize()+ "&token=" + $('#token').val()+ "&appid=" + $('#appid').val(),
	    beforeSend: function(){
			$('#table-'+modulo+' tbody').html('<tr><td><img width="24" height="24" src="images/fancybox_loading.gif"/> buscando...</td></tr>');

	    },
		success: function( xml ) {
			if(xml==null){
				window.location.replace("login.php");
			}
			$('#table-'+modulo+' tbody').html('');

			var cad_default = $('#table-default-'+modulo+' tbody').html();
			cad_default  = cad_default.replace(/##regSeleccion##/g,'regSeleccion');
			var cad = '';

			if($(xml).find('rowsCount').text()!=''){ 
				$('#mensajes_'+modulo+'').html($(xml).find('rowsCount').text()+' Registros encontrados')
			};
			
			var indice = 1;	
			$(xml).find(modulo).each(function(){
				eval('cad = llena_tabla_'+modulo+'(cad_default,$(this))');
				cad  = cad.replace(/##indice##/g,indice);
				if($(this).find('id').text()==''){ //quita botones en caso de no haber una columna con id
					cad  = cad.replace(/<!--seguridad-(.*?)<!--\/seguridad-->/g,'');
				};
				$('#table-'+modulo+' tbody').append(cad);
				indice = indice + 1;
			})//each
			$('#modulo-'+modulo+' button').button();
			$('#modulo-'+modulo+' button').focusout(fnBtnFoco);
			$('#modulo-'+modulo+' button').keydown(fnBtnKeyDown);
			//sigEnter_foco_inputs();

			if(ultimoFocoBtn[modulo] != null){
				if ( $('#'+ultimoFocoBtn[modulo]).length ) {
					$('#'+ultimoFocoBtn[modulo]).focus();
					console.log('foco '+ultimoFocoBtn[modulo]);
				}
				ultimoFocoBtn[modulo] = null;
			}

		}//sucess
	});//ajax
}


/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*
function agregar_registro(pmodulo){
	//$('#dlg_accion_'+pmodulo).val('consultar');
	cambiar_eliminar_registro(0,'agregar',pmodulo);//para que llene los select
	//limpia_campos(pmodulo,"agregar")
	//$("#dlg_"+pmodulo).dialog("option","title","Agregar "+pmodulo);
	//$("#dlg_"+pmodulo).dialog("open");
}
*/
function checaSoloLectura(pmodulo){
	if($('#dlg_accion_'+pmodulo).val()=='eliminar'){
		$('#fdlg_'+pmodulo+' input:text, #fdlg_'+pmodulo+' input:password').each(function(){
			$(this).prop("readonly",true);
			
		});
		$("#fdlg_"+pmodulo+" input:checkbox, #fdlg_"+pmodulo+" input:radio, #fdlg_"+pmodulo+" select").each(function(){
			$(this).prop("readonly",true);
			$(this).prop("disabled",true);
		});
		
	}	
};

function limpia_campos(pmodulo,ptipo){
	
	$("#fdlg_"+pmodulo+" input:text, #fdlg_"+pmodulo+" input:password").each(function(){
		$(this).val("");
		
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
		}else{
			$(this).prop("readonly",false);
		}
		if($(this).hasClass('readonly')){
			$(this).prop("readonly",true);
		}
		
	})
	$("#fdlg_"+pmodulo+" button").each(function(){
		
		if($(this).attr('id').substr(0,3) == 'bl_'){
			
			if(ptipo=="eliminar"){
				$(this).prop("disabled",true);
			}else{
				$(this).prop("disabled",false);
			}
		}
	});
	$("#fdlg_"+pmodulo+" input:checkbox, #fdlg_"+pmodulo+" input:radio").each(function(){
		$(this).prop("checked","");
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
			$(this).prop("disabled",true);
		}else{
			$(this).prop("readonly",false);
			$(this).prop("disabled",false);
		}
		
		/*
		console.log($(this).attr("id")+' '+$(this).hasClass('inputs')+' '+$(this).attr("class"));
		if($(this).hasClass('ui-checkboxradio')){
			
			//var tmpclass = $(this).attr('class');
			//if(tmpclass.indexOf('ui-checkbox') > -1){
				$(this).checkboxradio();
				$(this).checkboxradio("refresh");
			//}
		}
		*/
	});
	//$( "#fdlg_"+pmodulo+" input:checkbox,#fdlg_"+pmodulo+" input:radio" ).checkboxradio();
	//$( "#fdlg_"+pmodulo+" input:checkbox,#fdlg_"+pmodulo+" input:radio" ).checkboxradio("refresh");
	
	$("#fdlg_"+pmodulo+" select").each(function(){
		
		if(ptipo=="eliminar"){
			$(this).prop("readonly",true);
			$(this).prop("disabled",true);
		}else{
			$(this).prop("readonly",false);
			$(this).prop("disabled",false);
		}
		
		//$(this).selectmenu();
		//$(this).selectmenu("refresh");
	});	
	
	$("#dlg_id_"+pmodulo).prop("readonly",true);
	if(ptipo=="agregar"){
		$("#dlg_id_"+pmodulo).val('0');
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
		data: $("#fdlg_"+pmodulo).serialize()+ "&token=" + $('#token').val()+ "&appid=" + $('#appid').val(),
		beforeSend: function(){
			$("#dlg_mensaje_"+pmodulo).hide();
			if($('#dlg_guardaCache_'+pmodulo).val()=='0'){
				var imagen ="<img src='images/fancybox_loading.gif'>"; 
				$("#dlg_mensaje_"+pmodulo).html(imagen+"Cargando");
				$("#dlg_mensaje_"+pmodulo).show("fast");
			}
		},
		error: function(xhr, status, text) {
			//console.log('error ajax '+text+' '+status);
			$('#dlg_guardaCache_'+pmodulo).val('0');
		},
		success: function( xml ) {
			$("#dlg_mensaje_"+pmodulo).hide();
			if(xml==null){
				window.location.replace("login.php");
			}
			if($(xml).find("estatus").text()=="S"){
				if($('#dlg_guardaCache_'+pmodulo).val()=='0'){
					$(dlg_obj).dialog("close");
					buscar(pmodulo);
					
					if($("#dlg_accion_"+pmodulo).val()=="agregar" && $("#dlg_SeguirAgregando_"+pmodulo).val()=="1"){//para que siga agregando registros...
						consultar_registro('0','agregar',pmodulo);
					}
				}else{
					eval('actualizaTotales_'+pmodulo+'($(xml));');
				}
				$('#dlg_guardaCache_'+pmodulo).val('0');
			}else{
				$("#dlg_mensaje_"+pmodulo).hide();
				$("#dlg_mensaje_"+pmodulo).html($(xml).find("mensaje").text());
				$("#dlg_mensaje_"+pmodulo).show("fast");
			};
		}
	});
	
}

function consultar_registro(pid_registro,ptipo,pmodulo){
	var ptitulo = $('#dlg_'+pmodulo).attr('titulo')
	$('#dlg_guardaCache_'+pmodulo).val('0');
	$("#mensajes").html('<img width="24" height="24" src="images/fancybox_loading.gif"/> Leyendo');
	$("#dlg_general").dialog("option","title",$.ucwords(ptipo+" "+ptitulo));
	$("#dlg_general").dialog("open");
	//console.log(pmodulo+' '+ptipo);
	limpia_campos(pmodulo,ptipo);
	$("#dlg_accion_"+pmodulo).val("consultar");
	$("#dlg_id_"+pmodulo).val(pid_registro);
	
	if(xhrBuscar['ABC_'+pmodulo] && xhrBuscar['ABC_'+pmodulo].readyState != 4) { 
		xhrBuscar['ABC_'+pmodulo].abort();
	}

	xhrBuscar['ABC_'+pmodulo] = 	$.ajax({
		url: "consultas/ABC_"+pmodulo+".php",
		dataType: "xml",
		type : "POST",
		data: $("#fdlg_"+pmodulo).serialize()+ "&token=" + $('#token').val()+ "&appid=" + $('#appid').val(),
	    beforeSend: function(){
			$("#dlg_mensaje_"+pmodulo).hide();
			//var imagen ="<img src='images/fancybox_loading.gif'>"; 
			//$("#dlg_mensaje_"+pmodulo).html(imagen+"Cargando");
			//$("#dlg_mensaje_"+pmodulo).show("fast");
	    },
		error: function(){
			$("#dlg_general").dialog("close");
		},
		success: function( xml ) {
			$("#dlg_mensaje_"+pmodulo).hide();
			if(xml==null){
				window.location.replace("login.php");
			}
			if($(xml).find("estatus").text()=="S"){
				
				$("#dlg_accion_"+pmodulo).val(ptipo);
				
				eval('llena_registro_'+pmodulo+'($(xml))');
				
				if($("#dlg_id_"+pmodulo).val() != '0' && $("#dlg_id_"+pmodulo).val() != ''){
					$("#row_id_"+pmodulo).css("visibility","visible");
				}
				
				$("#dlg_general").dialog("close");
				$("#dlg_"+pmodulo).dialog("option","title",$.ucwords(ptipo+" "+ptitulo));
				$("#dlg_"+pmodulo).dialog("open");
			}else{
				$("#dlg_general").dialog("close");
				if(pid_registro>0){
					$("#dlg_mensaje_"+pmodulo).hide();
					$("#dlg_mensaje_"+pmodulo).html($(xml).find("mensaje").text());
					$("#dlg_mensaje_"+pmodulo).show("fast");
				}
			};
		}
	});
	
}






function agregar_registro_filtros(pmodulo){
	$('#table-filtros-'+pmodulo+' tbody:last').append($('#table-default-filtros-'+pmodulo+' tbody').html());
	$('#modulo-'+pmodulo+' button').button();
	$(".sorteable").sortable();
	//$('input').keyup(inputDispara);

}

function eliminar_registro_filtros(pmodulo,obj){
	$(obj).closest('tr').remove();
	buscar_inicio(pmodulo);
}


function sigEnter_foco_inputs(){
	$(document).on('keydown', '.inputs', function(e) {
	  var code = (e.keyCode ? e.keyCode : e.which);
	  /*
		var objdlg = $(e.target).closest(".ui-dialog");
	var index = $('.inputs',objdlg).index(this);
	console.log(code+' '+index+' '+$('.inputs',objdlg).length);
	*/
	  if (code == 13) {
		 e.preventDefault();
		var objdlg = $(e.target).closest(".ui-dialog");
		var index = $('.inputs',objdlg).index(this);
	//console.log(code+' '+index+' '+$('.inputs',objdlg).length);
		index = e.shiftKey ? index - 1 : index + 1;
		
		if(e.ctrlKey && !e.shiftKey){ 
			var objTabla = $(e.target).closest("tbody");
			var totRen = $('tr',objTabla).length;
			var objTR = $(e.target).closest("tr");
			var numRen = $('input[name^=NumRen]', objTR).val();
			var numTR = $('tr',objTabla).index(objTR) + 1;
			console.log('numTR '+numTR+' numRen '+numRen);
			if(numTR == totRen){//si es el ultimo TR de la tabla...
				var i = parseInt(numRen) + 1;
				var ren = '_' + i;
				console.log('i '+i);
				var regExp = new RegExp("_" + numRen , 'g');
				//txt1: debe ser el mismo texto declarado en la plantilla1 en la variable $pTabRen
				//var txt1 = '<input type="hidden" name="NumRen[]" value="'+numRen+'">'; 
				//var txt2 = '<input type="hidden" name="NumRen[]" value="'+i+'">';
				//console.log(txt2);
				//var $tr    = $(e.target).closest('tr');
				objTabla.find('select').selectmenu('destroy');
				objTabla.find('input:checkbox, input:radio').checkboxradio('destroy');


				var $clone = objTR.clone();
				//$clone.html($clone.html().replace(regExp,ren).replace(txt1,txt2));
				$clone.html($clone.html().replace(regExp,ren));
				$clone.find(':text').val('');
				$clone.find('input[name^=NumRen]').val(i);

				objTR.after($clone);
				
				objTabla.find('select').selectmenu();
				
				objTabla.find('select').each(function(){
					var id = $(this).attr("id")
					var w = $(this).attr("width");
					var pMaxHeight = $(this).attr("pMaxHeight");
					var pclass = $(this).attr("pclass");
					$(this).selectmenu({width: w});
					$(this).selectmenu("refresh");
					$('#'+id+'-menu').css("max-height",pMaxHeight);
					$('#'+id+'-button').addClass(pclass);
				});

				
				objTabla.find('input:checkbox, input:radio').each(function(){
					var lvalor = $(this).prop("checked");
					$(this).prop("checked",false);
					$(this).checkboxradio();
					$(this).prop("checked",lvalor);
					$(this).checkboxradio('refresh');
				});
				aplicaMask();
				aplicaCompleta();
			}

		}
		
		if(e.ctrlKey && e.shiftKey){ 
			var objTabla = $(e.target).closest("tbody");
			var totRen = $('tr',objTabla).length;
			var numTR = $(e.target).closest('tr').index() + 1;
			//console.log(' borrar renglon numTR '+numTR+' totRen '+totRen);
			if(totRen>0){
				var objdlg = $(e.target).closest(".ui-dialog");
				var objFrm = $(e.target).closest("form");
				
				if(totRen>1 && numTR>1){
					$('.inputs:last',$(e.target).closest("tr").prev()).focus();
				}else if(totRen>1 && numTR==1){
					$('.inputs:first',$(e.target).closest("tr").next()).focus();
				}else{
					$('.inputs:first',$(e.target).closest(".ui-dialog")).focus();
				}
				
				$(e.target).closest("tr").remove();
				if($('input[name=accion]',objFrm).val()!='eliminar'){
					$('input[name=guardaCache]',objFrm).val('1');
					$('.btnOK:first',objdlg).trigger('click');
				}
			}
		}else{



			//console.log($('.inputs',objdlg).eq(index).html());
		  
			$('.inputs',objdlg).eq(index).focus();
			
			if($('.inputs',objdlg).length==index){
				//$('button:contains("Ok")',objdlg).focus();
				$('.btnOK:first',objdlg).focus();
			}
		}
	  }
	});


	$(document).on('focusout', '.guardaCache', function(e) {
		var objdlg = $(this).closest(".ui-dialog");
		var objFrm = $(this).closest("form");
		//console.log('entrooooo '+$('input[name=accion]',objFrm).val());
		if($('input[name=accion]',objFrm).val()!='eliminar'){
			$('input[name=guardaCache]',objFrm).val('1');
			$('.btnOK:first',objdlg).trigger('click');
		}
	});

	
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
	var menuvisual = '';
	$('nav button').each(function(index, element){
		$(this).attr('tabindex','-1');
	});
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
				menuvisual = omenus[i].t;
			}
		}else{
			omenus[i].v = 0;
			//tmp = 'cierra'+omenus[i].t;
			otmp = omenus[i].c;
		}
	
		$('#menu'+omenus[i].t).animate(otmp, duracion );
		
		//console.log(tmp+' left '+$('#menu'+omenus[i].t).css('left')+' top '+$('#menu'+omenus[i].t).css('top'));
	}//for

	if(menuvisual!=''){
		var i = 9001;
		$('#menu'+menuvisual+' button').each(function(index, element){
			$(this).attr('tabindex',i);
			i++;
		});
		if(menuvisual=='der'){
			$('#xtema-button').attr("tabindex","10000");
		}else{
			$('#xtema-button').attr("tabindex","-1");
		}
		$('#menu'+menuvisual+' button').first().focus();
	}else{
		$('#btnMenu').focus();
	};
	
	
}//function

//===============================
//===============================
//===============================



function ConfirmDialog(message) {
    $('<div></div>').appendTo('body')
    .html('<div><h6>'+message+'?</h6></div>')
    .dialog({
        modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
        width: 'auto', resizable: false,
        buttons: {
            Yes: function () {
                // $(obj).removeAttr('onclick');                                
                // $(obj).parents('.Parent').remove();

                $('body').append('<h1>Confirm Dialog Result: <i>Yes</i></h1>');

                $(this).dialog("close");
            },
            No: function () {                                                                 
                $('body').append('<h1>Confirm Dialog Result: <i>No</i></h1>');

                $(this).dialog("close");
            }
        },
        close: function (event, ui) {
            $(this).remove();
        }
    });
};


//function llena_select(xml,pModulo,referenciaG,tagOpciones,pSelectMaxHeight,pclass){
function llena_select(xml,pModulo,referenciaG,tagOpciones){
	
	$('select[name*='+referenciaG+'] ').each(function(){
		
		var referencia = $(this).attr('id');
		var pvalor = '';
		
		if( referencia.indexOf('#') == -1  ){
	
		if ($('#dlg_accion_'+pModulo).val()=='agregar'){
			var pvalor = $('#'+referencia).val();
		};
		if(pvalor==''){
			var pvalor = $('#'+referencia).attr('pvalor');
			if(typeof pvalor == 'undefined' || pvalor == false){
				var pvalor = $(xml).find(referenciaG).text();
			}
				//console.log('ssss '+referenciaG+'   '+referencia+'   '+pvalor);
		}
			//var pvalor = $('#dlg_accion_'+pModulo).val()=='agregar' ? $('#'+referencia).val() : $('#'+referencia).attr('pvalor');
			//var pvalor =  $('#'+referencia).attr('pvalor');
			
			//$(xml).find('{$objeto['referencia']}').text();
			
			$('#'+referencia).find('option').remove().end();
			$(xml).find(tagOpciones).each(function(){
				valor 	= $(this).find('valor').text();
				texto	= $(this).find('texto').text();
				//console.log("entro....");
				if(valor==pvalor){
					
					$('#'+referencia).append($('<option></option>').attr('value', valor).attr('selected','selected').text(texto));
				}else{
					$('#'+referencia).append($('<option></option>').attr('value', valor ).text(texto));
				}
				
			});
			
			//$('#'+referencia).selectmenu({width: '100px'});
			//console.log('width select '+$('#'+referencia).attr("width"));
			$('#'+referencia).selectmenu({width: $('#'+referencia).attr("width")});
			$('#'+referencia).selectmenu("refresh");

			$('#'+referencia+'-menu').css("max-height",$('#'+referencia).attr("pMaxHeight"));
			$('#'+referencia+'-button').addClass($('#'+referencia).attr("pclass"));
				/*
			if(pSelectMaxHeight != ''){
				$('#'+referencia+'-menu').css("max-height",pSelectMaxHeight);
			}
			
			$('#'+referencia+'-button').addClass(pclass);
			*/
		};//if
	
	});
	
	
}

//funcion aplicaMask inicializada porque se contempla en las plantillas..
function aplicaMask(){};

//funcion aplicaCompleta inicializada porque se contempla en las plantillas..
function aplicaCompleta(){};

//custom autocomplete para mostrar listado en columnas
	$.widget('custom.mcautocomplete', $.ui.autocomplete, {
		_create: function() {
		  this._super();
		  this.widget().menu( "option", "items", "> :not(.ui-widget-header)" );
		  
		},
		_renderMenu: function(ul, items) {
			var self = this, thead;
		
			
			if (this.options.showHeader) {
				table=$('<div class="ui-widget-header"></div>');
				
				if($(ul).css('list-style-position')=='outside'){
					table.append('<div style="width:7px;display: inline-block;">&nbsp;</div>')
				}
				
				// Column headers
				$.each(this.options.columns, function(index, item) {
					table.append('<div class="' + item.class + '">' + item.name + '</div>');
				});
				ul.append(table);
			}
			// List items
			$.each(items, function(index, item) {
				self._renderItem(ul, item);
			});
		},
		_renderItem: function(ul, item) {
		
			var t = '',
				result = '';
			
			$.each(this.options.columns, function(index, column) {
				t += '<div class="' + column.class + '">' + item[column.valueField ? column.valueField : index] + '</div>'
			});
		
			result = $('<li></li>')
				.data('ui-autocomplete-item', item)
				.append('<div role="menuitem" style="display: inline-block;" >' + t + '</div>')
				.appendTo(ul);
				return result;
		}
	});

function exportarExcel(modulo){
	var url = "core/lee_modulo.php?exportarExcel=1&"+$("#fb_"+modulo).serialize()
		+ "&token=" + $('#token').val()+ "&appid=" + $('#appid').val();
	window.open(url, '_blank');
};

