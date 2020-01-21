<?php
//Modulo de Ventas ejemplo de Maestro-Detalle


//SubPlantilla detventas
ob_start();
include("detventas.php");
$subPlantilla = ob_get_clean();



$aDat = array();

$aDat['subPlantilla']['modulo'] = 'detventas';
$aDat['subPlantilla']['CampoMaestroEnlace'] = 'id';
$aDat['subPlantilla']['CampoDetalleEnlace'] = 'ventas_id';
$aDat['subPlantilla']['contenido'] = $subPlantilla;

$aDat['modulo'] = 'ventas';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Ventas','width'=>'800','height'=>'650');
$aDat['SeguirAgregando'] = 0;

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
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_ventas','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Id Cliente');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'clientes_id','class'=>'inputs readonly','style'=>'width:100px;');
$aDlgCol[1]['objetos'][] = array('tipo'=>'botonlista','referencia'=>'lclientes','referencia_modulo'=>'lclientes','CamposReceptores'=>array('clientes_id','nombre'),'class'=>'inputs','style'=>'');
$aDlgCol[1]['objetos'][] = array('tipo'=>'html','referencia'=>"<!--seguridad-ventas-autoriza1--><button id=\"bs_autoriza1\" class=\"inputs\" onclick=\"alert('hola')\">prueba</button><!--/seguridad-->");
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Cliente Nombre');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'nombre','class'=>'inputs readonly','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Fecha');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'fecha','class'=>'inputs maskFecha','style'=>'width:120px;','required'=>'required');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


$aDat['DlgRenglones'] = $aDlgRenglones;


			
echo simplePlantilla1($aDat);






$aDat = array();
$aDat['modulo'] = 'lclientes';
$aDat['moduloEdicion'] = 'clientes';

//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Ventas','width'=>'700');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'c.id','opcomparacion'=>'LIKE','ordenable'=>'desc');
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'c.nombre','opcomparacion'=>'LIKE','ordenable'=>'');
$aDat['FiltroCampos'] = $aFiltroCampos;

$aDat['NumeroRegistros'] = '3';

//importante que exista una columna con valor de id, que identifique el registro para las acciones de Agregar, Cambiar o Eliminar...
$aColumnas = array();
$aColumnas[] = array('valor'=>'id','etiqueta'=>'id');
$aColumnas[] = array('valor'=>'nombre','etiqueta'=>'Nombre');
$aDat['Columnas'] = $aColumnas;

$aDat['ParametrosFuncion'] = array('id','nombre');


echo simplePlantilla_listado1($aDat);



/*

				
*/
?>		
