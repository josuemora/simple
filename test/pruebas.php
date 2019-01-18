<script type="text/javascript">
/*
$(document).keydown(function (e) {
	e.preventDefault();
	if(e.which == 18){
		$('#tabs').tabs({disabled: []}).find('a[href="#tabs_1"]').trigger('click');
	}
	return false;
 });
*/
/*
var isAlt = false;
$(document).keyup(function (e) {
	if(e.which == 18) isAlt=false;
	//console.log('keyup '+e.which+' isAlt '+isAlt);
}).keydown(function (e) {
    if(e.which == 18) isAlt=true;
	//console.log('kedown '+e.which+' isAlt '+isAlt);
    if(e.which == 65 && isAlt == true) {
		$('#tabs').tabs({disabled: []}).find('a[href="#tabs_1"]').trigger('click');
 		return false;
 	}
    if(e.which == 71 && isAlt == true) {
		$('#tabs').tabs({disabled: []}).find('a[href="#tabs_2"]').trigger('click');
 		return false;
 	}
    if(e.which == 65 && isAlt == true) {
		//isAlt=false;
		$('#tabs').tabs({disabled: []}).find('a[href="#tabs_1"]').trigger('click');
 		return false;
 	}
});
*/

$(document).keydown(function (e)
{
//console.log('paso '+e.altKey+' ' +e.keyCode +' '+e.key+' '+String.fromCharCode(parseInt(e.keyCode,10)));
    // warning: only tested with EN-US keyboard / locale
    // check whether ALT pressed (and not ALT+CTRL, ALT+SHIFT, etc)
	
	var code = e.keyCode || e.which;
	
	//console.log(code);
	/*
	if($('.regSeleccionado').size()>0 && code==13){
		$('.regSeleccionado button').first().focus();
	}
	*/
	var key =  String.fromCharCode(code);
    //var key = e.key || String.fromCharCode(e.keyCode);
//    var key = String.fromCharCode(parseInt(e.keyCode,10));
    if (e.altKey && !e.ctrlKey && !e.shiftKey && key)
    {
		//console.log(e.target.nodeName+' '+e.target.nodeType);
        // if ALT pressed, handle the keycode shortcut
        var keyPressed = key.toUpperCase(); // normalize input
        switch (keyPressed)
        {
            case "A":
                // do stuff for ALT-C
				//console.log('keyup '+keyPressed);
				$('#tabs').tabs({disabled: []}).find('a[href="#tabs_1"]').trigger('click');
				//e.preventDefault();
				
				return false;

                break;
            case "G":
                // do stuff for ALT-H 
				//console.log('keyup '+keyPressed);
				$('#tabs').tabs({disabled: []}).find('a[href="#tabs_2"]').trigger('click');
				return false;
                break;
            case "U":
                // do stuff for ALT-H 
				//console.log('keyup '+keyPressed);
				$('#tabs').tabs({disabled: []}).find('a[href="#tabs_3"]').trigger('click');
				return false;
                break;
            case "S":
				$('#btn_salir').trigger('click');
				return false;
                break;
            case "P":
	/*		
﻿	var datos = ""
	datos = datos + chr(27) + chr(64);
	datos = datos + "Favor de Pasar a Caja Preferencial"+chr(10);
	datos = datos + "Cotizacion No. no_orden"+chr(10);
	datos = datos + "Fecha :  fecha"+chr(10);
	datos = datos + "Hora :  hora"+chr(10);
	datos = datos + "Puntos:  puntos"+chr(13)+chr(10);
	datos = datos + "Total :  total"+chr(10);
	datos = datos + chr(29)+"V"+chr(66)+chr(60);
	*/
	datos = "-reset-impresion con HTA|esta es otra prueba|algo que se vea|Guadalajara|Jalisco|México|cp 45100-cut-";
	impresora = "termica";
			
			
				parent.imprime(datos,impresora);
				return false;
                break;
				
            case "X":
			
	datos = "-reset-impresion con PROXY|como siempre|esta es otra prueba|algo que se vea|Guadalajara|Jalisco|México|cp 45100-cut-";
	impresora = "termica";
	ipImpresora = "10.1.9.81";
	ipSocket =  "10.1.9.81";
	pathScript = '/impresion/imprime_directo.php';
			
				pruebaCORS(datos,impresora,ipSocket,ipImpresora,pathScript);
				return false;
                break;


            case "J":
			
	datos = "-reset-|impresion con JAVA|como siempre|esta es otra prueba|algo que se vea|Guadalajara|Jalisco|México|cp 45100|-cut-";

	impresora = "termica";
			//alert('con java');
				imprimeConJava(datos,impresora);
				return false;
                break;

				
        }

    }//if Alt keys
		
    if (!e.altKey && e.ctrlKey && e.shiftKey && key)
    {
		        var keyPressed = key.toUpperCase(); // normalize input
				
		switch (keyPressed){
            case "1": menu('izq','abre');	break;
            case "2": menu('der','abre');	break;
            case "3": menu('arr','abre');	break;
            case "4": menu('aba','abre');	break;
		}
		if(/*code==37 ||*/ code ==38){//arriba //regreso
			//console.log('arriba regreso');
			if($('.regSeleccion').size()>0){
				if($('.regSeleccionado').size()>0){
					objSel = $('.regSeleccionado').last();
					$(objSel).removeClass('regSeleccionado')
					$(objSel).prev().addClass('regSeleccionado');
					if($('.regSeleccionado').size()==0){
						$('.regSeleccion').last().addClass('regSeleccionado');
					}
				}else{
					$('.regSeleccion').last().addClass('regSeleccionado');
				}
				$('.regSeleccionado button').first().focus();
			
			}
			
		}
		if(/*code==39 ||*/ code ==40){//abajo //siguiente
			//console.log('abajo siguiente');
			if($('.regSeleccion').size()>0){
				if($('.regSeleccionado').size()>0){
					objSel = $('.regSeleccionado').first();
					$(objSel).removeClass('regSeleccionado')
					$(objSel).next().addClass('regSeleccionado');
					if($('.regSeleccionado').size()==0){
						$('.regSeleccion').first().addClass('regSeleccionado');
					}
				}else{
					$('.regSeleccion').first().addClass('regSeleccionado');
				}
				$('.regSeleccionado button').first().focus();
			
			}
		}
	}
		
});


