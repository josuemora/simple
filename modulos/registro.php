<?php
//=================================================================================================================
//lindicadores ... para el boton de seleccion de indicadores
$aDat = array();
$aDat['modulo'] = 'lindicadores';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Listado de Indicadores','width'=>'700');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'i.id','opcomparacion'=>'LIKE','ordenable'=>'desc');
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'i.indicador','opcomparacion'=>'LIKE','ordenable'=>'desc');
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'i.descripcion','opcomparacion'=>'LIKE','ordenable'=>'');
$aDat['FiltroCampos'] = $aFiltroCampos;

$aDat['NumeroRegistros'] = '3';

//importante que exista una columna con valor de id, que identifique el registro para las acciones de Agregar, Cambiar o Eliminar...
$aColumnas = array();

$aColumnas[] = array('valor'=>'rowid','etiqueta'=>'No.');
$aColumnas[] = array('valor'=>'id','etiqueta'=>'Id');
$aColumnas[] = array('valor'=>'indicador','etiqueta'=>'Indicador');
$aColumnas[] = array('valor'=>'descripcion','etiqueta'=>'Descripcion');


$aDat['Columnas'] = $aColumnas;

$aDat['ParametrosFuncion'] = array('id','indicador','descripcion');


echo simplePlantilla_listado1($aDat);
//=================================================================================================================
//=================================================================================================================
//=================================================================================================================





//Modulo de reg_indicadores ejemplo de Maestro-Detalle
//Con el Objeto Table


$aDat = array();

$aDat['modulo'] = 'registro';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Registro','width'=>'1200','height'=>'740');
$aDat['SeguirAgregando'] = 0;
$aDat['EventoAlAbrir'] = 'CreaGrafico();';
$aDat['AccionAlLlenarReg'] = 'completaRegistro(xml);';

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'re.id','etiqueta'=>'Registro');
$aFiltroCampos[] = array('valor'=>'i.indicador','etiqueta'=>'id Indicador');
$aFiltroCampos[] = array('valor'=>'re.anio','etiqueta'=>'Año');
$aFiltroCampos[] = array('valor'=>'a.descorta','etiqueta'=>'Area');
//$aFiltroCampos[] = array('valor'=>'v.fecha','etiqueta'=>'Fecha');
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
$aColumnas[] = array('valor'=>'anio','etiqueta'=>'Año');
$aColumnas[] = array('valor'=>'indicador','etiqueta'=>'Indicador');
$aColumnas[] = array('valor'=>'descripcion','etiqueta'=>'Descripción');
$aColumnas[] = array('valor'=>'descorta','etiqueta'=>'Area');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();

//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Registro No.');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_registro','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Id Indicador');
$aDlgCol[1]['atributos'] = array();
//'atributos'=>array('class'=>'','style'=>'width:90%;','readonly'=>'readonly','tabindex'=>'-1','disabled'=>'disabled')
$aDlgCol[1]['objetos'][] = array('tipo'=>'hidden','referencia'=>'indicadores_id','class'=>'readonly','style'=>'width:0px;');
$aDlgCol[1]['objetos'][] = array('tipo'=>'hidden','referencia'=>'digfraccion','class'=>'readonly','style'=>'width:0px;');


$btnLista = array('tipo'=>'botonlista','referencia'=>'lindicadores','referencia_modulo'=>'lindicadores','CamposReceptores'=>array('indicadores_id','indicador','descripcion'),'atributos'=>array('class'=>'inputs','style'=>''));
$inputAnio = array('tipo'=>'text','referencia'=>'anio','atributos'=>array('class'=>'inputs maskEntero','style'=>'width:80px;','autocomplete'=>'off'));

if($_SESSION['accesos'][$token]["perfil_usuarios"]=='Usuario'){
	//$btnLista['atributos']['disabled'] 		= 'disabled'; 
	$btnLista = array('tipo'=>'etiqueta','referencia'=>'');
	$inputAnio['atributos']['readonly'] 	= 'readonly';
	$inputAnio['atributos']['class'] 	= $inputAnio['atributos']['class'].' readonly';
};


$aDlgCol[1]['objetos'][] = $btnLista;
//$aDlgCol[1]['objetos'][] = array('tipo'=>'html','referencia'=>"<!--seguridad-ventas-autoriza1--><button id=\"bs_autoriza1\" class=\"inputs\" onclick=\"alert('hola')\">prueba</button><!--/seguridad-->");
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'indicador','class'=>'readonly','style'=>'width:60px;');
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'descripcion','class'=>'readonly','style'=>'width:420px;');

$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Año');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = $inputAnio;
//$aDlgCol[2]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Unidad');
//$aDlgCol[3]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'unidesc','class'=>'readonly','style'=>'width:150px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);



$aTabCols 	= array();
/*
$aTabCols[] = array('titulo'=>'Mes','atributos'=>array('class'=>'','style'=>'width:80px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'mes','atributos'=>array('class'=>'inputs','style'=>'width:90%;'))
					)
				);
*/
/*
$aTabCols[] =  array('titulo'=>'Mes','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'select','referencia'=>'mes','tagOpciones'=>'lista_meses','atributos'=>array('class'=>'inputs','width'=>'90px','max-height'=>'100px','disabled'=>'disabled'))
					)
				);
*/

$aTabCols[] = array('titulo'=>'Mes','atributos'=>array('class'=>'','style'=>'width:50px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'mesd','atributos'=>array('class'=>'','style'=>'width:90%;','readonly'=>'readonly'))
					)
				);
				
$atemp = array('class'=>'maskDecimal2 pintaGrafico','style'=>'width:90%;','autocomplete'=>'off'); 
$atemp2 = array('class'=>'inputs maskDecimal2 pintaGrafico','style'=>'width:90%;','autocomplete'=>'off');
if($_SESSION['accesos'][$token]["perfil_usuarios"]=='Usuario'){
	$atemp['readonly'] 	= 'readonly';
	$atemp2['class'] 	= $atemp2['class'].' bloqueaCaptura';
}else{
	$atemp['class'] 	= $atemp['class'].' inputs';
};


$aTabCols[] = array('titulo'=>'Minimo','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'minimo','atributos'=>$atemp)
					)
				);
$aTabCols[] = array('titulo'=>'Meta','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'meta','atributos'=>$atemp)
					)
				);
$aTabCols[] = array('titulo'=>'Excelente','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'excelente','atributos'=>$atemp)
					)
				);
				
$aTabCols[] = array('titulo'=>'Valor','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'valor','atributos'=>$atemp2)
					)
				);

$aTabCols[] = array('titulo'=>'Notas','atributos'=>array('class'=>'','style'=>'width:250px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'notas','atributos'=>array('class'=>'inputs','style'=>'width:90%;','autocomplete'=>'off'))
					)
				);





$aDlgCol = array();
$aDlgCol[0]['atributos'] = array('colspan'=>'2');
$aDlgCol[0]['objetos'][] = array('tipo'=>'table','referencia'=>'regind_det','tagRegistro'=>'regind_det','columnas'=>$aTabCols,'muestraEncabezado'=>true,'muestraPie'=>false);

$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'html','referencia'=>"<canvas width=420 height=200 id=\"foow\"></canvas><div id=\"preview-textfield\" class=\"TextoNumInd\"></div>");

$aDlgRenglones[] = array('atributos'=>array('class'=>'tablaDir'),'columnas'=>$aDlgCol);


$aDat['DlgRenglones'] = $aDlgRenglones;


			
echo simplePlantilla1($aDat);



?>
