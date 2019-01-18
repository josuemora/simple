	$('#dlg_usuarios').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: [
    {
      text: "Ok",
      icons: { primary: "ui-icon-check" },
      click: function() {
        ABC_global($(this),'usuarios');
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
	
	
		
	

function llena_tabla_usuarios(cad_default,xml){
	var cad = cad_default;

	cad  = cad.replace(/##id_usuarios##/g,$(xml).find('id').text());
	cad  = cad.replace(/##nombre##/g,$(xml).find('nombre').text());
	cad  = cad.replace(/##perfil##/g,$(xml).find('perfil').text());

	return cad;
};

function llena_registro_usuarios(xml){
	
	//select
	var pvalor = $("#dlg_accion_usuarios").val()=="agregar" ? $('#dlg_perfiles_id_usuarios').val() : $(xml).find("perfiles_id").text();
	
	$('#dlg_perfiles_id_usuarios').find('option').remove().end();
	$(xml).find("perfiles").each(function(){
		valor 	= $(this).find('valor').text();
		texto	= $(this).find('texto').text();
		if(valor==pvalor){
			$('#dlg_perfiles_id_usuarios').append($('<option></option>').attr('value', valor).attr('selected','selected').text(texto));
		}else{
			$('#dlg_perfiles_id_usuarios').append($('<option></option>').attr('value', valor ).text(texto));
		}
		
	});
	$('#dlg_perfiles_id_usuarios').selectmenu();
	$('#dlg_perfiles_id_usuarios').selectmenu("refresh");
	$('#dlg_perfiles_id_usuarios-button').addClass("inputs");



	$("#dlg_nombre_usuarios").val($(xml).find("nombre").text());
	
}

///////


buscar_inicio('usuarios');
agregar_registro_filtros('usuarios');
