<?php
if($recordset=mysqli_query($vinculo, $qry )){
	$datos_consulta = "";
	if(@mysqli_num_rows( $recordset ) > 0 && $accion=="consultar"){
		while($row = mysqli_fetch_assoc($recordset) ){
			foreach($row as $key=>$val){
				$datos_consulta .= "<$key><![CDATA[$val]]></$key>";
			}
		}
		mysqli_free_result($recordset);
	}
	$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>S</estatus><mensaje></mensaje>'.$datos_consulta.'</root>';
}else{
	$cadxml =  '<?xml version="1.0" encoding="utf-8"?><root><estatus>N</estatus><mensaje><![CDATA[Error de Query ('.$qry.') ('.mysqli_error($vinculo).')]]></mensaje></root>';
};
mysqli_close($vinculo);
?>