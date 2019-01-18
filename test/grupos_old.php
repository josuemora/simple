
<!--seguridad-acceso--><!--/seguridad-->
<div id="cb_grupos" style="width:100%;" class="tab_grupos">  
<form name="fb_grupos" id="fb_grupos" onsubmit="return false;" method="post" style="width:100%; margin-top:10px;">
<table cellpadding="5" cellspacing="0" border="0" class="ui-widget ui-widget-content">
<thead>
	<tr class="ui-widget-header "><th>Filtros</th></tr>
</thead>
<tr>
	<td>id</td>
    <td>Grado</td>
    <td>Salon</td>
    <td>Turno</td>
</tr>
<tr>
	<td><input type="text" value="" id="fb_id_grupos_grupos"     name="id_grupos"     style="width:40px;" maxlength="5" /></td>
	<td><input type="text" value="" id="fb_grado_grupos" name="grado" style="width:100px;"/></td>
	<td><input type="text" value="" id="fb_salon_grupos" name="salon" style="width:100px;"/></td>
	<td><input type="text" value="" id="fb_turno_grupos" name="turno" style="width:100px;"/></td>
    <td rowspan="2"><button onclick="buscar_inicio('grupos')">Buscar</button></td>
</tr>
</table>       
<input type="hidden" name="modulo" value="grupos"/>
<input type="hidden" name="limite" value="5" id="grupos_limite"/>
<input type="hidden" name="pagina" value="0"  id="grupos_pagina"/>
</form>
<div id="rb_grupos" style="width:100%; margin-top:30px;">
	<table id="table-grupos" cellpadding="4" cellspacing="4" border="0"  class="ui-widget ui-widget-content">
		<thead><tr class="ui-widget-header "><td>id_grupos</td><td>Grado</td><td>Salon</td><td>Turno</td><td>&nbsp;</td><td>&nbsp;</td></tr></thead>
		<tbody></tbody>
	</table>
	<div class="botones">
	<!--seguridad-agregar--><button class="seguridad seg_grupos-agregar" onclick="agregar_grupo()">Agregar grupo</button><!--/seguridad-->
	<button onclick="buscar_plus('grupos','anterior')"> &lt;&lt; </button>
	<button onclick="buscar_plus('grupos','siguiente')"> &gt;&gt;</button>
	</div>
</div><!--termina rb-->          



<table id="table-default-grupos" style="visibility:hidden">
    <tr class="##regSeleccion##"><td>##id_grupos##</td><td>##grado##</td><td>##salon##</td><td>##turno##</td><td><!--seguridad-cambiar--><button class="seguridad seg_grupos-cambiar" onclick="cambiar_eliminar_grupo('##id_grupos##','cambiar')">Cambiar</button><!--/seguridad--></td><td><!--seguridad-eliminar--><button  class="seguridad seg_grupos-eliminar" onclick="cambiar_eliminar_grupo('##id_grupos##','eliminar')">Eliminar</button><!--/seguridad--></td></tr>
</table>



<div id="dlg_grupos" title="grupos">
<form id="fdlg_grupos" name="fdlg_grupos" method="post" onsubmit="return false;">
<table cellpadding="5" cellspacing="5">
<tr id="row_id_grupos" style="visibility:visible">
	<td>id_grupos</td>
    <td><input class="inputs"  id="dlg_id_grupos" name="id_grupos" value="" style="width:60px;" readonly /></td>
</tr>
<tr>
	<td>Grado</td>
    <td><input class="inputs"  id="dlg_grado_grupos" name="grado" value="" style="width:200px;"/></td>
</tr>

<tr>
	<td>Salon</td>
    <td><input class="inputs"  id="dlg_salon_grupos" name="salon" value="" style="width:200px;"/></td>
</tr>
<tr>
	<td>Turno</td>
    <td><select class="inputs"  id="dlg_turno_grupos" name="turno"><option value="Matutino">Matutino</option><option value="Vespertino">Vespertino</option><option value="Nocturno">Nocturno</option></select></td>
</tr>

<tr>
	<td colspan="2"><div id="dlg_mensaje_grupos"></div></td>
</tr>
</table>
<input type="hidden" id="dlg_accion_grupos" name="accion" value="" />
    <td><input type="hidden" id="dlg_botones_grupos" name="botones" value="" style="width:400px;" readonly/></td>
</form>
</div><!--termina dlg-->    


</div><!--termina cb-->
