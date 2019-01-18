	$('#dlg_accesos').dialog({
		autoOpen: false,
		width: 800,
		modal: true,
		buttons: [
    {
      text: "Ok",
      icons: { primary: "ui-icon-check" },
      click: function() {
        ABC_global($(this),'accesos');
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
	
	
		
	
	
	

function llena_tabla_accesos(cad_default,xml){
	var cad = cad_default;

	cad  = cad.replace(/##id_accesos##/g,$(xml).find('id').text());
	//cad  = cad.replace(/##appid##/g,$(xml).find('appid').text());
	cad  = cad.replace(/##perfil##/g,$(xml).find('perfil').text());
	cad  = cad.replace(/##permisos##/g,$(xml).find('permisos').text());
	return cad;
};

function llena_registro_accesos(xml){
	//checkboxradio...
	$( "#fdlg_accesos input:checkbox" ).checkboxradio();
	//$( "#fdlg_accesos input:checkbox" ).checkboxradio('refresh');
	
	
	//select
	var pvalor = $("#dlg_accion_accesos").val()=="agregar" ? $('#dlg_perfiles_id_accesos').val() : $(xml).find("perfiles_id").text();
	
	$('#dlg_perfiles_id_accesos').find('option').remove().end();
	$(xml).find("perfiles").each(function(){
		valor 	= $(this).find('valor').text();
		texto	= $(this).find('texto').text();
		if(valor==pvalor){
			$('#dlg_perfiles_id_accesos').append($('<option></option>').attr('value', valor).attr('selected','selected').text(texto));
		}else{
			$('#dlg_perfiles_id_accesos').append($('<option></option>').attr('value', valor ).text(texto));
		}
		
	});
	
	$('#dlg_perfiles_id_accesos').selectmenu();
	$('#dlg_perfiles_id_accesos').selectmenu("refresh");
	$('#dlg_perfiles_id_accesos-button').addClass("inputs");

	
	
	genera_btns_disponibles($(xml).find("permisos").text());
	//$( "#fdlg_accesos input:checkbox" ).checkboxradio('refresh');
	
}

function genera_btns_disponibles(btns_activados){
	//alert(btns_activados);
	
	$("#fdlg_accesos input:checkbox").each(function(){
		
		var check = btns_activados.indexOf($(this).val()) != -1;
		$(this).prop("checked",check);
		$(this).checkboxradio("refresh");
		$(this).closest("tr").css("display","");
	});	


}





function poncheck_accesos(obj){
	var check = $(obj).prop("checked");
	$("#fdlg_accesos input:checkbox").each(function(){
		if($(this).closest("tr").css("display")!='none'){
			$(this).prop("checked",check);
			$(this).checkboxradio("refresh");
		}

	});
}


function FiltraAccesos() {
	var tmp, filter
	filter = $("#dlg_perfiles_filtro").val().toUpperCase();
	$("#tableAccesos tr").each(function(){
		tmp = $("td:first-child h4",this).html();
		if(tmp.toUpperCase().indexOf(filter) > -1){
			$(this).css("display","");
		}else{
			$(this).css("display","none");
		}
	});

}

///////


buscar_inicio('accesos');
agregar_registro_filtros('accesos');
