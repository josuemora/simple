<?php
session_start();
$a = session_get_cookie_params();
print_r($a);
print_r($_SESSION);
print_r($_COOKIE);

/*
$qryBloqueo = '';
$flag1 = 0; //Bandera para que presente el resultado de query en xml



if($guardaCache == '1' && $id_ventas != '0' && $accion != "consultar"){

	$cache = serialize($_POST);

	$qryBloqueo = "select * from ventas2 where id=$id_ventas for update";
	$qry = "update ventas2 set cache='$cache'";
	$qry = $qry." where id=$id_ventas";
	$flag1 = 1;
	
};
*/

	/*
	//checar si hay cache
	$qry = "select cache from ventas2 where id=$id_ventas limit 1";
	$cache = array();
	if($recordset = $vinculo->query($qry)){
		while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
			$cache = unserialize($row['cache']);
		}
		$recordset->closeCursor();
	}
	if(isset($cache['NumRen'])){
		//print_r($cache);exit();
		$aRegs = array();
		foreach($cache['NumRen'] as $NumRen){
			$productos_id = isset($cache['productos_id_'.$NumRen]) ? $cache['productos_id_'.$NumRen] : 0;
			$cantidad = isset($cache['cantidad_'.$NumRen]) ? $cache['cantidad_'.$NumRen] : 0;
			$precio = isset($cache['precio_'.$NumRen]) ? $cache['precio_'.$NumRen] : '';
			$aRegs[] = array('ren'=>$NumRen,'ventas_id'=>$ventas_id,'productos_id'=>$productos_id,'cantidad'=>$cantidad,'precio'=>$precio);
		};
	}else{
	//}
		
*/

/*
if($flag1 == 1){
	include("../core/ABC_query_xml_pdo.php");
}
*/


	/*
	try {

		$qryBloqueo = "select * from ventas2 where id=$id_ventas for update";
		$qryBloqueo2 = "select * from detventas2 where ventas_id=$id_ventas for update";
		$vinculo->beginTransaction();
		$vinculo->query($qryBloqueo);
		$vinculo->query($qryBloqueo2);

		$qry = "update ventas2 set clientes_id=$clientes_id,fecha='$fecha',cache=''";
		$qry = $qry." where id=$id_ventas";

		$recordset = $vinculo->query($qry);

		if(isset($_POST['NumRen'])){
			$qry = "delete from detventas2 where ventas_id=$id_ventas";
			$recordset = $vinculo->query($qry);
			foreach($_POST['NumRen'] as $NumRen){
				$productos_id = isset($_POST['productos_id_'.$NumRen]) ? trim($_POST['productos_id_'.$NumRen]) : '0';
				$cantidad = isset($_POST['cantidad_'.$NumRen]) ? trim($_POST['cantidad_'.$NumRen]) : '0';
				$precio = isset($_POST['precio_'.$NumRen]) ? trim($_POST['precio_'.$NumRen]) : '0';
				if(strlen($NumRen)>0 && strlen($id_ventas)>0 && strlen($productos_id)>0 && strlen($cantidad)>0 && strlen($precio)>0){
					$qry = "insert into detventas2 (ren,ventas_id,productos_id,cantidad,precio) values ($NumRen,$id_ventas,$productos_id,$cantidad,$precio)";
					$recordset = $vinculo->query($qry);
				}
			};
		}

		$vinculo->commit();
		$recordset->closeCursor();
		$recordset = NULL;
		$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>S</estatus><mensaje><![CDATA['.$qry.']]></mensaje>'.$datos_consulta.$cadxml.'</root>';
		
	} catch (Exception $e) {
		$vinculo->rollBack();
		$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>N</estatus><mensaje><![CDATA[Error de Query ('.$qry.') ('.$e->getMessage().')]]></mensaje></root>';

	}
*/
	/*
	try {
		$vinculo->beginTransaction();
		foreach($aQry as $qry){
			$recordset = $vinculo->query($qry);
		}
		$datos_consulta = "";
		if($accion=="consultar" && $recordset->rowCount()>0){
			while($row = $recordset->fetch(PDO::FETCH_ASSOC) ){
				foreach($row as $key=>$val){
					$datos_consulta .= "<$key><![CDATA[$val]]></$key>";
				}
			}
		}
		
		$vinculo->commit();
		$recordset->closeCursor();
		$recordset = NULL;
		$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>S</estatus><mensaje><![CDATA['.$qry.']]></mensaje>'.$datos_consulta.$cadxml.'</root>';
	} catch (Exception $e) {
		$vinculo->rollBack();
		$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>N</estatus><mensaje><![CDATA[Error de Query ('.$qry.') ('.$e->getMessage().')]]></mensaje></root>';

	}
	*/



?>