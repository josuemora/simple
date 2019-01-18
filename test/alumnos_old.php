<!--seguridad-acceso--><!--/seguridad-->
<div id="modulo-alumnos">

<table id="table-default-filtros-alumnos" style="visibility:hidden;display:none;">
    <tr>
		<td>
			<select name="filtro_oplogico[]" style="width:80px;">
				<option value="and">&nbsp;Y&nbsp;</option>
				<option value="or">&nbsp;O&nbsp;</option>
			</select>
		</td>
		<td>
			<select name="filtro_campo[]" style="width:150px;">
				<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->
				<option value="a.id">id Alumno</option>
				<option value="a.nombre">Nombre</option>
				<option value="a.paterno">Paterno</option>
				<option value="a.materno">Materno</option>
				<option value="g.grado">Grado</option>
				<option value="g.salon">Salon</option>
				<option value="g.turno">Turno</option>
				<option value="a.sexo">Sexo</option>
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
		<td><button type="button" onclick="eliminar_registro_filtros('alumnos',$(this))"><span class="ui-icon ui-icon-circle-minus"></span></button></td>
	</tr>
</table>



<!-- div id="cb_alumnos" style="width:100%;" class="tab_alumnos" -->  
<form name="fb_alumnos" id="fb_alumnos" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">

<table cellpadding="2" cellspacing="0" border="0" class="ui-widget ui-widget-content">
	<thead>
		<tr class="ui-widget-header ">
			<th colspan="2" onclick="$('#tbody-filtros').toggle()">Filtros</th>
		</tr>
	</thead>
	<tbody id="tbody-filtros">
		<tr>
			<td colspan="2">
			<table id="table-filtros-alumnos" cellpadding="2" cellspacing="0" border="0" class="table  table-inverse ui-widget ui-widget-content table-responsive">
				<thead>
					<tr class="ui-widget-header ">
						<th>Operador</th>
						<th>Campo</th>
						<th>Condición</th>
						<th>Valor</th>
						<th>Orden</th>
						<th><button type="button" onclick="agregar_registro_filtros('alumnos')"><span class="ui-icon ui-icon-circle-plus"></span></button></th>
					</tr>
				</thead>
				<tbody class="sorteable"></tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
				<span>Registros a Mostrar: </span>
				<select name="limite" id="alumnos_limite" onchange="buscar_inicio('alumnos')">
					<option value="3">3</option>
					<option value="5">5</option>
					<option value="8">8</option>
					<option value="10">10</option>
					<option value="13">13</option>
					<option value="15">15</option>
				</select>
			</td>
			<td align="right"><button onclick="buscar_inicio('alumnos')">Buscar</button></td>
			
		</tr>
	</tbody>
</table>       

<input type="hidden" name="modulo" value="alumnos"/>
<input type="hidden" name="pagina" value="0"  id="alumnos_pagina"/>

</form>

<!-- Agregar las columnas(etiquetas) de cada campo a visualizar -->
<div id="rb_alumnos" style="width:100%; margin-top:30px;">
	<table   id="table-alumnos" cellpadding="5" cellspacing="0" border="0"  class="table table-responsive ui-widget ui-widget-content ">
		<thead><tr class="ui-widget-header "><td>id_alumnos</td><td>Nombre</td><td>Paterno</td><td>Materno</td><td>Grupo</td><td>Sexo</td><td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
		<!--seguridad-agregar--><button class="seguridad seg_alumnos-agregar" onclick="consultar_registro('0','agregar','alumnos')">Agregar alumno</button><!--/seguridad-->
		<button onclick="buscar_plus('alumnos','anterior')"> &lt;&lt; </button>
		<button onclick="buscar_plus('alumnos','siguiente')"> &gt;&gt;</button>
	</div>
</div><!--termina rb-->          


