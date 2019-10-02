<div id="modulo-usuarios">

<table id="table-default-filtros-usuarios" style="visibility:hidden;display:none;">
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
				<option value="u.id">id Usuario</option>
				<option value="u.nombre">Nombre</option>
				<option value="p.nombre">Perfil</option>
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
		<td><button type="button" onclick="eliminar_registro_filtros('usuarios',$(this))"><span class="ui-icon ui-icon-circle-minus"></span></button></td>
	</tr>
</table>



<form name="fb_usuarios" id="fb_usuarios" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">

<table cellpadding="2" cellspacing="0" border="0" class="ui-widget ui-widget-content">
	<thead>
		<tr class="ui-widget-header ">
			<th colspan="2" onclick="$('#tbody-filtros-usuarios').toggle()">Filtros</th>
		</tr>
	</thead>
	<tbody id="tbody-filtros-usuarios">
		<tr>
			<td colspan="2">
			<table id="table-filtros-usuarios" cellpadding="2" cellspacing="0" border="0" class="table  table-inverse ui-widget ui-widget-content table-responsive">
				<thead>
					<tr class="ui-widget-header ">
						<th>Operador</th>
						<th>Campo</th>
						<th>Condición</th>
						<th>Valor</th>
						<th>Orden</th>
						<th><button type="button" onclick="agregar_registro_filtros('usuarios')"><span class="ui-icon ui-icon-circle-plus"></span></button></th>
					</tr>
				</thead>
				<tbody class="sorteable"></tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
				<span>Registros a Mostrar: </span>
				<select name="limite" id="usuarios_limite" onchange="buscar_inicio('usuarios')">
					<option value="3">3</option>
					<option value="5">5</option>
					<option value="8">8</option>
					<option value="10">10</option>
					<option value="13">13</option>
					<option value="15">15</option>
				</select>
			</td>
			<td align="right"><button onclick="buscar_inicio('usuarios')">Buscar</button></td>
			
		</tr>
	</tbody>
</table>       

<input type="hidden" name="modulo" value="usuarios"/>
<input type="hidden" name="pagina" value="0"  id="usuarios_pagina"/>

</form>

<!-- Agregar las columnas(etiquetas) de cada campo a visualizar -->
<div id="rb_usuarios" style="width:100%; margin-top:30px;">
	<table   id="table-usuarios" cellpadding="5" cellspacing="0" border="0"  class="table table-responsive ui-widget ui-widget-content ">
		<thead><tr class="ui-widget-header "><td>id_usuarios</td><td>Nombre</td><td>Perfil</td><td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
		<button class="seguridad seg_usuarios-agregar" onclick="consultar_registro('0','agregar','usuarios')">Agregar Usuario</button>
		<button onclick="buscar_plus('usuarios','anterior')"> &lt;&lt; </button>
		<button onclick="buscar_plus('usuarios','siguiente')"> &gt;&gt;</button>
	</div>
</div><!--termina rb-->          


<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-usuarios" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##"><td>##id_usuarios##</td><td>##nombre##</td><td>##perfil##</td><td><button type="button" class="seguridad seg_usuarios-cambiar" onclick="consultar_registro('##id_usuarios##','cambiar','usuarios')">Cambiar</button></td><td><button type="button" class="seguridad seg_usuarios-eliminar" onclick="consultar_registro('##id_usuarios##','eliminar','usuarios')" tabindex="-1">Eliminar</button></td></tr>
</table>



<div id="dlg_usuarios" title="usuarios">
<form id="fdlg_usuarios" name="fdlg_usuarios" method="post" onsubmit="return false;">
<table cellpadding="5" cellspacing="5">
<tr id="row_id_usuarios" style="visibility:visible">
	<td>id_usuarios</td>
    <td><input class="inputs" id="dlg_id_usuarios" name="id_usuarios" value="0" style="width:60px;" readonly /></td>
</tr>
<tr>
	<td>Nombre</td>
	<td><input class="inputs" id="dlg_nombre_usuarios" name="nombre" value="" style="width:400px;"/></td>
</tr>
<tr>
	<td>Password</td>
	<td><input class="inputs" id="dlg_password_usuarios" name="password" type="password" value="" style="width:400px;"/></td>
</tr>
<tr>
	<td>Perfil</td>
    <td>
		<select id="dlg_perfiles_id_usuarios" name="perfiles_id"><option></option></select>
	</td>
</tr>

<tr>
	<td colspan="2"><div id="dlg_mensaje_usuarios"></div></td>
</tr>
</table>
<input type="hidden" id="dlg_accion_usuarios" name="accion" value="consultar" />
<input type="hidden" id="dlg_SeguirAgregando_usuarios" name="dlg_SeguirAgregando_usuarios" value="1"/>
<input type="hidden" id="dlg_guardaCache_usuarios" name="guardaCache" value="0" />

</form>

</div><!--termina dlg-->    



</div><!--termina modulo-->






















