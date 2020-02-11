<?php
	//variables para reportes pdf
	$dat = array();
	$enc = array();
	$tmp = array();
	$gen = array();
	
	$fechai = isset($_REQUEST['fechai']) ? $_REQUEST['fechai'] : '2020-01-01';
	$fechaf = isset($_REQUEST['fechaf']) ? $_REQUEST['fechaf'] : '2020-01-31';

	//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
	$gen['titulo'] = Array('w'=>0,'h'=>9,'txt'=>"Reporte de Ventas por Cliente del $fechai al $fechaf",'border'=>'0','ln'=>1,'align'=>'C','fill'=>false);
	$gen['bloques'] = 2;
	$gen['sepbloqmm'] = 1;
	$gen['titfont'] = Array('Arial','B',12);
	$gen['encfont'] = Array('Arial','IB',8);
	$gen['datfont'] = Array('Arial','',8);
	$enc[] = array(
		'cellenc'=>Array('w'=>9,'h'=>6,'txt'=>'No.','border'=>'0','ln'=>0,'align'=>'C','fill'=>false),
		'celldat'=>Array('h'=>4,'border'=>'0','ln'=>0,'align'=>'C','fill'=>false)
		);
	$enc[] = array(
		'cellenc'=>Array('w'=>46,'h'=>6,'txt'=>'Nombre','border'=>'0','ln'=>0,'align'=>'L','fill'=>false),
		'celldat'=>Array('h'=>4,'border'=>'0','ln'=>0,'align'=>'L','fill'=>false,'font'=>Array('Arial','',7))
		);

	$enc[] = array(
		'cellenc'=>Array('w'=>14,'h'=>6,'txt'=>'Piezas','border'=>'0','ln'=>0,'align'=>'R','fill'=>false),
		'celldat'=>Array('h'=>4,'border'=>'0','ln'=>0,'align'=>'R','fill'=>false)
		);


	$enc[] = array(
		'cellenc'=>Array('w'=>14,'h'=>6,'txt'=>'Kilos','border'=>'0','ln'=>0,'align'=>'R','fill'=>false),
		'celldat'=>Array('h'=>4,'border'=>'0','ln'=>0,'align'=>'R','fill'=>false)
		);

	$enc[] = array(
		'cellenc'=>Array('w'=>17,'h'=>6,'txt'=>'Venta','border'=>'0','ln'=>0,'align'=>'R','fill'=>false),
		'celldat'=>Array('h'=>4,'border'=>'0','ln'=>0,'align'=>'R','fill'=>false)
		);


		$total = 0;
		$tpiezas = 0;
		$tkilos = 0;
		for($i=1;$i<1000;$i++){
			$cliente    = "000$i";
			$nombre		= "Juan N. $i";
			$importe 	= floatval($i*1394.22);
			$kilos		= floatval($i*33.234);
			$piezas		= floatval($i+12940.93);
			
			$cimporte =  number_format($importe,2,".",",");
			$ckilos =  number_format($kilos,3,".",",");
			$cpiezas =  number_format($piezas,2,".",",");
			

			$dcols = array();
			$dcols[] = $cliente;
			$dcols[] = utf8_decode(substr($nombre,0,25));
			$dcols[] = $cpiezas;
			$dcols[] = $ckilos;
			$dcols[] = $cimporte;
			$dat[] = $dcols; 

			$total += $importe;
			$tpiezas += $piezas;
			$tkilos += $kilos;

		};

			$ctpiezas = number_format($tpiezas,2,".",",");
			$ctkilos = number_format($tkilos,3,".",",");
			$ctotal = number_format($total,2,".",",");
			



		//PDF
		$dcols = array();
		$dcols[] = "";
		$dcols[] = array('txt'=>"Totales",'h'=>18,'font'=>Array('Arial','IB',11));
		$dcols[] = array('txt'=>$ctpiezas,'h'=>18,'font'=>Array('Arial','B',7));
		$dcols[] = array('txt'=>$ctkilos,'h'=>18,'font'=>Array('Arial','B',7));
		$dcols[] = array('txt'=>$ctotal,'h'=>18,'font'=>Array('Arial','B',7));
		$dat[] = $dcols; 


$aRep = array('ENC'=>$enc,'DAT'=>$dat,'GEN'=>$gen);

include('../core/reporte_pdf.php');
?>