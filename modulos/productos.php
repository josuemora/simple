<?php
$aDat = array();
$aDat['modulo'] = 'productos';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Productos','width'=>'600');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'p.id','etiqueta'=>'id Producto');
$aFiltroCampos[] = array('valor'=>'p.descripcion','etiqueta'=>'Descripción');
$aFiltroCampos[] = array('valor'=>'p.precio','etiqueta'=>'Precio');
$aDat['FiltroCampos'] = $aFiltroCampos;

$aNumeroRegistros = array();
$aNumeroRegistros[] = array('valor'=>'3','etiqueta'=>'3');
$aNumeroRegistros[] = array('valor'=>'5','etiqueta'=>'5');
$aNumeroRegistros[] = array('valor'=>'8','etiqueta'=>'8');
$aNumeroRegistros[] = array('valor'=>'10','etiqueta'=>'10');
$aNumeroRegistros[] = array('valor'=>'13','etiqueta'=>'13');
$aNumeroRegistros[] = array('valor'=>'15','etiqueta'=>'15');
$aDat['NumeroRegistros'] = $aNumeroRegistros;

//importante que exista una columna con valor de id, que identifique el registro para las acciones de Agregar, Cambiar o Eliminar...
$aColumnas = array();
$aColumnas[] = array('valor'=>'id','etiqueta'=>'Id');
$aColumnas[] = array('valor'=>'descripcion','etiqueta'=>'Descripción');
$aColumnas[] = array('valor'=>'precio','etiqueta'=>'Precio');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();


//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'id_productos');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_productos','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Descripción');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'descripcion','class'=>'inputs','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Precio');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'precio','class'=>'inputs maskMoneda2','style'=>'width:100px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


$aDat['DlgRenglones'] = $aDlgRenglones;
			
echo simplePlantilla1($aDat);



?>