<?php





$aDat = array();
$aDat['modulo'] = 'areas';
//$aDat['AccionAlLlenarReg'] = 'completaRegIndicadores(xml);';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Areas','width'=>'770');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'a.id','etiqueta'=>'id');
$aFiltroCampos[] = array('valor'=>'a.descorta','etiqueta'=>'Descripcion Corta');
$aFiltroCampos[] = array('valor'=>'a.descripcion','etiqueta'=>'Descripcion');
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
$aColumnas[] = array('valor'=>'descorta','etiqueta'=>'Descripcion Corta');
$aColumnas[] = array('valor'=>'descripcion','etiqueta'=>'Descripcion');
//$aColumnas[] = array('valor'=>'##boton_cambiar##','etiqueta'=>'Editar');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();


//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'ID');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_areas','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Descripcion Corta');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'descorta','class'=>'inputs','style'=>'width:180px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Descripcion');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'descripcion','class'=>'inputs','style'=>'width:600px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);




$aDat['DlgRenglones'] = $aDlgRenglones;
			
echo simplePlantilla1($aDat);





?>