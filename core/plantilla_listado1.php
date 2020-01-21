<?php
function simplePlantilla_listado1($aDat=array()){
	$pModulo = $aDat['modulo'];
	$pTabEliminar = isset($aDat['TabEliminar']) ? $aDat['TabEliminar'] : "-1";
	$pDlgTitulo = $aDat['aDlg']['titulo'];
	$pDlgWidth  = $aDat['aDlg']['width'];
	$pNumeroRegistros = $aDat['NumeroRegistros'];
	$pModuloEdicion = isset($aDat['moduloEdicion']) ? $aDat['moduloEdicion'] : '';

	$pContBtnAnterior = isset($aDat['contenido_boton_anterior']) ? $aDat['contenido_boton_anterior'] : '<i class="fa fa-step-backward"></i>';	
	$pContBtnSiguiente = isset($aDat['contenido_boton_siguiente']) ? $aDat['contenido_boton_siguiente'] : '<i class="fa fa-step-forward"></i>';	
	$pContBtnCambiar = isset($aDat['contenido_boton_editar']) ? $aDat['contenido_boton_editar'] : '<i class="fa fa-edit"></i>';	
	$pContBtnAgregar = isset($aDat['contenido_boton_agregar']) ? $aDat['contenido_boton_agregar'] : '<i class="fa fa-plus"></i>';	
	
	$tempBtnCambiar = '';
	$tempBtnAgregar = '';
	$jsAgregarRelacionModelos = '';
	if($pModuloEdicion != ''){
		$jsAgregarRelacionModelos = 'aRelModelos.push({"ModEdicion":"'.$pModuloEdicion.'","ModListado":"'.$pModulo.'"});';
		
		$tempBtnCambiar = <<<EOD
		<td><!--seguridad-{$pModuloEdicion}-cambiar--><button type="button" id="btnl2_{$pModulo}_##indice##" class="seguridad seg_{$pModuloEdicion}-cambiar" onclick="consultar_registro('##id##','cambiar','$pModuloEdicion')">{$pContBtnCambiar}</button><!--/seguridad--></td>
EOD;
		$tempBtnAgregar = <<<EOD
	<!--seguridad-{$pModuloEdicion}-agregar--><button class="seguridad seg_{$pModuloEdicion}-agregar" onclick="consultar_registro('0','agregar','$pModuloEdicion')">{$pContBtnAgregar}</button><!--/seguridad-->
EOD;
		
	};

	
	$pOpcionesFiltroCampos = "\n";
	foreach($aDat['FiltroCampos'] as $campo){
		$pOpcionesFiltroCampos .= <<<EOD
<input type="hidden" name="filtro_oplogico[]" value="{$campo['oplogico']}"/>
<input type="hidden" name="filtro_campo[]" value="{$campo['campo']}"/>
<input type="hidden" name="filtro_opcomparacion[]" value="{$campo['opcomparacion']}"/>
<input type="hidden" name="filtro_valor[]" value=""/>
<input type="hidden" name="filtro_ordenable[]" value="{$campo['ordenable']}"/>
\n
EOD;
	}
		

	$pColumnasEtiquetas = "";
	$pColumnasValor = "";
	$pColumnasCR = "";
	foreach($aDat['Columnas'] as $campo){
		$atributosTitCampo = '';
		if(isset($campo['atributosTit'])){
			foreach($campo['atributosTit'] as $key => $val){
				$atributosTitCampo .= " $key=\"$val\" ";
			}
		}
		$atributosCampo = '';
		if(isset($campo['atributos'])){
			foreach($campo['atributos'] as $key => $val){
				$atributosCampo .= " $key=\"$val\" ";
			}
		}
		$pColumnasEtiquetas .= "<td><div {$atributosTitCampo} >{$campo['etiqueta']}</div></td>";
		$pColumnasValor .= "<td><div {$atributosCampo} >##{$campo['valor']}##</div></td>";
		
		$pColumnasCR .= "cad  = cad.replace(/##{$campo['valor']}##/g,$(xml).find('{$campo['valor']}').text());\n";
	}
	$pParametrosFuncion = isset($aDat['ParametrosFuncion']) ? $aDat['ParametrosFuncion'] : array();
	$cadtmp = count($pParametrosFuncion)>0 ? '##' : '';
	$pPF = "'$cadtmp".implode("##','##",$pParametrosFuncion)."$cadtmp'";
	$pPF2 = "\'$cadtmp".implode("##\',\'##",$pParametrosFuncion)."$cadtmp\'";
	
	
	$cadres = <<<PLANTILLA1

<div id="dlg_$pModulo" title="$pDlgTitulo">
<div id="modulo-$pModulo">
<form name="fb_$pModulo" id="fb_$pModulo" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;" autocomplete="off">

$pOpcionesFiltroCampos

<input type="hidden" name="limite" value="$pNumeroRegistros"  id="{$pModulo}_limite"/>
<input type="hidden" name="modulo" value="$pModulo"/>
<input type="hidden" name="pagina" value="0"  id="{$pModulo}_pagina"/>



<input type="text" value="" id="filtro_valor_$pModulo" name="filtro_valor_$pModulo" style="width:150px;"/>
<button onclick="buscar_inicio('$pModulo')" tabindex="-1"><i class="fa fa-search"></i></button>
</form>

<!-- Agregar las columnas(etiquetas) de cada campo a visualizar -->
<div id="rb_$pModulo" style="width:100%; margin-top:30px;">
	<table   id="table-$pModulo" cellpadding="5" cellspacing="0" border="0"  class="table table-responsive ui-widget ui-widget-content ">
		<thead><tr class="ui-widget-header ">$pColumnasEtiquetas<td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
		$tempBtnAgregar
		<button onclick="buscar_plus('$pModulo','anterior')" tabindex="-1"> $pContBtnAnterior </button>
		<button onclick="buscar_plus('$pModulo','siguiente')" tabindex="-1"> $pContBtnSiguiente </button>
	</div>
</div><!--termina rb-->          


<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-$pModulo" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##">$pColumnasValor<td><button type="button" id="btnl1_{$pModulo}_##indice##"  class="" onclick="eval(fcomun_$pModulo +'($pPF2)')"><i class="fa fa-hand-pointer"></i></button></td>{$tempBtnCambiar}</tr>
</table>

</div><!--termina modulo-$pModulo-->
</div><!--termina dlg-$pModulo-->


<script type="text/javascript">
var fcomun_$pModulo = '' ;

	$('#dlg_$pModulo').dialog({
		autoOpen: false,
		width: $pDlgWidth,
		modal: true,
		open: function( event, ui ) {
			 $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
			 $("#filtro_valor_$pModulo").focus();
			buscar_inicio('$pModulo');
		},		
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
	
	
		


function llena_tabla_$pModulo(cad_default,xml){
	var cad = cad_default;
	$pColumnasCR
	return cad;
};

var lmismo_$pModulo = true;
$("#filtro_valor_$pModulo").keyup(function(e){
	var code = (e.keyCode ? e.keyCode : e.which);
	//console.log('keyup '+code+' '+lmismo_$pModulo+' key:'+$(this).val()+' ant:'+$("#fb_$pModulo input[name*='filtro_valor']").first().val());
	if(code==33 || code==34){
		if(!lmismo_$pModulo){
			buscar_inicio('$pModulo');
			lmismo_$pModulo = true;
		}else{
			var cSentido = code==34 ? 'siguiente' : 'anterior';
			buscar_plus('$pModulo',cSentido);
		}
	}else{
		lmismo_$pModulo = $("#fb_$pModulo input[name*='filtro_valor']").first().val() == $(this).val();
		$("#fb_$pModulo input[name*='filtro_valor']").val($(this).val());
	}
});

$("#filtro_valor_$pModulo").keypress(function(e){
	var code = (e.keyCode ? e.keyCode : e.which);
	if(code==13){
		e.preventDefault();
		ultimoFocoBtn['$pModulo'] = null;
		buscar_inicio('$pModulo');
	}
});

buscar_inicio('$pModulo');

$jsAgregarRelacionModelos


</script>

PLANTILLA1;
return $cadres;
};
	


?>