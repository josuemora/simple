<?php
//estos querys deben ir sin where ni order ni limit ya que son controlados por los filtros...
$aModqry = array();
$aModqry['accesos'] = "select a.*,p.nombre as perfil from simple_seguridad.accesos a left join simple_seguridad.perfiles p on a.perfiles_id=p.id";
$aModqry['perfiles'] = "select p.* from simple_seguridad.perfiles p";
$aModqry['usuarios'] = "select u.*,p.nombre as perfil from simple_seguridad.usuarios u left join simple_seguridad.perfiles p on u.perfiles_id=p.id";

$aModqry['grupos'] = "select g.* from grupos g";
$aModqry['alumnos'] = "select a.*,concat(g.grado,' ',g.salon,' ',g.turno) as grupo from alumnos a left join grupos g on a.grupos_id=g.id";
$aModqry['lalumnos'] = "select a.*,concat(g.grado,' ',g.salon,' ',g.turno) as grupo from alumnos a left join grupos g on a.grupos_id=g.id";

$aModqry['ventas'] = "select v.*,c.nombre from ventas v left join clientes c on v.clientes_id=c.id";
$aModqry['ventas2'] = "select v.*,c.nombre from ventas2 v left join clientes c on v.clientes_id=c.id";
$aModqry['lclientes'] = "select c.* from clientes c ";
$aModqry['clientes'] = "select c.* from clientes c ";

$aModqry['lproductos'] = "select p.* from productos p ";
$aModqry['productos'] = "select p.* from productos p ";


//$aModqry['detventas'] = "select d.*,p.descripcion from detventas d left join productos p on d.productos_id=p.id";
$aModqry['detventas'] = "select d.id, d.productos_id,format(d.cantidad,2) as cantidad,format(d.precio,2) as precio,format(d.cantidad*d.precio,2) as importe,p.descripcion from detventas d left join productos p on d.productos_id=p.id";

//Querys para los totales...
$aModTotqry = array();
$aModTotqry['detventas'] = "select concat('Regs.',count(id)) as productos_id,format(sum(d.cantidad),2) as cantidad,format(sum(d.cantidad*d.precio),2) as importe,'Totales' as descripcion from detventas as d   ";


?>