<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-alumnos" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##"><td>##id_alumnos##</td><td>##nombre##</td><td>##paterno##</td><td>##materno##</td><td>##grupo##</td><td>##sexo##</td><td><!--seguridad-cambiar--><button type="button" class="seguridad seg_alumnos-cambiar" onclick="consultar_registro('##id_alumnos##','cambiar','alumnos')">Cambiar</button><!--/seguridad--></td><td><!--seguridad-eliminar--><button type="button" class="seguridad seg_alumnos-eliminar" onclick="consultar_registro('##id_alumnos##','eliminar','alumnos')" tabindex="-1">Eliminar</button><!--/seguridad--></td></tr>
</table>



<div id="dlg_alumnos" title="alumnos">
<form id="fdlg_alumnos" name="fdlg_alumnos" method="post" onsubmit="return false;">
<table cellpadding="5" cellspacing="5">
<tr id="row_id_alumnos" style="visibility:visible">
	<td>id_alumnos</td>
    <td><input class="inputs" id="dlg_id_alumnos" name="id_alumnos" value="0" style="width:60px;" readonly /></td>
</tr>
<tr>
	<td>Nombre</td>
    <td><input class="inputs" id="dlg_nombre_alumnos" name="nombre" value="" style="width:400px;"/></td>
</tr>

<tr>
	<td>Paterno</td>
    <td><input class="inputs" id="dlg_paterno_alumnos" name="paterno" value="" style="width:400px;"/></td>
</tr>
<tr>
	<td>Materno</td>
    <td><input class="inputs" id="dlg_materno_alumnos" name="materno" value="" style="width:400px;"/></td>
</tr>

<!--
<tr>
	<td>Grupo</td>
    <td><select class="inputs" id="dlg_grupos_id_alumnos" name="grupos_id"></select></td>
</tr>
<tr>
	<td>sexo</td>
    <td>
		<span style="padding-right:10px;"><input class="inputs"  id="dlg_sexo_m_alumnos" type="radio" name="sexo" value="m"> Masculino</span>
		<span style="padding-right:10px;"><input class="inputs"  id="dlg_sexo_f_alumnos" type="radio" name="sexo" value="f"> Femenino</span>
	</td>
</tr>
<tr>
	<td>otros...</td>
    <td>
		<span style="padding-right:10px;"><input class="inputs"  id="dlg_usalentes_alumnos" type="checkbox" name="usalentes"> Usa Lentes?</span>
		<span style="padding-right:10px;"><input class="inputs"  id="dlg_enfermedad_alumnos" type="checkbox" name="enfermedad"> Tiene Alguna Enfermedad?</span>
		<span style="padding-right:10px;"><input class="inputs"  id="dlg_capacidaddiferente_alumnos" type="checkbox" name="capacidaddiferente"> Capacidad Diferente?</span>
	</td>
</tr>
-->
<tr>
	<td>Grupo</td>
    <td><select id="dlg_grupos_id_alumnos" name="grupos_id"><option></option></select></td>
</tr>
<tr>
	<td>sexo</td>
    <td>
		<label for="dlg_sexo_m_alumnos" style="margin-right:10px;margin-bottom:10px;">Masculino<input class="inputs"  id="dlg_sexo_m_alumnos" type="radio" name="sexo" value="m"></label>
		<label for="dlg_sexo_f_alumnos" style="margin-right:10px;margin-bottom:10px;">Femenino<input class="inputs"  id="dlg_sexo_f_alumnos" type="radio" name="sexo" value="f"></label>
	</td>
</tr>
<tr>
	<td>otros</td>
    <td>
		<label for="dlg_usalentes_alumnos" style="margin-right:10px;margin-bottom:10px;">Usa Lentes?<input class="inputs"  id="dlg_usalentes_alumnos" type="checkbox" name="usalentes"></label>
		<label for="dlg_enfermedad_alumnos" style="margin-right:10px;margin-bottom:10px;">Tiene Alguna Enfermedad?<input class="inputs"  id="dlg_enfermedad_alumnos" type="checkbox" name="enfermedad"></label>
		<label for="dlg_capacidaddiferente_alumnos" style="margin-right:10px;margin-bottom:10px;">Capacidad Diferente?<input class="inputs"  id="dlg_capacidaddiferente_alumnos" type="checkbox" name="capacidaddiferente"></label>
	</td>