function pruebaCORS(datos,impresora,ipSocket,ipImpresora,pathScript){
	//jQuery.support.cors = true;
	if (typeof XDomainRequest != "undefined") {	//IE
	
		var xdr = new XDomainRequest();
		xdr.open("post", 'http://'+ipSocket+pathScript);
		xdr.onprogress = function () { };
		xdr.ontimeout = function () { };
		xdr.onerror = function () { };
		xdr.onload = function() {
		  alert(xdr.responseText);
		}
		postData = 'datos='+datos+'&impresora='+impresora+'&ipSocket='+ipSocket+'&ipImpresora='+ipImpresora;
		//alert(postData);
		setTimeout(function () {xdr.send(postData);}, 0);

	}else{// not IE
		$.ajax({
			url: 'http://'+ipSocket+pathScript,
			dataType: "html",
			type : "POST",
			data: {"datos":datos,"impresora":impresora,"ipImpresora":ipImpresora},
			beforeSend: function(){
			},
			success: function( data ) {
				alert(data);
			},
			error: function(jqXHR, exception) {
				//cont = cont - 1;
				//flagtouch = 0;
				//var totalTime = new Date().getTime()-ajaxTime;
				var cad = 'Error Ajax';
				if (jqXHR.status === 0) {
					cad = 'Not connect.\n Verify Network.';
				} else if (jqXHR.status == 404) {
					cad = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
					cad = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
					cad = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
					cad = 'Time out error.';
				} else if (exception === 'abort') {
					cad = 'Ajax request aborted.';
				} else {
					cad = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				alert(cad);
				/*
					cad = '<tr><td>'+cad+' XHR status '+jqXHR.status+'</td><td>'+totalTime+'</td></tr>';
					$("#tblerror > tbody").append(cad);
					contN = contN + 1;
					$("#negativas").html('Negativas '+contN);
				*/
				
			}		
			
		});
	};
	
}


/*
function lanza2(obj){
	tiempodisparo =  new Date().getTime();
	objcaptura = obj;
	realizaDisparo(tiempodisparo);
};


var xhr = null;

function realizaDisparo(totalTime){
	//console.log(totalTime);
	if(xhr && xhr.readyState != 4) { 
		xhr.abort();
	}


	if(objcaptura.value != ''){	
		xhr = $.ajax({
			type: 'POST',
			url: 'consultas/captura.php',
			data: {
			  'nombre':objcaptura.name,
			  'origen':objcaptura.value
			},
			success:function(msg) {
			   //console.log(msg);
			   if(modulo != ''){
			   		buscar_inicio(modulo);
			   };
			}
		});	
	}
}
*/

/*
$(document).keydown(function (e)
{
	console.log(e);
});

$(document).keyup(function (e)
{
	console.log(e);
});

$(document).keypress(function (e)
{
	if(e.altKey){return false;}
});
$(document).keyup(function (e)
{
	if(e.altKey){return false;}
});
*/








var modulo = '';
inputDispara = function (e)
{
	if(e.target.id.substr(0,4)!='dlg_'){
		var form = $(e.target).parents('form');	
		modulo = $("input[name='modulo']",form).val();
		var code = e.keyCode || e.which;
		
		var key =  String.fromCharCode(code);
		if(!(code>=9 && code<=45)){
			lanza(e.target);
		}
	}
};
$('input').keyup(inputDispara);


var tiempodisparo = 0;
var objcaptura = null;
function lanza(obj){
	tiempodisparo =  new Date().getTime();
	//console.log(tiempodisparo);
	objcaptura = obj;
	lanzador();
	
};

var checkdisparo;
function lanzador(){
	var totalTime = new Date().getTime() - tiempodisparo;
	clearTimeout(checkdisparo);
	if(totalTime > 900){
		if(modulo != ''){
			buscar_inicio(modulo);
		};

		//realizaDisparo(totalTime);
	}else{
		checkdisparo =  setTimeout(lanzador, 80);
	};
	
};


</script>