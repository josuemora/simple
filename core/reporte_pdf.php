<?php


require('../../fpdf181/fpdf.php');

class PDF extends FPDF
{
protected $col = 0; // Columna actual
protected $y0;      // Ordenada de comienzo de la columna
protected $anchoBloque = array();//Ordenada para determinar el ancho del bloque
protected $totalcol = 1;
	

function SetCol($col)
{
	// Establecer la posición de una columna dada
	$this->col = $col;
	//$x = 12+$col*$this->anchoBloque;
	$x = $this->anchoBloque[$col];
	$this->SetLeftMargin($x);
	$this->SetX($x);
}

function AcceptPageBreak()
{
	global $aRep;
	// Método que acepta o no el salto automático de página
	if($this->col<$aRep['GEN']['bloques']-1)
	{
		// Ir a la siguiente columna
		$this->SetCol($this->col+1);
		// Establecer la ordenada al principio
		$this->SetY($this->y0);
		// Seguir en esta página
		return false;
	}
	else
	{
		// Volver a la primera columna
		$this->SetCol(0);
		// Salto de página
		return true;
	}
}
	

//Encabezado de Tabla
function EncabezadoTabla($encfont){
	global $aRep;
	// Cabecera
	$aheight = array();
	for($i=0;$i<$aRep['GEN']['bloques'];$i++){
		$this->anchoBloque[$i] = $this->GetX(); 
		foreach($aRep['ENC'] as $key=>$col){
			$cell = $col['cellenc'];
			if(array_key_exists('font', $cell)){
				$this->SetFont($cell['font'][0],$cell['font'][1],$cell['font'][2]);
			}else{
				$this->SetFont($encfont[0],$encfont[1],$encfont[2]);
			}
			//$this->Cell($cell['w'],$cell['h'],$cell['txt'],$cell['border'],$cell['ln'],$cell['align'],$cell['fill']);
			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$this->MultiCell($cell['w'],$cell['h'],$cell['txt'],$cell['border'],$cell['align'],$cell['fill']);
			$aheight[] = $this->GetY();
			$current_x+=$cell['w'];
			$this->SetXY($current_x, $current_y); 
		}
		$this->SetX($this->GetX()+$aRep['GEN']['sepbloqmm']);
	};
	$this->Ln();
	if($this->GetY()< max($aheight)){
		$this->SetY(max($aheight)+2);
	};
	
}
function PintaDatos(){
	global $aRep;
	$datfont = $aRep['GEN']['datfont'];
	foreach($aRep['DAT'] as $row)
	{
		foreach($row as $key=>$col){
			$acol = array();
			if(!is_array($col)){
				$acol['txt'] = $col;
			}else{
				$acol = $col;
			}
			$w = $aRep['ENC'][$key]['cellenc']['w'];
			$cd = $aRep['ENC'][$key]['celldat'];
			if(array_key_exists('h', $acol)){
				$cd['h'] = $acol['h'];
			};
			if(array_key_exists('font', $acol)){
				$this->SetFont($acol['font'][0],$acol['font'][1],$acol['font'][2]);
			}elseif(array_key_exists('font', $cd)){
				$this->SetFont($cd['font'][0],$cd['font'][1],$cd['font'][2]);
			}else{
				$this->SetFont($datfont[0],$datfont[1],$datfont[2]);	
			}
			$this->Cell($w,$cd['h'],$acol['txt'],$cd['border'],$cd['ln'],$cd['align'],$cd['fill']);
			//$this->Cell($w,6,$col,1);
		};
		$this->Ln();
	}
	
}
function Header()
{
	// Cabacera
	global $aRep;

	$titcell = $aRep['GEN']['titulo'];
	$title = $titcell['txt'];
	$titfont = $aRep['GEN']['titfont'];
	$encfont = $aRep['GEN']['encfont'];
	$this->SetFont($titfont[0],$titfont[1],$titfont[2]);
	$w = $this->GetStringWidth($title)+6;
	$this->SetX((210-$w)/2);
	//$this->SetDrawColor(0,80,180);
	//$this->SetFillColor(230,230,0);
	//$this->SetTextColor(220,50,50);
	//$this->SetLineWidth(1);
	$this->Cell($w,$titcell['h'],$title,$titcell['border'],$titcell['ln'],$titcell['align'],$titcell['fill']);
	$this->Ln(2);
	//$this->SetFont('Arial','',14);
	$this->SetFont($encfont[0],$encfont[1],$encfont[2]);
	$this->EncabezadoTabla($encfont);
	
	// Guardar ordenada
	$this->y0 = $this->GetY();
}

function Footer()
{
	// Pie de página
	$this->SetLeftMargin(10);
	$this->SetX(0);
	$this->SetY(-15);
	$this->SetFont('Arial','I',8);
	$this->SetTextColor(128);
	$this->Cell(0,10,utf8_decode('Fecha y Hora de impresión: '.date('d/m/Y H:i:s')),0,0,'L');
	$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
}



}//class

$pdf = new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$datfont = $aRep['GEN']['datfont'];
$pdf->SetFont($datfont[0],$datfont[1],$datfont[2]);
$pdf->AddPage();
$pdf->PintaDatos();
$pdf->Output();

?>
