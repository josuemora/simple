<?php
function simplePlantilla1($aDat=array()){
	$pModulo = $aDat['modulo'];
	$pTabEliminar = isset($aDat['TabEliminar']) ? $aDat['TabEliminar'] : "-1";
	$pDlgTitulo = $aDat['aDlg']['titulo'];
	$pDlgWidth  = $aDat['aDlg']['width'];
	$pDlgHeight = isset($aDat['aDlg']['height']) ? 'height: '.$aDat['aDlg']['height'].',' : '';
	$pSeguirAgregando = isset($aDat['SeguirAgregando']) ? $aDat['SeguirAgregando'] : '1';
	$pDlgEventoAlAbrir = isset($aDat['EventoAlAbrir']) ? $aDat['EventoAlAbrir'] : '';




	$subPlantilla = '';
	$funcionSubPlantilla = '';
	if(isset($aDat['subPlantilla']['contenido'])
		&& isset($aDat['subPlantilla']['CampoMaestroEnlace'])
		&& isset($aDat['subPlantilla']['CampoDetalleEnlace'])	
		&& isset($aDat['subPlantilla']['modulo'])){
		$subPlantilla 			= $aDat['subPlantilla']['contenido'];
		$funcionSubPlantilla	= <<<EOD
		$("#fb_{$aDat['subPlantilla']['modulo']} input[name*='filtro_valor']").val($("#dlg_{$aDat['subPlantilla']['CampoMaestroEnlace']}_$pModulo").val());
		$("#fdlg_{$aDat['subPlantilla']['modulo']} input[name*='{$aDat['subPlantilla']['CampoDetalleEnlace']}']").val($("#dlg_{$aDat['subPlantilla']['CampoMaestroEnlace']}_$pModulo").val());
		ultimoFocoBtn['{$aDat['subPlantilla']['modulo']}'] = null;
		buscar_inicio('{$aDat['subPlantilla']['modulo']}');
EOD;
	}

	$pOpcionesFiltroCampos = "\n";
	$cadTDF = '';
	$cadTVF = '';
	$cadJSF = '';
	foreach($aDat['FiltroCampos'] as $campo){
		if(isset($campo['oplogico'])){
			$cadTVF .= <<<EOD
<input type="hidden" name="filtro_oplogico[]" value="{$campo['oplogico']}"/>
<input type="hidden" name="filtro_campo[]" value="{$campo['campo']}"/>
<input type="hidden" name="filtro_opcomparacion[]" value="{$campo['opcomparacion']}"/>
<input type="hidden" name="filtro_valor[]" value=""/>
<input type="hidden" name="filtro_ordenable[]" value="{$campo['ordenable']}"/>
\n
EOD;
		}else if(isset($campo['etiqueta'])){
			$pOpcionesFiltroCampos .= "<option value=\"{$campo['valor']}\">{$campo['etiqueta']}</option>\n";
		}
	}
	
	if($cadTVF != ''){
		$pNumeroRegistros = $aDat['NumeroRegistros'];
		$cadTVF .= <<<EOD
<input type="hidden" name="limite" value="$pNumeroRegistros"  id="{$pModulo}_limite"/>
EOD;
	}else{
		$pNumeroRegistros = "\n";
		foreach($aDat['NumeroRegistros'] as $campo){
			$pNumeroRegistros .= "<option value=\"{$campo['valor']}\">{$campo['etiqueta']}</option>\n";
		}
	}

	$pContBtnAgregar = '';
	$pContBtnCambiar = '';
	$pContBtnEliminar = '';
	
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
		
		if($campo['valor'] != '##boton_cambiar##' && $campo['valor'] != '##boton_eliminar##' && $campo['valor'] != '##indice##'  ){
			$pColumnasEtiquetas .= "<td><div {$atributosTitCampo} >{$campo['etiqueta']}</div></td>";
			$pColumnasValor .= "<td><div {$atributosCampo} >##{$campo['valor']}##</div></td>";
			$pColumnasCR .= "cad  = cad.replace(/##{$campo['valor']}##/g,$(xml).find('{$campo['valor']}').text());\n";
		}
		
		if($campo['valor'] == '##boton_cambiar##'){
			$pContBtnCambiar = $campo['etiqueta'];
			$pColumnasEtiquetas .= "<td></td>";
			$pColumnasValor .= "<td>##boton_cambiar##</td>";
		}

		if($campo['valor'] == '##boton_eliminar##' ){
			$pContBtnEliminar = $campo['etiqueta'];
			$pColumnasEtiquetas .= "<td></td>";
			$pColumnasValor .= "<td>##boton_eliminar##</td>";
		}

		if($campo['valor'] == '##indice##' ){
			$pContBtnEliminar = $campo['etiqueta'];
			$pColumnasEtiquetas .= "<td>No.</td>";
			$pColumnasValor .= "<td>##indice##</td>";
		}
		
	}

	
	if($pContBtnCambiar == ''){
		$pContBtnCambiar = '<i class="fa fa-edit"></i>';
		$pColumnasEtiquetas = "<td></td>".$pColumnasEtiquetas;
		$pColumnasValor = "<td>##boton_cambiar##</td>".$pColumnasValor;
	}

	if($pContBtnEliminar == '' ){
		$pContBtnEliminar = '<i class="fa fa-trash"></i>';
		$pColumnasEtiquetas .= "<td></td>";
		$pColumnasValor .= "<td>##boton_eliminar##</td>";
	}
	
	$tempBtnCambiar = <<<EOD
	<!--seguridad-{$pModulo}-cambiar--><button type="button" id="btn1_{$pModulo}_##indice##" class="seguridad seg_alumnos-cambiar" onclick="consultar_registro('##id##','cambiar','$pModulo')">{$pContBtnCambiar}</button><!--/seguridad-->
