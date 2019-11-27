<?php
//Modulo de Marcos ejemplo de Maestro-Detalle
//Con el Objeto Table


$aDat = array();

$aDat['modulo'] = 'marcos';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Marcos','width'=>'600','height'=>'760');
$aDat['SeguirAgregando'] = 0;
//$aDat['EventoAlAbrir'] = 'CreaGrafico();';

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'m.id','etiqueta'=>'Registro');
$aFiltroCampos[] = array('valor'=>'m.comentario','etiqueta'=>'Descripción');
$aFiltroCampos[] = array('valor'=>'m.tablero','etiqueta'=>'Tablero');
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
//$aColumnas[] = array('valor'=>'rowid','etiqueta'=>'No.');
$aColumnas[] = array('valor'=>'id','etiqueta'=>'Reg.');
//$aColumnas[] = array('valor'=>'indicadores_id','etiqueta'=>'Id');
$aColumnas[] = array('valor'=>'comentario','etiqueta'=>'Descripción');
$aColumnas[] = array('valor'=>'tablero','etiqueta'=>'Tablero');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();

//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Registro No.');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_marco','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Descripción');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'comentario','class'=>'inputs','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Tablero');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'select','referencia'=>'tablero','tagOpciones'=>'tableros','max-height'=>'200px');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);




$aTabCols 	= array();

$aTabCols[] = array('titulo'=>'Indicador1','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'ind1','atributos'=>array('class'=>'inputs maskDecimal2','style'=>'width:90%;'))
					)
				);
$aTabCols[] = array('titulo'=>'Indicador2','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'ind2','atributos'=>array('class'=>'inputs maskDecimal2','style'=>'width:90%;'))
					)
				);
$aTabCols[] = array('titulo'=>'Indicador3','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'ind3','atributos'=>array('class'=>'inputs maskDecimal2','style'=>'width:90%;'))
					)
				);

$aTabCols[] = array('titulo'=>'Indicador4','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'ind4','atributos'=>array('class'=>'inputs maskDecimal2','style'=>'width:90%;'))
					)
				);



$aDlgCol = array();
$aDlgCol[0]['atributos'] = array('colspan'=>'2');
$aDlgCol[0]['objetos'][] = array('tipo'=>'table','referencia'=>'marco_det','tagRegistro'=>'marco_det','columnas'=>$aTabCols,'muestraEncabezado'=>true,'muestraPie'=>false);

$aDlgRenglones[] = array('atributos'=>array('class'=>'tablaDir'),'columnas'=>$aDlgCol);


$aDat['DlgRenglones'] = $aDlgRenglones;


			
echo simplePlantilla1($aDat);



?>
