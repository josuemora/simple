<div id="modulo-perfiles">

<table id="table-default-filtros-perfiles" style="visibility:hidden;display:none;">
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
				<option value="p.id">id perfil</option>
				<option value="p.nombre">Nombre Perfil</option>
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
		<td><button type="button" onclick="eliminar_registro_filtros('perfiles',$(this))"><span class="ui-icon ui-icon-circle-minus"></span></button></td>
	</tr>
</table>



<form name="fb_perfiles" id="fb_perfiles" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">

<table cellpadding="2" cellspacing="0" border="0" class="ui-widget ui-widget-content">
	<thead>
		<tr class="ui-widget-header ">
			<th colspan="2" onclick="$('#tbody-filtros-perfiles').toggle()">Filtros</th>
		</tr>
	</thead>
	<tbody id="tbody-filtros-perfiles">
		<tr>
			<td colspan="2">
			<table id="table-filtros-perfiles" cellpadding="2" cellspacing="0" border="0" class="table  table-inverse ui-widget ui-widget-content table-responsive">
				<thead>
					<tr class="ui-widget-header ">
						<th>Operador</th>
						<th>Campo</th>
						<th>Condición</th>
						<th>Valor</th>
						<th>Orden</th>
						<th><button type="button" onclick="agregar_registro_filtros('perfiles')"><span class="ui-icon ui-icon-circle-plus"></span></button></th>
					</tr>
				</thead>
				<tbody class="sorteable"></tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
				<span>Registros a Mostrar: </span>
				<select name="limite" id="perfiles_limite" onchange="buscar_inicio('perfiles')">
					<option value="3">3</option>
					<option value="5">5</option>
					<option value="8">8</option>
					<option value="10">10</option>
					<option value="13">13</option>
					<option value="15">15</option>
				</select>
			</td>
			<td align="right"><button onclick="buscar_inicio('perfiles')">Buscar</button></td>
			
		</tr>
	</tbody>
</table>       

<input type="hidden" name="modulo" value="perfiles"/>
<input type="hidden" name="pagina" value="0"  id="perfiles_pagina"/>

</form>

<!-- Agregar las columnas(etiquetas) de cada campo a visualizar -->
<div id="rb_perfiles" style="width:100%; margin-top:30px;">
	<table   id="table-perfiles" cellpadding="5" cellspacing="0" border="0"  class="table table-responsive ui-widget ui-widget-content ">
		<thead><tr class="ui-widget-header "><td>id_perfiles</td><td>Nombre Perfil</td><td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
		<button class="seguridad seg_perfiles-agregar" onclick="consultar_registro('0','agregar','perfiles')">Agregar perfil</button>
		<button onclick="buscar_plus('perfiles','anterior')"> &lt;&lt; </button>
		<button onclick="buscar_plus('perfiles','siguiente')"> &gt;&gt;</button>
	</div>
</div><!--termina rb-->          


<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-perfiles" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##"><td>##id_perfiles##</td><td>##nombre##</td><td><button type="button" class="seguridad seg_perfiles-cambiar" onclick="consultar_registro('##id_perfiles##','cambiar','perfiles')">Cambiar</button></td><td><button type="button" class="seguridad seg_perfiles-eliminar" onclick="consultar_registro('##id_perfiles##','eliminar','perfiles')" tabindex="-1">Eliminar</button></td></tr>
</table>



<div id="dlg_perfiles" title="perfiles">
<form id="fdlg_perfiles" name="fdlg_perfiles" method="post" onsubmit="return false;">
<table cellpadding="5" cellspacing="5">
<tr id="row_id_perfiles" style="visibility:visible">
	<td>id_perfiles</td>
    <td><input class="inputs" id="dlg_id_perfiles" name="id_perfiles" value="0" style="width:60px;" readonly /></td>
</tr>
<tr>
	<td>Perfil</td>
	<td><input class="inputs" id="dlg_nombre_perfiles" name="nombre" value="" style="width:400px;"/></td>
</tr>


<tr>
	<td colspan="2"><div id="dlg_mensaje_perfiles"></div></td>
</tr>
</table>
<input type="hidden" id="dlg_accion_perfiles" name="accion" value="consultar" />

</form>

</div><!--termina dlg-->    



</div><!--termina modulo-->






