EOD;

	$tempBtnEliminar = <<<EOD
	<!--seguridad-{$pModulo}-eliminar--><button type="button" id="btn2_{$pModulo}_##indice##"  class="seguridad seg_alumnos-eliminar" onclick="consultar_registro('##id##','eliminar','$pModulo')" tabindex="$pTabEliminar">{$pContBtnEliminar}</button><!--/seguridad-->
EOD;


		$pColumnasValor = str_replace('##boton_cambiar##',$tempBtnCambiar,$pColumnasValor);
		$pColumnasValor = str_replace('##boton_eliminar##',$tempBtnEliminar,$pColumnasValor);



	$pContBtnAgregar = isset($aDat['contenido_boton_agregar']) ? $aDat['contenido_boton_agregar'] : '<i class="fa fa-plus"></i>';	
	$pContBtnAnterior = isset($aDat['contenido_boton_anterior']) ? $aDat['contenido_boton_anterior'] : '<i class="fa fa-step-backward"></i>';	
	$pContBtnSiguiente = isset($aDat['contenido_boton_siguiente']) ? $aDat['contenido_boton_siguiente'] : '<i class="fa fa-step-forward"></i>';	
	$pContBtnBuscar = isset($aDat['contenido_boton_buscar']) ? $aDat['contenido_boton_buscar'] : '<i class="fa fa-search"></i>';	
		
	$tempBtnAgregar = <<<EOD
	<!--seguridad-{$pModulo}-agregar--><button class="seguridad seg_alumnos-agregar" onclick="consultar_registro('0','agregar','$pModulo')">{$pContBtnAgregar}</button><!--/seguridad-->
