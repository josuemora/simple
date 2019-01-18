<?php
$aDat = array();
$aDat['modulo'] = 'grupos';
//$aDat['TabEliminar'] = "0";
$aDat['aDlg'] = array('titulo'=>'Grupos','width'=>'1130');

/*<!-- Agregar los campos para el filtro. el valor es con el formato SQL alias.campo -->*/
$aFiltroCampos = array();
$aFiltroCampos[] = array('valor'=>'g.id','etiqueta'=>'id Grupo');
$aFiltroCampos[] = array('valor'=>'g.grado','etiqueta'=>'Grado');
$aFiltroCampos[] = array('valor'=>'g.salon','etiqueta'=>'Salon');
$aFiltroCampos[] = array('valor'=>'g.turno','etiqueta'=>'Turno');
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
$aColumnas[] = array('valor'=>'id','etiqueta'=>'ID');
$aColumnas[] = array('valor'=>'grado','etiqueta'=>'Grado');
$aColumnas[] = array('valor'=>'salon','etiqueta'=>'Salon');
$aColumnas[] = array('valor'=>'turno','etiqueta'=>'Turno');
$aDat['Columnas'] = $aColumnas;



$aDlgRenglones = array();


//importante agregar atributo id=row_id_{modulo} al Renglon (tr) para control de Agregar, Cambiar o Eliminar...
$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'id_grupos');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'id','class'=>'inputs','style'=>'width:60px;');
$aDlgRenglones[] = array('atributos'=>array('id'=>'row_id_grupos','style'=>'visibility:visible;'),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Grado');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'grado','class'=>'inputs','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Salon');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'text','referencia'=>'salon','class'=>'inputs','style'=>'width:400px;');
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDlgCol = array();
$aDlgCol[0]['atributos'] = array();
$aDlgCol[0]['objetos'][] = array('tipo'=>'etiqueta','referencia'=>'Turno');
$aDlgCol[1]['atributos'] = array();
$aDlgCol[1]['objetos'][] = array('tipo'=>'select','referencia'=>'turno','tagOpciones'=>'turnos','max-height'=>'100px','class'=>'inputs','atributos'=>array('class'=>'inputs guardaCache','width'=>'200px','max-height'=>'100px'));
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);


$aTabCols 	= array();
$aTabCols[] = array('titulo'=>'id Turno','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'valor','atributos'=>array('class'=>'inputs guardaCache','style'=>'width:90%;'))
					)
				);
$aTabCols[] = array('titulo'=>'Nombre','atributos'=>array('class'=>'','style'=>'width:100px;'),
				'objetos'=>array(
					array('tipo'=>'text','referencia'=>'texto','atributos'=>array('class'=>'inputs','style'=>'width:90%;'))
					)
				);
$aTabCols[] =  array('titulo'=>'Mas Select','atributos'=>array('class'=>'','style'=>'width:200px;'),
				'objetos'=>array(
					array('tipo'=>'select','referencia'=>'turxo','tagOpciones'=>'turnos','atributos'=>array('class'=>'inputs','width'=>'150px','max-height'=>'100px'))
					)
				);
$aTabCols[] = array('titulo'=>'Mas Select2','atributos'=>array('class'=>'','style'=>'width:200px;'),
				'objetos'=>array(
					array('tipo'=>'select','referencia'=>'turx2o','tagOpciones'=>'turnos','atributos'=>array('class'=>'inputs','width'=>'150px','max-height'=>'100px'))
					)
				);

$aTabCols[] = array('titulo'=>'Sexo','atributos'=>array('class'=>'','style'=>'width:280px;'),
				'objetos'=>array(
					array('tipo'=>'radio','referencia'=>'sexo_m','label'=>'Masculino','atributos'=>array('style'=>'margin-right:10px;margin-bottom:10px;','class'=>'inputs')),
					array('tipo'=>'radio','referencia'=>'sexo_f','titulo'=>'&nbsp;','label'=>'Femenino','atributos'=>array('style'=>'margin-right:10px;margin-bottom:10px;','class'=>'inputs'))
					)
				);

$aTabCols[] = array('titulo'=>'Adicionales','atributos'=>array('class'=>'','style'=>'width:150px;'),
				'objetos'=>array(
					array('tipo'=>'checkbox','referencia'=>'usalentes_s','label'=>'Usa Lentes?','atributos'=>array('class'=>'inputs'))
					)
				);


$aDlgCol = array();
$aDlgCol[0]['atributos'] = array('colspan'=>'2');
$aDlgCol[0]['objetos'][] = array('tipo'=>'table','referencia'=>'td001','tagRegistro'=>'turnos','columnas'=>$aTabCols,'muestraEncabezado'=>true,'muestraPie'=>true);
$aDlgRenglones[] = array('atributos'=>array('class'=>'tablaDir'),'columnas'=>$aDlgCol);
$aDat['DlgRenglones'] = $aDlgRenglones;



/*

$html = <<<EOT
<table id="dlg_td001_grupos">
	<thead>
		<tr>
		<th>id Turno</th>
		<th>Nombre</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		<td><input type="text" class="inputs" name="turno_id[]" id="turno_id_##indice##" value="##turno_id##" /></td>
		<td><input type="text" class="inputs" name="turno_nombre[]" id="turno_nombre_##indice##" value="##turno_nombre##" /></td>
		</tr>
	</tbody>
</table>
EOT;


$aDlgCol = array();
$aDlgCol[0]['atributos'] = array('colspan'=>'2');
$aDlgCol[0]['objetos'][] = array('tipo'=>'html','referencia'=>$html);
$aDlgRenglones[] = array('atributos'=>array(),'columnas'=>$aDlgCol);

$aDat['DlgRenglones'] = $aDlgRenglones;
*/

			
echo simplePlantilla1($aDat);



?>