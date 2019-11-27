<?php

include("config/db_pdo.php");

$qry = "select distinct anio from regind_enc order by anio desc;";
if($recordset = $vinculo->query($qry)){
	echo 'Año: <select id="PrincipalesAnio_'.$aDat['modulo'].'" onchange="activar_principales()">';
	echo '<option value="" selected="selected">&Uacute;ltimo Año</option>';
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		echo '<option value="'.$row['anio'].'">'.$row['anio'].'</option>';
	}
	echo '</select>';
	$recordset->closeCursor();
	
	$aMeses = array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	echo 'Mes: <select id="PrincipalesMes_'.$aDat['modulo'].'" onchange="activar_principales()">';
	echo '<option value="0" selected="selected">&Uacute;ltimo Mes</option>';
	for($iMes=1;$iMes<13;$iMes++){
		echo '<option value="'.$iMes.'">'.$aMeses[$iMes].'</option>';
	};
	echo '</select>';

	echo '<button onclick="generaPDFprincipales();" style="margin-left:20px;"><i class="fas fa-file-pdf"></i></button>';

};

echo '<div id="accordion_'.$aDat['modulo'].'" class="accordion">';

$qry = "select me.* from marco_enc me  where me.tablero='{$aDat['modulo']}'";
if($recordsetM = $vinculo->query($qry)){
	while ($rowM = $recordsetM->fetch(PDO::FETCH_ASSOC)  ) {
		$m_id = $rowM['id'];

		echo "\n".'<div class="marco" id="marco_titulo_'.$m_id.'"><h3>'.$rowM['comentario'].'</h3><div>'."\n";

		$qry = "select md.* from marco_det md where marco_enc_id=$m_id";

		$g = 0;
		$ren = 0;
		if($recordset = $vinculo->query($qry)){
			echo "\n".'<table cellpadding="5" cellspacing="8" border="1" id="marco_'.$m_id.'">'."\n";
			while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
				$ren += 1;
				echo "<tr id='marco_{$m_id}_{$ren}'>";
				foreach($row as $key=>$val){
					if(substr($key,0,3)=='ind'){
						$g = $g + 1;
						echo "<td onclick='irAresumen(\"{$val}\")'><div class='cuadroPrincipales'>\n";
						if(intval($val)>0){
							echo "<div id=\"g_{$g}_lbl_{$val}_{$m_id}\" class=\"lblPrincipales\"></div>\n";
							echo "<canvas id=\"g_{$g}_ind_{$val}_{$m_id}\" class=\"graficoPrincipales\"></canvas>\n";
							echo "<div style=\"width:100%;\">\n";
							echo "<div id=\"g_{$g}_fec_{$val}_{$m_id}\" class=\"FecIndPrincipales\"></div>\n";
							echo "<div id=\"g_{$g}_pt_{$val}_{$m_id}\" class=\"TxtNumIndPrincipales\">0</div>\n";
							echo "<div id=\"g_{$g}_uni_{$val}_{$m_id}\" class=\"UniIndPrincipales\"></div>\n";
							echo "<div id=\"g_{$g}_meta_{$val}_{$m_id}\" class=\"MetaIndPrincipales\"></div>\n";
							echo "<div id=\"g_{$g}_leyenda_{$val}_{$m_id}\" class=\"LeyendaIndPrincipales\"></div>\n";
							echo "</div>\n";
						};
						echo "</div></td>\n";
					};
				};
				echo "</tr>\n";
			}
			$recordset->closeCursor();
			echo '</table>'."\n";
		}

		echo '</div></div>';

	};
	$recordsetM->closeCursor();
	
};
echo '</div>';//cierra accordion

?>
