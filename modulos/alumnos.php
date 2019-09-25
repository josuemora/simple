<?php
$aDat = array();
$aDat['modulo'] = 'alumnos';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Alumnos','width'=>'600');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'a.id','etiqueta'=>'id Alumno');
$aFiltroCampos[] = array('valor'=>'a.nombre','etiqueta'=>'Nombre');
$aFiltroCampos[] = array('valor'=>'a.paterno','etiqueta'=>'Paterno');
$aFiltroCampos[] = array('valor'=>'a.materno','etiqueta'=>'Materno');
$aFiltroCampos[] = array('valor'=>'g.grado','etiqueta'=>'Grado');
$aFiltroCampos[] = array('valor'=>'g.salon','etiqueta'=>'Salon');
$aFiltroCampos[] = array('valor'=>'g.turno','etiqueta'=>'Turno');
$aFiltroCampos[] = array('valor'=>'a.sexo','etiqueta'=>'Sexo');
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
$aColumnas[] = array('valor'=>'id','etiqueta'=>'id_alumnos');
$aColumnas[] = array('valor'=>'nombre','etiqueta'=>'Nombre');
$aColumnas[] = array('valor'=>'paterno','etiqueta'=>'Paterno');
$aColumnas[] = array('valor'=>'materno','etiqueta'=>'Materno');
$aColumnas[] = array('valor'=>'grupo','etiqueta'=>'Grupo');
$aColumnas[] = array('valor'=>'sexo','etiqueta'=>'sexo');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();

//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'id_alumnos');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:160px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_alumnos','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Nombre');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'nombre','class'=>'inputs','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Paterno');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'paterno','class'=>'inputs readonly','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Materno');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'materno','class'=>'inputs','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Grupo');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'select','referencia'=>'grupos_id','tagOpciones'=>'grupos','max-height'=>'100px');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


//radio: en la referencia se agrega dos datos separado por un gion bajo (_). dato1: campo, dato2: valor			
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Sexo');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'radio','referencia'=>'sexo_m','label'=>'Masculino','class'=>'inputs','style'=>'margin-right:10px;margin-bottom:10px;');			
$aDlgCol[1]['objetos'][] = array('tipo'=>'radio','referencia'=>'sexo_f','label'=>'Femenino','class'=>'inputs','style'=>'margin-right:10px;margin-bottom:10px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


//checkbox: en la referencia se agrega dos datos separado por un gion bajo (_). dato1: campo, dato2: valor					
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Otros <i class="fa fa-times"></i>');
$aDlgCol[0]['objetos'][] = array('tipo'=>'botonlista','referencia'=>'lalumnos','referencia_modulo'=>'lalumnos','CamposReceptores'=>array('paterno','materno'),'class'=>'inputs','style'=>'');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'checkbox','referencia'=>'usalentes_s','label'=>'Usa Lentes?','class'=>'inputs','style'=>'margin-right:10px;margin-bottom:10px;');			
$aDlgCol[1]['objetos'][] = array('tipo'=>'checkbox','referencia'=>'enfermedad_s','label'=>'Tiene Alguna Enfermedad?','class'=>'inputs','style'=>'margin-right:10px;margin-bottom:10px;');
$aDlgCol[1]['objetos'][] = array('tipo'=>'checkbox','referencia'=>'capacidaddiferente_s','label'=>'Capacidad Diferente?','class'=>'inputs','style'=>'margin-right:10px;margin-bottom:10px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDat['DlgRenglones'] = $aDlgRenglones;
			
echo simplePlantilla1($aDat);







$aDat = array();
$aDat['modulo'] = 'lalumnos';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Listado de Alumnos','width'=>'700');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'a.id','opcomparacion'=>'LIKE','ordenable'=>'desc');
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'a.nombre','opcomparacion'=>'LIKE','ordenable'=>'');
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'a.paterno','opcomparacion'=>'LIKE','ordenable'=>'');
$aFiltroCampos[] = array('oplogico'=>'or','campo'=>'a.materno','opcomparacion'=>'LIKE','ordenable'=>'');
$aDat['FiltroCampos'] = $aFiltroCampos;

$aDat['NumeroRegistros'] = '3';

//importante que exista una columna con valor de id, que identifique el registro para las acciones de Agregar, Cambiar o Eliminar...
$aColumnas = array();
$aColumnas[] = array('valor'=>'id','etiqueta'=>'id');
$aColumnas[] = array('valor'=>'nombre','etiqueta'=>'Nombre');
$aColumnas[] = array('valor'=>'paterno','etiqueta'=>'Paterno');
$aColumnas[] = array('valor'=>'materno','etiqueta'=>'Materno');
$aColumnas[] = array('valor'=>'grupo','etiqueta'=>'Grupo');
$aColumnas[] = array('valor'=>'sexo','etiqueta'=>'sexo');
$aDat['Columnas'] = $aColumnas;

$aDat['ParametrosFuncion'] = array('id','nombre');


echo simplePlantilla_listado1($aDat);



/*

				
*/
?>		
