<div id="modulo-accesos">

<table id="table-default-filtros-accesos" style="visibility:hidden;display:none;">
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
				<option value="a.id">id Acceso</option>
				<option value="p.nombre">Perfil</option>
				<option value="a.permisos">Permisos</option>
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
		<td><button type="button" onclick="eliminar_registro_filtros('accesos',$(this))"><span class="ui-icon ui-icon-circle-minus"></span></button></td>
	</tr>
</table>



<form name="fb_accesos" id="fb_accesos" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">

<table cellpadding="2" cellspacing="0" border="0" class="ui-widget ui-widget-content">
	<thead>
		<tr class="ui-widget-header ">
			<th colspan="2" onclick="$('#tbody-filtros-accesos').toggle()">Filtros</th>
		</tr>
	</thead>
	<tbody id="tbody-filtros-accesos">
		<tr>
			<td colspan="2">
			<table id="table-filtros-accesos" cellpadding="2" cellspacing="0" border="0" class="table  table-inverse ui-widget ui-widget-content table-responsive">
				<thead>
					<tr class="ui-widget-header ">
						<th>Operador</th>
						<th>Campo</th>
						<th>Condición</th>
						<th>Valor</th>
						<th>Orden</th>
						<th><button type="button" onclick="agregar_registro_filtros('accesos')"><span class="ui-icon ui-icon-circle-plus"></span></button></th>
					</tr>
				</thead>
				<tbody class="sorteable"></tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
				<span>Registros a Mostrar: </span>
				<select name="limite" id="accesos_limite" onchange="buscar_inicio('accesos')">
					<option value="3">3</option>
					<option value="5">5</option>
					<option value="8">8</option>
					<option value="10">10</option>
					<option value="13">13</option>
					<option value="15">15</option>
				</select>
			</td>
			<td align="right"><button onclick="buscar_inicio('accesos')">Buscar</button></td>
			
		</tr>
	</tbody>
</table>       

<input type="hidden" name="modulo" value="accesos"/>
<input type="hidden" name="pagina" value="0"  id="accesos_pagina"/>

</form>

<!-- Agregar las columnas(etiquetas) de cada campo a visualizar -->
<div id="rb_accesos" style="width:100%; margin-top:30px;">
	<table   id="table-accesos" cellpadding="5" cellspacing="0" border="0"  class="table table-responsive ui-widget ui-widget-content ">
		<thead><tr class="ui-widget-header "><td>id_accesos</td><td>Perfil</td><td>Permisos</td><td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
		<button class="seguridad seg_accesos-agregar" onclick="consultar_registro('0','agregar','accesos')">Agregar acceso</button>
		<button onclick="buscar_plus('accesos','anterior')"> &lt;&lt; </button>
		<button onclick="buscar_plus('accesos','siguiente')"> &gt;&gt;</button>
	</div>
</div><!--termina rb-->          


<!-- Agregar los campos o alias a visualizar debe coincidir con la funcion llena_tabla_* -->
<table id="table-default-accesos" style="visibility:hidden;display:none;">
    <tr class="##regSeleccion##"><td>##id_accesos##</td><td>##perfil##</td><td>##permisos##</td><td><button type="button" class="seguridad seg_accesos-cambiar" onclick="consultar_registro('##id_accesos##','cambiar','accesos')">Cambiar</button></td><td><button type="button" class="seguridad seg_accesos-eliminar" onclick="consultar_registro('##id_accesos##','eliminar','accesos')" tabindex="-1">Eliminar</button></td></tr>
</table>



<div id="dlg_accesos" title="accesos">
<form id="fdlg_accesos" name="fdlg_accesos" method="post" onsubmit="return false;">
<table cellpadding="5" cellspacing="5">
<tr id="row_id_accesos" style="visibility:visible">
	<td>id_accesos</td>
    <td><input class="inputs" id="dlg_id_accesos" name="id_accesos" value="0" style="width:60px;" readonly /></td>
</tr>
<!--
<tr>
	<td>AppId</td>
    <td><input class="inputs" id="dlg_appid_accesos" name="appid" value="<?php echo $app['appid']; ?>" style="width:400px;" readonly /></td>
</tr>
-->
<!--
<tr style="display:none;">
	<td>AppId</td>
    <td><span><?php echo $app['appid']; ?></span></td>
</tr>
-->
<tr>
	<td>Perfil</td>
    <td>
		<select id="dlg_perfiles_id_accesos" name="perfiles_id"><option></option></select>
		<label for="btnpermisos" style="margin-left:10px;">Todos los Permisos Filtrados<input type="checkbox" id="btnpermisos" onchange="poncheck_accesos(this)" /></label>
	</td>
</tr>


<tr>

	
    <td colspan="2">
		<div id="btns_disponibles">
			<?php
				echo '<div style="height:400px; width:100%; overflow:scroll; border:1px solid #ddd;">';
				echo '<input type="text" class="inputs" id="dlg_perfiles_filtro" onkeyup="FiltraAccesos()" placeholder="Filtrar Modulos..." title="Escribe un nombre de Modulo..." autocomplete="off"><br>';
				echo '<table id="tableAccesos" border="0" cellpadding="0" cellspacing="0">';
				
				foreach($aBtns as $modulo=>$permisos){
					//print_r(array_unique($permisos));
					echo '<tr>';
					echo '<td><h4 style="margin-right:10px;">'.$modulo.'</h4></td>';
					echo '<td>';
					foreach(array_unique($permisos) as $permiso){ 
						if(substr($permiso,0,strlen($modulo))==$modulo){
							$etiq = str_replace("$modulo-",'',$permiso);
							echo '<label for="dlg_perfiles_'."$permiso".'" style="margin-right:10px;margin-bottom:10px;">'."$etiq".'<input class="inputs"  id="dlg_perfiles_'."$permiso".'" type="checkbox" name="permiso[]" value="'."$permiso".'" ></label>';
						}
					}
					echo '</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';
			?>
		</div>
	</td>
</tr>

<tr>
	<td colspan="2"><div id="dlg_mensaje_accesos"></div></td>
</tr>
</table>
<input type="hidden" id="dlg_accion_accesos" name="accion" value="consultar" />

</form>

</div><!--termina dlg-->    



</div><!--termina modulo-->






















