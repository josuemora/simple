<?php
$aDat = array();
$aDat['modulo'] = 'detventas';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Det Ventas','width'=>'600');
$aDat['SeguirAgregando'] = 1;

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('oplogico'=>'and','campo'=>'d.ventas_id','opcomparacion'=>'=','ordenable'=>'');
$aDat['FiltroCampos'] = $aFiltroCampos;

$aDat['NumeroRegistros'] = '3';

//importante que exista una columna con valor de id, que identifique el registro para las acciones de Agregar, Cambiar o Eliminar...
$aColumnas = array();
$aColumnas[] = array('valor'=>'id','etiqueta'=>'id_detventas');
$aColumnas[] = array('valor'=>'productos_id','etiqueta'=>'Id Producto');
$aColumnas[] = array('valor'=>'descripcion','etiqueta'=>'Descripción');
$aColumnas[] = array('valor'=>'cantidad','etiqueta'=>'Cantidad','atributosTit'=>array('align'=>'right'),'atributos'=>array('align'=>'right'));
$aColumnas[] = array('valor'=>'precio','etiqueta'=>'Precio','atributosTit'=>array('align'=>'right'),'atributos'=>array('align'=>'right'));
$aColumnas[] = array('valor'=>'importe','etiqueta'=>'Importe','atributosTit'=>array('align'=>'right'),'atributos'=>array('align'=>'right'));
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();

//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'id_detventas');
$aDlgCol[0]['objetos'][] = array('tipo'=>'html','referencia'=>'<input type="hidden" name="ventas_id" value=""/>');//importante para el enlace Maestro-Detalle
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_detventas','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Id Producto');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'productos_id','class'=>'inputs readonly','style'=>'width:100px;');
$aDlgCol[1]['objetos'][] = array('tipo'=>'botonlista','referencia'=>'lproductos','referencia_modulo'=>'lproductos','CamposReceptores'=>array('productos_id','descripcion'),'class'=>'inputs','style'=>'');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Descripción');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'descripcion','class'=>'inputs readonly','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Cantidad');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'cantidad','class'=>'inputs maskDecimal2','style'=>'width:100px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Precio');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'precio','class'=>'inputs maskMoneda2','style'=>'width:100px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


$aDat['DlgRenglones'] = $aDlgRenglones;
			
echo simplePlantilla1($aDat);






$aDat = array();
$aDat['modulo'] = 'lproductos';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Listado de Productos','width'=>'700');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'p.id','opcomparacion'=>'LIKE','ordenable'=>'desc');
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'p.descripcion','opcomparacion'=>'LIKE','ordenable'=>'');
$aDat['FiltroCampos'] = $aFiltroCampos;

$aDat['NumeroRegistros'] = '3';

//importante que exista una columna con valor de id, que identifique el registro para las acciones de Agregar, Cambiar o Eliminar...
$aColumnas = array();
$aColumnas[] = array('valor'=>'id','etiqueta'=>'id');
$aColumnas[] = array('valor'=>'descripcion','etiqueta'=>'Descripción');
$aDat['Columnas'] = $aColumnas;

$aDat['ParametrosFuncion'] = array('id','descripcion');


echo simplePlantilla_listado1($aDat);


?>		
