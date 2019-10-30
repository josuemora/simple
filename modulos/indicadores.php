<?php

$aDat = array();
$aDat['modulo'] = 'indicadores';
$aDat['AccionAlLlenarReg'] = 'completaRegIndicadores(xml);';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Indicadores','width'=>'900');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'i.id','etiqueta'=>'id');
$aFiltroCampos[] = array('valor'=>'i.indicador','etiqueta'=>'Indicador');
$aFiltroCampos[] = array('valor'=>'i.descripcion','etiqueta'=>'Descripcion');
$aFiltroCampos[] = array('valor'=>'a.descorta','etiqueta'=>'Area');
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
//$aColumnas[] = array('valor'=>'##indice##','etiqueta'=>'No.');
$aColumnas[] = array('valor'=>'rowid','etiqueta'=>'No.');
$aColumnas[] = array('valor'=>'id','etiqueta'=>'Id');
$aColumnas[] = array('valor'=>'indicador','etiqueta'=>'Indicador');
$aColumnas[] = array('valor'=>'descripcion','etiqueta'=>'Descripcion');
$aColumnas[] = array('valor'=>'descorta','etiqueta'=>'Area');
//$aColumnas[] = array('valor'=>'##boton_cambiar##','etiqueta'=>'Editar');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();


//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'ID');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_indicadores','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Indicador');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'indicador','atributos'=>array('class'=>'inputs maskEntero','style'=>'width:80px;','autocomplete'=>'off'));

$aDlgCol[2]['atributos'] = array('colspan'=>'3','style'=>'text-align:right');
$aDlgCol[2]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Digitos Fracción');
$aDlgCol[3]['atributos'] = array();
$aDlgCol[3]['objetos'][] = array('tipo'=>'text','referencia'=>'digfraccion','atributos'=>array('class'=>'inputs maskEntero','style'=>'width:50px;','autocomplete'=>'off'));
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Descripción');
$aDlgCol[1]['atributos'] = array('colspan'=>'5');
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'descripcion','atributos'=>array('class'=>'inputs','style'=>'width:720px;','autocomplete'=>'off'));
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Área');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'select','referencia'=>'areas_id','tagOpciones'=>'areas','max-height'=>'100px','class'=>'inputs','atributos'=>array('class'=>'inputs','width'=>'200px','max-height'=>'100px'));
$aDlgCol[2]['atributos'] = array();
$aDlgCol[2]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Unidad');
$aDlgCol[3]['atributos'] = array();
$aDlgCol[3]['objetos'][] = array('tipo'=>'select','referencia'=>'unidades_id','tagOpciones'=>'unidades','max-height'=>'100px','class'=>'inputs','atributos'=>array('class'=>'inputs','width'=>'130px','max-height'=>'100px'));
$aDlgCol[4]['atributos'] = array();
$aDlgCol[4]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Graficar?');
$aDlgCol[5]['atributos'] = array();
$aDlgCol[5]['objetos'][] = array('tipo'=>'select','referencia'=>'graficar','tagOpciones'=>'lgraficar','max-height'=>'100px','class'=>'inputs','atributos'=>array('class'=>'inputs','width'=>'200px','max-height'=>'100px'));
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


$cad = '<div id="dlg_indicadores_lusuarios" style="max-height:300px; width:100%; overflow:scroll; border:1px solid #ddd;"></div>';

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Usuarios');
$aDlgCol[1]['atributos'] = array('colspan'=>'5');
$aDlgCol[1]['objetos'][] = array('tipo'=>'html','referencia'=>$cad,'class'=>'','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);





$aDat['DlgRenglones'] = $aDlgRenglones;
			
echo simplePlantilla1($aDat);





?>