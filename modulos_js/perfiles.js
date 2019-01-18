	$('#dlg_perfiles').dialog({
		autoOpen: false,
		width: 600,
		modal: true,
		buttons: [
    {
      text: "Ok",
      icons: { primary: "ui-icon-check" },
      click: function() {
        ABC_global($(this),'perfiles');
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
	
	
		
	

function llena_tabla_perfiles(cad_default,xml){
	var cad = cad_default;

	cad  = cad.replace(/##id_perfiles##/g,$(xml).find('id').text());
	cad  = cad.replace(/##nombre##/g,$(xml).find('nombre').text());

	return cad;
};

function llena_registro_perfiles(xml){
	$("#dlg_nombre_perfiles").val($(xml).find("nombre").text());
	
}

///////


buscar_inicio('perfiles');
agregar_registro_filtros('perfiles');