EOD;
		
		
		
	
	$pDlgRenglones = '';
	$pDlgCR = '';
	$pDlgTCR = '';
	$pFuncionesBotonLista = '';
	$flagCheckboxradio = 0;
	foreach($aDat['DlgRenglones'] as $renglon){
		$pDlgRenglones .= '<tr';
		foreach($renglon['atributos'] as $key => $val){
			$pDlgRenglones .= " $key=\"$val\" ";
		}
		$pDlgRenglones .= ">\n";
		
		foreach($renglon['columnas'] as $columna){
			$pDlgRenglones .= '<td';
			foreach($columna['atributos'] as $key => $val){
				$pDlgRenglones .= " $key=\"$val\" ";
			}
			$pDlgRenglones .= "> \n";
			foreach($columna['objetos'] as $NumRen=>$objeto){
				$aatributos = isset($objeto['atributos']) ? $objeto['atributos'] : array();
				$atributos = '';
				$width = '';
				if(isset($objeto['class'])){
					$aatributos['class'] = $objeto['class'];
				};
				if(isset($objeto['style'])){
					$aatributos['style'] = $objeto['style'];
				};
				if(isset($objeto['width'])){
					$aatributos['width'] = $objeto['width'];
				};
				foreach($aatributos as $key => $val){
					if($key == 'class' || $key == 'style' || $key == 'width'){
						$$key = $val;
					}
					$atributos .= " $key=\"$val\" ";
				}
				if($objeto['tipo']=='etiqueta' || $objeto['tipo']=='html'){
					$pDlgRenglones .= $objeto['referencia']."\n";
				}
				if($objeto['tipo']=='text' || $objeto['tipo']=='hidden'){
					//$pDlgRenglones .= "<input type=\"{$objeto['tipo']}\" class=\"$class\" id=\"dlg_{$objeto['referencia']}_$pModulo\" name=\"{$objeto['referencia']}\" value=\"\" style=\"$style\" />\n";

					$pDlgRenglones .= "<input type=\"{$objeto['tipo']}\" id=\"dlg_{$objeto['referencia']}_$pModulo\" name=\"{$objeto['referencia']}\" value=\"\" $atributos />\n";
					
					$pDlgCR .= "$(\"#dlg_{$objeto['referencia']}_$pModulo\").val($(xml).find(\"{$objeto['referencia']}\").text());\n";
				}
				if($objeto['tipo']=='table'){
					
					$pasaTotales = '';
					
					$Tabtit = '';
					if($objeto['muestraEncabezado']==true){
						$Tabtit = '<thead><tr>';
						foreach($objeto['columnas'] as $aCol){
							$aatributos = isset($aCol['atributos']) ? $aCol['atributos'] : array();
							$atributos = '';
							foreach($aatributos as $key => $val){
								$atributos .= " $key=\"$val\" ";
							}
							$Tabtit .= "<th $atributos>{$aCol['titulo']}</th>";
						}		
						$Tabtit .= '</tr></thead>';
					}
					
					$Tabpie = '';
					if($objeto['muestraPie']==true){
						$Tabpie = '<tfoot><tr>';
						foreach($objeto['columnas'] as $aCol){
							$aatributos = isset($aCol['atributos']) ? $aCol['atributos'] : array();
							$atributos = '';
							foreach($aatributos as $key => $val){
								$atributos .= " $key=\"$val\" ";
							}
							$Tabpie .= "<th $atributos>";
							if(isset($aCol['pie'])){
								$aatributos = isset($aCol['pie']['atributos']) ? $aCol['pie']['atributos'] : array();
								$pieatributos = '';
								foreach($aatributos as $key => $val){
									$pieatributos .= " $key=\"$val\" ";
								}
								if(isset($aCol['pie']['titulo'])){
									$Tabpie .= "<span $pieatributos>{$aCol['pie']['titulo']}</span>";
								}
								if(isset($aCol['pie']['referencia'])){
									$Tabpie .= "<input type=\"text\" id=\"dlg_{$aCol['pie']['referencia']}_{$pModulo}\" name=\"{$aCol['pie']['referencia']}\" value=\"\" $pieatributos />";
									$pasaTotales .= "$('#dlg_{$aCol['pie']['referencia']}_{$pModulo}').val($('{$aCol['pie']['referencia']}',this).text());\n";
								}
							}else{
								$Tabpie .= '&nbsp;';
							}
							$Tabpie .= "</th>";
						}		
						$Tabpie .= '</tr></tfoot>';
					}
					
					//$Tabpie = "<tfoot><td style=\"width:80px;\"></td><td style=\"width:250px;\"><span>Totales</span></td><td style=\"width:100px;\"></td><td style=\"width:100px;\"></td><td style=\"width:100px;\"><input type=\"text\" style=\"width:90%;\"</td></tfoot>";
					
					$pDlgRenglones .= "<table id=\"dlg_{$objeto['referencia']}_$pModulo\" >{$Tabtit}<tbody></tbody>{$Tabpie}</table>";
					
					
					$pCamposTabla = '';
					$pSelectTabla = '';
					$pCheckBoxTabla = '';
					$pTabRen = "<tr class=\"trow\"><input type=\"hidden\" name=\"NumRen[]\" value=\"##indice##\" />";
					foreach($objeto['columnas'] as $aColObjetos){
						$aatributos = isset($aColObjetos['atributos']) ? $aColObjetos['atributos'] : array();
						$atributos = '';
						foreach($aatributos as $key => $val){
							$atributos .= " $key=\"$val\" ";
						}
						$pTabRen .= "<td  $atributos >";
					foreach($aColObjetos['objetos'] as $aCol){
						$aatributos = isset($aCol['atributos']) ? $aCol['atributos'] : array();
						$atributos = '';
						$class = '';
						$style = '';
						$width = '';
						$MaxHeight = '';
						foreach($aatributos as $key => $val){
							//if($key == 'class'){
							//	$val .= ' campoDir';
							//}
							if($key == 'class' || $key == 'style' || $key == 'width'){
								$$key = $val;
							}
							if($key == 'max-height'){
								$MaxHeight = $val;
							}
							$atributos .= " $key=\"$val\" ";
						}

						if($aCol['tipo']=='text'){
							$pCamposTabla .= "cad  = cad.replace(/##{$aCol['referencia']}##/g,$(this).find('{$aCol['referencia']}').text());\n";
							$pTabRen .= "<input type=\"text\" id=\"dlg_{$aCol['referencia']}_{$pModulo}_##indice##\" name=\"{$aCol['referencia']}_##indice##\" value=\"##{$aCol['referencia']}##\" $atributos />";
						}
						
						if($aCol['tipo']=='select'){
							$pCamposTabla .= "cad  = cad.replace(/##{$aCol['referencia']}##/g,$(this).find('{$aCol['referencia']}').text());\n";
							
							$pTabRen .= "<select id=\"dlg_{$aCol['referencia']}_{$pModulo}_##indice##\" name=\"{$aCol['referencia']}_##indice##\" pMaxHeight=\"$MaxHeight\"  pvalor=\"##{$aCol['referencia']}##\" pclass=\"$class\"  width=\"$width\" ><option></option></select>";
							
							
							$pSelectTabla .= "llena_select(xml,'$pModulo','{$aCol['referencia']}','{$aCol['tagOpciones']}');//,'$MaxHeight','$class');\n";
						}
						
						if($aCol['tipo']=='radio'){
							$flagCheckboxradio = 1;
							$name_value = explode('_',$aCol['referencia']);
							$name = isset($name_value[0]) ? $name_value[0] : '';
							$value = isset($name_value[1]) ? $name_value[1] : '';					
							$pTabRen .= "<label for=\"dlg_{$aCol['referencia']}_{$pModulo}_##indice##\" style=\"$style\">{$aCol['label']}<input class=\"$class\"  id=\"dlg_{$aCol['referencia']}_{$pModulo}_##indice##\" type=\"radio\" name=\"{$name}_##indice##\" value=\"$value\" $atributos /></label>";
							$pCheckBoxTabla .= "$('#dlg_{$name}_'+($(this).find(\"{$name}\").text())+'_{$pModulo}_'+indice).prop(\"checked\",true);\n";
						}
						
						
						if($aCol['tipo']=='checkbox'){
							$flagCheckboxradio = 1;
							$name_value = explode('_',$aCol['referencia']);
							$name = isset($name_value[0]) ? $name_value[0] : '';
							$value = isset($name_value[1]) ? $name_value[1] : '';					
							$pTabRen .= "<label for=\"dlg_{$name}_{$pModulo}_##indice##\" style=\"$style\">{$aCol['label']}<input class=\"$class\"  id=\"dlg_{$name}_{$pModulo}_##indice##\" type=\"checkbox\" name=\"{$name}_##indice##\"   /></label>";
							$pCheckBoxTabla .= "$('#dlg_{$name}_{$pModulo}_'+indice).prop(\"checked\",$(this).find(\"{$name}\").text()=='{$value}');\n";
						}
								
						
						
						
					};//objetos por columna
						$pTabRen .= "</td>";
					};//columnas
					$pTabRen .= '</tr>';
					
					
$pDlgTCR .= <<<EOD

	$('#dlg_{$objeto['referencia']}_$pModulo tbody').html('');
	
	
	var regdef = '$pTabRen';	
	var indice = 1;
	$(xml).find('{$objeto['tagRegistro']}').each(function(){
		var cad = regdef;
		cad  = cad.replace(/##indice##/g,indice);
		
		$pCamposTabla
		
		
		$('#dlg_{$objeto['referencia']}_$pModulo tbody').append(cad);
		$('#fdlg_$pModulo input:checkbox,#fdlg_$pModulo input:radio').checkboxradio();
		$pCheckBoxTabla
	
		
		indice = indice + 1;
		
	
	});
		$pSelectTabla

	actualizaTotales_$pModulo = function(xml){
		
		$("Totales",xml).each(function(){
			
			$pasaTotales
		});
	};
	actualizaTotales_$pModulo(xml);
	
	checaSoloLectura('$pModulo');
	
	aplicaMask();
	aplicaCompleta();

	
\n	
EOD;




				}//if table
				
				
				if($objeto['tipo']=='select'){
							
					$pDlgRenglones .= "<select id=\"dlg_{$objeto['referencia']}_$pModulo\" name=\"{$objeto['referencia']}\" style=\"$style\"  pvalor=\"##{$objeto['referencia']}##\" pMaxHeight=\"{$objeto['max-height']}\"  pclass=\"$class\"  width=\"$width\" ><option></option></select>\n";
							
					$pDlgCR .= "$(\"#dlg_{$objeto['referencia']}_$pModulo\").attr('pvalor',$(xml).find(\"{$objeto['referencia']}\").text());\n";
					
							$pDlgCR .= "llena_select(xml,'$pModulo','{$objeto['referencia']}','{$objeto['tagOpciones']}');//,'{$objeto['max-height']}','$class');\n";
/*							
							
					$pSelectMaxHeight = isset($objeto['max-height']) ? "$('#dlg_{$objeto['referencia']}_{$pModulo}-menu').css(\"max-height\",\"{$objeto['max-height']}\");" : '';
					$pDlgRenglones .= "<select id=\"dlg_{$objeto['referencia']}_$pModulo\" name=\"{$objeto['referencia']}\" style=\"$style\"><option></option></select>\n";
$pDlgCR .= <<<EOD
	var pvalor = $('#dlg_accion_$pModulo').val()=='agregar' ? $('#dlg_{$objeto['referencia']}_$pModulo').val() : $(xml).find('{$objeto['referencia']}').text();
	
	$('#dlg_{$objeto['referencia']}_$pModulo').find('option').remove().end();
	$(xml).find('{$objeto['tagOpciones']}').each(function(){
		valor 	= $(this).find('valor').text();
		texto	= $(this).find('texto').text();
		
		if(valor==pvalor){
			$('#dlg_{$objeto['referencia']}_$pModulo').append($('<option></option>').attr('value', valor).attr('selected','selected').text(texto));
		}else{
			$('#dlg_{$objeto['referencia']}_$pModulo').append($('<option></option>').attr('value', valor ).text(texto));
		}
		
	});
	
	$('#dlg_{$objeto['referencia']}_$pModulo').selectmenu();
	$('#dlg_{$objeto['referencia']}_$pModulo').selectmenu("refresh");
	$pSelectMaxHeight
	$('#dlg_{$objeto['referencia']}_{$pModulo}-button').addClass("$class");
\n	
EOD;
*/
				}
				if($objeto['tipo']=='radio'){
					$flagCheckboxradio = 1;
					$name_value = explode('_',$objeto['referencia']);
					$name = isset($name_value[0]) ? $name_value[0] : '';
					$value = isset($name_value[1]) ? $name_value[1] : '';					
					$pDlgRenglones .= "<label for=\"dlg_{$objeto['referencia']}_$pModulo\" style=\"$style\">{$objeto['label']}<input class=\"$class\"  id=\"dlg_{$objeto['referencia']}_$pModulo\" type=\"radio\" name=\"$name\" value=\"$value\"></label>\n";
					$pDlgCR .= "$('#dlg_{$name}_'+($(xml).find(\"{$name}\").text())+'_$pModulo').prop(\"checked\",true);\n";
				}
				if($objeto['tipo']=='checkbox'){
					$flagCheckboxradio = 1;
					$name_value = explode('_',$objeto['referencia']);
					$name = isset($name_value[0]) ? $name_value[0] : '';
					$value = isset($name_value[1]) ? $name_value[1] : '';					
					$pDlgRenglones .= "<label for=\"dlg_{$name}_$pModulo\" style=\"$style\">{$objeto['label']}<input class=\"$class\"  id=\"dlg_{$name}_$pModulo\" type=\"checkbox\" name=\"{$name}\"></label>\n";
					$pDlgCR .= "$(\"#dlg_{$name}_$pModulo\").prop(\"checked\",$(xml).find(\"{$name}\").text()=='{$value}');\n";
				}
				if($objeto['tipo']=='botonlista'){				
					//$pDlgRenglones .= "<button onclick=\"fcomun_{$objeto['referencia_modulo']} = 'bl_{$objeto['referencia']}' ; $('#dlg_{$objeto['referencia_modulo']}').dialog('open');\" id=\"bl_{$objeto['referencia']}\" class=\"{$objeto['class']}\"  style=\"{$objeto['style']}\"><i class=\"fa fa-ellipsis-h\"></i></button>\n";
					$pDlgRenglones .= "<button onclick=\"fcomun_{$objeto['referencia_modulo']} = 'bl_{$objeto['referencia']}' ; $('#dlg_{$objeto['referencia_modulo']}').dialog('open');\" id=\"bl_{$objeto['referencia']}\" $atributos><i class=\"fa fa-ellipsis-h\"></i></button>\n";
					$pParam = '';
					foreach($objeto['CamposReceptores'] as $param){
						$pParam .= "\n$(\"#dlg_{$param}_$pModulo\").val($param);\n";
					}
					$pFuncionesBotonLista .= "function bl_{$objeto['referencia']}(".implode(',',$objeto['CamposReceptores']).")";
					$pFuncionesBotonLista .="{ $pParam \n $('#dlg_{$objeto['referencia_modulo']}').dialog('close');\n } \n";
				}
				

			}
			$pDlgRenglones .= "</td>\n";
		}
		$pDlgRenglones .= "</tr>\n";
	}
	
	
	if($flagCheckboxradio ==1){
		$pDlgCR = "$('#fdlg_$pModulo input:checkbox,#fdlg_$pModulo input:radio').checkboxradio();\n $pDlgCR";
		$pDlgCR .= "$('#fdlg_$pModulo input:checkbox,#fdlg_$pModulo input:radio').checkboxradio('refresh');";
	}
	
	
	
	//Checar si se van a visualizar los Filtros...
	if ($cadTVF == '') {
		$cadTDF = <<<TDF
<table id="table-default-filtros-$pModulo" style="visibility:hidden;display:none;">
    <tr>
		<td>
			<select name="filtro_oplogico[]" style="width:80px;">
				<option value="and">&nbsp;Y&nbsp;</option>
				<option value="or">&nbsp;O&nbsp;</option>
			</select>
		</td>
		<td>
			<select name="filtro_campo[]" style="width:150px;">
				$pOpcionesFiltroCampos
			</select>
		</td>
		<td>
			<select name="filtro_opcomparacion[]" style="width:150px;">
				<option value="LIKE">Que Contenga</option>
				<option value="=">Igual a</option>
				<option value=">">Mayor que</option>
				<option value=">=">Mayor o igual que</option>
				<option value="<">Menor que</option>
				<option value="<=">Menor o igual que</option>
				<option value="!=">Diferente a</option>
			</select>
		</td>
		<td><input type="text" value="" name="filtro_valor[]" style="width:150px;"/></td>
		<td>
			<select name="filtro_ordenable[]" style="width:80px;">
				<option value="">&nbsp;</option>
				<option value="desc">Desendente</option>
				<option value="asc">Ascendente</option>
			</select>
		</td>
		<td><button type="button" onclick="eliminar_registro_filtros('$pModulo',$(this))"><i class="fa fa-minus"></i></button></td>
	</tr>
</table>

TDF;
	
		$cadTVF = <<<TVF
<table cellpadding="2" cellspacing="0" border="0" class="ui-widget ui-widget-content">
	<thead>
		<tr class="ui-widget-header ">
			<th colspan="2" onclick="$('#tbody-filtros-$pModulo').toggle()">Filtros</th>
		</tr>
	</thead>
	<tbody id="tbody-filtros-$pModulo">
		<tr>
			<td colspan="2">
			<table id="table-filtros-$pModulo" cellpadding="2" cellspacing="0" border="0" class="table  table-inverse ui-widget ui-widget-content table-responsive">
				<thead>
					<tr class="ui-widget-header ">
						<th>Operador</th>
						<th>Campo</th>
						<th>Condición</th>
						<th>Valor</th>
						<th>Orden</th>
						<th><button type="button" onclick="agregar_registro_filtros('$pModulo')"><i class="fa fa-plus"></i></button></th>
					</tr>
				</thead>
				<tbody class="sorteable"></tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
				<span>Registros a Mostrar: </span>
<select name="limite" id="{$pModulo}_limite" onchange="buscar_inicio('$pModulo')">
					$pNumeroRegistros
				</select>
			</td>
			<td align="right"><button onclick="buscar_inicio('$pModulo')">$pContBtnBuscar</button></td>
			
		</tr>
	</tbody>
</table>       
		
TVF;

		$cadJSF = "agregar_registro_filtros('$pModulo');\n";
		
	}
	
/*

<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-$pModulo" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##">$pColumnasValor<td><!--seguridad-{$pModulo}-cambiar--><button type="button" id="btn1_{$pModulo}_##indice##" class="seguridad seg_alumnos-cambiar" onclick="consultar_registro('##id##','cambiar','$pModulo')">Cambiar</button><!--/seguridad--></td><td><!--seguridad-{$pModulo}-eliminar--><button type="button" id="btn2_{$pModulo}_##indice##"  class="seguridad seg_alumnos-eliminar" onclick="consultar_registro('##id##','eliminar','$pModulo')" tabindex="$pTabEliminar">Eliminar</button><!--/seguridad--></td></tr>
</table>

		<!--seguridad-{$pModulo}-agregar--><button class="seguridad seg_alumnos-agregar" onclick="consultar_registro('0','agregar','$pModulo')">Agregar</button><!--/seguridad-->
		<button onclick="buscar_plus('$pModulo','anterior')"> &lt;&lt; </button>
		<button onclick="buscar_plus('$pModulo','siguiente')"> &gt;&gt;</button>
ui-icon-check
*/	
	
	//Armar la cadena resultante de la plantilla...
	$cadres = <<<PLANTILLA1

<!--seguridad-{$pModulo}-acceso--><!--/seguridad-->
<div id="modulo-$pModulo">

$cadTDF

 
<form name="fb_$pModulo" id="fb_$pModulo" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">

$cadTVF

<input type="hidden" name="modulo" value="$pModulo"/>
<input type="hidden" name="pagina" value="0"  id="{$pModulo}_pagina"/>

</form>

<!-- Agregar las columnas(etiquetas) de cada campo a visualizar -->
<div id="rb_$pModulo" style="width:100%; margin-top:30px;">
	<table   id="table-$pModulo" cellpadding="5" cellspacing="0" border="0"  class="table table-responsive ui-widget ui-widget-content ">
		<thead><tr class="ui-widget-header ">$pColumnasEtiquetas<td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
		$tempBtnAgregar
		<button onclick="buscar_plus('$pModulo','anterior')"> $pContBtnAnterior </button>
		<button onclick="buscar_plus('$pModulo','siguiente')"> $pContBtnSiguiente</button>
		<div id="mensajes_$pModulo"></div>
	</div>
</div><!--termina rb-->          


<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-$pModulo" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##">$pColumnasValor</tr>
</table>



<div id="dlg_$pModulo" title="$pDlgTitulo">
<form id="fdlg_$pModulo" name="fdlg_$pModulo" method="post" onsubmit="return false;">

<table cellpadding="5" cellspacing="5">

$pDlgRenglones


<tr>
	<td colspan="2"><div id="dlg_mensaje_$pModulo"></div></td>
</tr>
</table>

<input type="hidden" id="dlg_accion_$pModulo" name="accion" value="consultar" />
<input type="hidden" id="dlg_SeguirAgregando_$pModulo" name="dlg_SeguirAgregando_$pModulo" value="$pSeguirAgregando"/>
<input type="hidden" id="dlg_guardaCache_$pModulo" name="guardaCache" value="0" />
</form>

$subPlantilla

</div><!--termina dlg-->    



</div><!--termina modulo-$pModulo-->

<script type="text/javascript">


var objdlg_$pModulo;
var actualizaTotales_$pModulo = function(){};

	$('#dlg_$pModulo').dialog({
		autoOpen: false,
		width: $pDlgWidth,
		$pDlgHeight 
		modal: true,
		open: function( event, ui ) {
			$('#dlg_guardaCache_$pModulo').val('0');
			
			$pDlgEventoAlAbrir
			
			$funcionSubPlantilla
		},		
		buttons: [
    {
      text: "Ok",
	  class : "btnOK",
      icons: { primary: "fa fa-plus" },
      click: function() {
		 //console.log("boton ok");
		 
		if($("#dlg_accion_$pModulo").val()=="eliminar"){
			objdlg_$pModulo = $(this);
			$.confirm('¿Estas seguro de eliminar los datos?','Confirma!!!',function (){ABC_global(objdlg_$pModulo,'$pModulo'); });
		}else{
			ABC_global($(this),'$pModulo');
		}
		  
      }
 
    },
    {
      text: "Cancelar",
	  class : "btnCancel",
      icons: { primary: "ui-icon-close" },
      click: function() {
        $( this ).dialog( "close" );
      }
 
    }
	
  ],
	close: function( event, ui ) {
		buscar('$pModulo');
	},
	
   create:function () {
        $(this).closest(".ui-dialog")
            .find(".btnOK")
            .html('<i class="fa fa-check"></i>');
        $(this).closest(".ui-dialog")
            .find(".btnCancel")
            .html('<i class="fa fa-times"></i>');
    }	
	
	});
	
	
		
	
	

function llena_tabla_$pModulo(cad_default,xml){
	var cad = cad_default;
	$pColumnasCR
	return cad;
};

function llena_registro_$pModulo(xml){
	$pDlgTCR
	$pDlgCR
};

$pFuncionesBotonLista


buscar_inicio('$pModulo');
$cadJSF

</script>

PLANTILLA1;
return $cadres;
};
	


?>