</tr>

<tr>
	<td colspan="2"><div id="dlg_mensaje_alumnos"></div></td>
</tr>
</table>
<input type="hidden" id="dlg_accion_alumnos" name="accion" value="consultar" />

    <!-- td><input type="hidden" id="dlg_botones_alumnos" name="botones" value="" style="width:400px;" readonly /></td -->
</form>

</div><!--termina dlg-->    


<!-- /div --><!--termina cb-->


</div><!--termina modulo-alumnos-->



<!--

////////////////////////////////////////////////////////////////////////////////////////////////

-->
<button onclick="$('#dlg_lalumnos').dialog('open');">Listado de Alumnos</button>

<div id="dlg_lalumnos" title="Listado de alumnos">
<div id="modulo-lalumnos">
<form name="fb_lalumnos" id="fb_lalumnos" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">

<input type="hidden" name="filtro_oplogico[]" value="or"/>
<input type="hidden" name="filtro_campo[]" value="a.id"/>
<input type="hidden" name="filtro_opcomparacion[]" value="LIKE"/>
<input type="hidden" name="filtro_valor[]" value=""/>
<input type="hidden" name="filtro_ordenable[]" value="desc"/>

<input type="hidden" name="filtro_oplogico[]" value="or"/>
<input type="hidden" name="filtro_campo[]" value="a.nombre"/>
<input type="hidden" name="filtro_opcomparacion[]" value="LIKE"/>
<input type="hidden" name="filtro_valor[]" value=""/>
<input type="hidden" name="filtro_ordenable[]" value=""/>

<input type="hidden" name="filtro_oplogico[]" value="or"/>
<input type="hidden" name="filtro_campo[]" value="a.paterno"/>
<input type="hidden" name="filtro_opcomparacion[]" value="LIKE"/>
<input type="hidden" name="filtro_valor[]" value=""/>
<input type="hidden" name="filtro_ordenable[]" value=""/>

<input type="hidden" name="filtro_oplogico[]" value="or"/>
<input type="hidden" name="filtro_campo[]" value="a.materno"/>
<input type="hidden" name="filtro_opcomparacion[]" value="LIKE"/>
<input type="hidden" name="filtro_valor[]" value=""/>
<input type="hidden" name="filtro_ordenable[]" value=""/>

<input type="hidden" name="limite" value="3"  id="lalumnos_limite"/>
<input type="hidden" name="modulo" value="lalumnos"/>
<input type="hidden" name="pagina" value="0"  id="lalumnos_pagina"/>



<input type="text" value="" id="filtro_valor_lalumnos" name="filtro_valor_lalumnos" style="width:150px;"/>
<button onclick="buscar_inicio('lalumnos')">Buscar</button>
</form>

<!-- Agregar las columnas(etiquetas) de cada campo a visualizar -->
<div id="rb_lalumnos" style="width:100%; margin-top:30px;">
	<table   id="table-lalumnos" cellpadding="5" cellspacing="0" border="0"  class="table table-responsive ui-widget ui-widget-content ">
		<thead><tr class="ui-widget-header "><td>id_alumnos</td><td>Nombre</td><td>Paterno</td><td>Materno</td><td>Grupo</td><td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
		<button onclick="buscar_plus('lalumnos','anterior')"> &lt;&lt; </button>
		<button onclick="buscar_plus('lalumnos','siguiente')"> &gt;&gt;</button>
	</div>
</div><!--termina rb-->          


<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-lalumnos" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##"><td>##id_alumnos##</td><td>##nombre##</td><td>##paterno##</td><td>##materno##</td><td>##grupo##</td><td><button type="button" class="" onclick="seleccionar_registro('##id_alumnos##','seleccionar','lalumnos')">Seleccionar</button></td></tr>
</table>

</div><!--termina modulo-lalumnos-->
</div><!--termina dlg-lalumnos-->

