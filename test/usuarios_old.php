<div id="cb_usuarios" style="width:100%;" class="tab_usuarios">  
<form name="fb_usuarios" id="fb_usuarios" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">
<table cellpadding="5" cellspacing="0" border="0" class="ui-widget ui-widget-content">
<thead>
	<tr class="ui-widget-header "><th>Filtros</th></tr>
</thead>
<tr>
	<td>id</td>
    <td>Nombre</td>
</tr>
<tr>
	<td><input type="text" value="" id="id_usuarios"     name="id_usuarios"     style="width:40px;" maxlength="5" /></td>
	<td><input type="text" value="" id="nombre" name="nombre" style="width:170px;"/></td>
    <td rowspan="2"><button onclick="buscar_inicio('usuarios')">Buscar</button></td>
</tr>
</table>       
<input type="hidden" name="modulo" value="usuarios"/>
<input type="hidden" name="limite" value="5" id="usuarios_limite"/>
<input type="hidden" name="pagina" value="0"  id="usuarios_pagina"/>
</form>
<div id="rb_usuarios" style="width:100%; margin-top:30px;">
	<table id="table-usuarios" cellpadding="4" cellspacing="4" border="0"  class="ui-widget ui-widget-content">
		<thead><tr class="ui-widget-header "><td>id_usuarios</td><td>Nombre</td><td>Accesos</td><td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones"><button onclick="agregar_usuario()">Agregar usuario</button><button onclick="buscar_plus('usuarios','anterior')"> &lt;&lt; </button><button onclick="buscar_plus('usuarios','siguiente')"> &gt;&gt;</button></div>
</div><!--termina rb-->          



<table id="table-default-usuarios" style="visibility:hidden">
    <tr><td>##id_usuarios##</td><td>##nombre##</td><td><div style="width:500px;height:50px;overflow:auto;">##botones##</div></td><td><button onclick="cambiar_eliminar_usuario('##id_usuarios##','cambiar')">Cambiar</button></td><td><button onclick="cambiar_eliminar_usuario('##id_usuarios##','eliminar')">Eliminar</button></td></tr>
</table>



<div id="dlg_usuarios" title="usuarios">
<form id="fdlg_usuarios" name="fdlg_usuarios" method="post" onsubmit="return false;">
<table cellpadding="5" cellspacing="5">
<tr id="row_id_usuarios" style="visibility:visible">
	<td>id_usuarios</td>
    <td><input id="dlg_id_usuarios" name="id_usuarios" value="" style="width:60px;" readonly="readonly" /></td>
</tr>
<tr>
	<td>Nombre</td>
    <td><input id="dlg_nombre" name="nombre" value="" style="width:400px;"/></td>
</tr>
<tr>
	<td>Password</td>
    <td><input id="dlg_password" name="password" type="password" value="" style="width:400px;"/></td>
</tr>

<tr>
	<td>Botones disponibles<br><br><input type="checkbox" id="btnacc" onchange="poncheck(this)" />SELECCIONA TODOS</td>

    <td><div id="botones_disponibles"></div></td>
</tr>


<tr>
	<td colspan="2"><div id="dlg_mensaje_usuarios"></div></td>
</tr>
</table>
<input type="hidden" id="dlg_accion_usuarios" name="accion" value="" />
    <td><input type="hidden" id="dlg_botones" name="botones" value="" style="width:400px;" readonly="readonly"/></td>
</form>
</div><!--termina dlg-->    


</div><!--termina cb-->
