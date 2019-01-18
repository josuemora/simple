/*
	$('#dlg_alumnos').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: [
    {
      text: "Ok",
      icons: { primary: "ui-icon-check" },
      click: function() {
        ABC_global($(this),'alumnos');
      }
 
    },
    {
      text: "Cancelar",
      icons: { primary: "ui-icon-close" },
      click: function() {
        $( this ).dialog( "close" );
      }
 
    }
	
  ]
	});
	
	
		
	
	

function llena_tabla_alumnos(cad_default,xml){
	var cad = cad_default;

	cad  = cad.replace(/##id_alumnos##/g,$(xml).find('id').text());
	cad  = cad.replace(/##nombre##/g,$(xml).find('nombre').text());
	cad  = cad.replace(/##paterno##/g,$(xml).find('paterno').text());
	cad  = cad.replace(/##materno##/g,$(xml).find('materno').text());
	//cad  = cad.replace(/##grupo##/g,$(xml).find('grado').text()+' '+$(xml).find('salon').text()+' '+$(xml).find('turno').text());
	cad  = cad.replace(/##grupo##/g,$(xml).find('grupo').text());
	cad  = cad.replace(/##sexo##/g,$(xml).find('sexo').text());
	return cad;
};



function llena_registro_alumnos(xml){
	//llena_select_grupos($(xml).find("grupos_id").text());
	
	$( "#fdlg_alumnos input:checkbox,#fdlg_alumnos input:radio" ).checkboxradio();
	
	//select
	var pvalor = $("#dlg_accion_alumnos").val()=="agregar" ? $('#dlg_grupos_id_alumnos').val() : $(xml).find("grupos_id").text();
	
	$('#dlg_grupos_id_alumnos').find('option').remove().end();
	$(xml).find("grupos").each(function(){
		valor 	= $(this).find('valor').text();
		texto	= $(this).find('texto').text();
		if(valor==pvalor){
			$('#dlg_grupos_id_alumnos').append($('<option></option>').attr('value', valor).attr('selected','selected').text(texto));
		}else{
			$('#dlg_grupos_id_alumnos').append($('<option></option>').attr('value', valor ).text(texto));
		}
		
	});
	
	$('#dlg_grupos_id_alumnos').selectmenu();
	$('#dlg_grupos_id_alumnos').selectmenu("refresh");
	$('#dlg_grupos_id_alumnos-button').addClass("inputs");

	
	//radio
	//$('#dlg_sexo_'+($(xml).find("sexo").text())+'_alumnos').prop("checked",true);
	$('#dlg_sexo_'+($(xml).find("sexo").text())+'_alumnos').prop("checked",true);
	//$('#dlg_sexo_'+($(xml).find("sexo").text())+'_alumnos').checkboxradio("refresh");

	
	//checkbox
	//$("#dlg_usalentes_alumnos").prop("checked",$(xml).find("usalentes").text()=='s');
	//$("#dlg_enfermedad_alumnos").prop("checked",$(xml).find("enfermedad").text()=='s');
	//$("#dlg_capacidaddiferente_alumnos").prop("checked",$(xml).find("capacidaddiferente").text()=='s');
	$("#dlg_usalentes_alumnos").prop("checked",$(xml).find("usalentes").text()=='s');
	$("#dlg_enfermedad_alumnos").prop("checked",$(xml).find("enfermedad").text()=='s');
	$("#dlg_capacidaddiferente_alumnos").prop("checked",$(xml).find("capacidaddiferente").text()=='s')
	
	
	
	//text
	$("#dlg_nombre_alumnos").val($(xml).find("nombre").text());
	$("#dlg_paterno_alumnos").val($(xml).find("paterno").text());
	$("#dlg_materno_alumnos").val($(xml).find("materno").text());
	
	
	//alert($('#dlg_grupos_id_alumnos').html()+'    <<>>'+$("#fdlg_alumnos").serialize());
	$('#fdlg_alumnos input:checkbox,#fdlg_alumnos input:radio').checkboxradio("refresh");
	
}

*/

///////


//buscar_inicio('alumnos');
////////llena_select_grupos();


//agregar_registro_filtros('alumnos');




//===================================================
//===================================================
//===================================================
//===================================================
/*
	$('#dlg_lalumnos').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: [
    {
      text: "Cancelar",
      icons: { primary: "ui-icon-close" },
      click: function() {
        $( this ).dialog( "close" );
      }
 
    }
	
  ]
	});

function llena_tabla_lalumnos(cad_default,xml){
	var cad = cad_default;

	cad  = cad.replace(/##id_alumnos##/g,$(xml).find('id').text());
	cad  = cad.replace(/##nombre##/g,$(xml).find('nombre').text());
	cad  = cad.replace(/##paterno##/g,$(xml).find('paterno').text());
	cad  = cad.replace(/##materno##/g,$(xml).find('materno').text());
	cad  = cad.replace(/##grupo##/g,$(xml).find('grado').text()+' '+$(xml).find('salon').text()+' '+$(xml).find('turno').text());
	return cad;
};

$("#filtro_valor_lalumnos").keyup(function(event){
	$("#fb_lalumnos input[name*='filtro_valor']").val($(this).val());
});
buscar_inicio('lalumnos');

*/