<?php
//Modulo de Ventas2 ejemplo de Maestro-Detalle
//Con el Objeto Table


$aDat = array();

$aDat['modulo'] = 'ventas2';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Ventas','width'=>'800','height'=>'800');
$aDat['SeguirAgregando'] = 0;
$aDat['AccionAlLlenarReg'] = 'bloqueoCapturaNotaCerrada(xml);';

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'v.id','etiqueta'=>'id Ventas');
$aFiltroCampos[] = array('valor'=>'v.clientes_id','etiqueta'=>'id Cliente');
$aFiltroCampos[] = array('valor'=>'c.nombre','etiqueta'=>'Cliente Nombre');
$aFiltroCampos[] = array('valor'=>'v.fecha','etiqueta'=>'Fecha');
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
$aColumnas[] = array('valor'=>'rowid','etiqueta'=>'No.');
$aColumnas[] = array('valor'=>'id','etiqueta'=>'id_ventas');
$aColumnas[] = array('valor'=>'clientes_id','etiqueta'=>'Id Cliente');
$aColumnas[] = array('valor'=>'nombre','etiqueta'=>'Cliente Nombre');
$aColumnas[] = array('valor'=>'fecha','etiqueta'=>'Fecha');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();

//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'id_ventas');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgCol[2]['atributos'] = array();
$aDlgCol[2]['objetos'][] = array('tipo'=>'html','referencia'=>"<!--seguridad-ventas2-impresion--><button id=\"bs_impresionNota\" class=\"\" onclick=\"imprimirNotaVenta(this)\"><i class=\"fas fa-print\"></i></button><!--/seguridad-->");
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_ventas','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Id Cliente');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'clientes_id','class'=>'inputs readonly','style'=>'width:100px;');
$aDlgCol[1]['objetos'][] = array('tipo'=>'botonlista','referencia'=>'lctevtas2','referencia_modulo'=>'lclientes','CamposReceptores'=>array('clientes_id','nombre'),'class'=>'inputs','style'=>'');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Cliente Nombre');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'nombre','class'=>'inputs readonly','style'=>'width:400px;');
$aDlgCol[1]['objetos'][] = array('tipo'=>'hidden','referencia'=>'status','class'=>'readonly','style'=>'');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Fecha');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'fecha','class'=>'inputs maskFecha','style'=>'width:120px;','required'=>'required');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);



$aTabCols 	= array();
$aTabCols[] = array('titulo'=>'id Producto','atributos'=>array('class'=>'','style'=>'width:80px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'productos_id','atributos'=>array('class'=>'inputs 	completaprod calcImp','style'=>'width:90%;'))
					)
				);
$aTabCols[] = array('titulo'=>'Descripción','atributos'=>array('class'=>'','style'=>'width:250px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'descripcion','atributos'=>array('class'=>'','style'=>'width:90%;','readonly'=>'readonly','tabindex'=>'-1','disabled'=>'disabled'))
					),
				'pie'=>array('titulo'=>'Totales','atributos'=>array('class'=>'','style'=>''))
				);
$aTabCols[] = array('titulo'=>'Cantidad','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'cantidad','atributos'=>array('class'=>'inputs maskDecimal2 calcImp','style'=>'width:90%;'))
					),
				'pie'=>array('referencia'=>'sumcantidad','atributos'=>array('class'=>'maskDecimal2','style'=>'','readonly'=>'readonly','tabindex'=>'-1','disabled'=>'disabled','style'=>'width:90%;'))
				);
$aTabCols[] = array('titulo'=>'Precio','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'precio','atributos'=>array('class'=>'inputs maskMoneda2 calcImp','style'=>'width:90%;'))
					),
				'pie'=>array()
				);


$aTabCols[] = array('titulo'=>'%Desc.','atributos'=>array('class'=>'','style'=>'width:70px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'descuento','atributos'=>array('class'=>'inputs maskDescuento calcImp','style'=>'width:90%;'))
					),
				'pie'=>array()
				);


$aTabCols[] = array('titulo'=>'Importe','atributos'=>array('class'=>'','style'=>'width:150px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'importe','atributos'=>array('class'=>'maskMoneda2','style'=>'width:90%;','readonly'=>'readonly','tabindex'=>'-1','disabled'=>'disabled'))
					),
				'pie'=>array('referencia'=>'sumimporte','atributos'=>array('class'=>'maskMoneda2','style'=>'','readonly'=>'readonly','tabindex'=>'-1','disabled'=>'disabled','style'=>'width:90%;'))
				);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array('colspan'=>'3');
$aDlgCol[0]['objetos'][] = array('tipo'=>'table','referencia'=>'tdventas2','tagRegistro'=>'tdventas2','columnas'=>$aTabCols,'muestraEncabezado'=>true,'muestraPie'=>true);
$aDlgRenglones[] = array('atributos'=>array('class'=>'tablaDir'),'columnas'=>$aDlgCol);





$aDat['DlgRenglones'] = $aDlgRenglones;


			
echo simplePlantilla1($aDat);



?>
