<?php

try {

    $vinculo->beginTransaction();
	if($qryBloqueo!==''){
		$vinculo->query($qryBloqueo);
	}
	
	
	$recordset = $vinculo->query($qry);
	
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


$vinculo = null;
?>