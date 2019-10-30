<!--seguridad-principales-acceso--><!--/seguridad-->

<div id="modulo-principales">
<?php
include("config/db_pdo.php");

$qry = "select distinct anio from metricos0.regind_enc order by anio desc;";
if($recordset = $vinculo->query($qry)){
	echo 'Año: <select id="PrincipalesAnio" onchange="activar_principales()">';
	echo '<option value="" selected="selected">&Uacute;ltimo Año</option>';
	while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
		echo '<option value="'.$row['anio'].'">'.$row['anio'].'</option>';
	}
	echo '</select>';
	$recordset->closeCursor();
	
	$aMeses = array('','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	echo 'Mes: <select id="PrincipalesMes" onchange="activar_principales()">';
	echo '<option value="0" selected="selected">&Uacute;ltimo Mes</option>';
	for($iMes=1;$iMes<13;$iMes++){
		echo '<option value="'.$iMes.'">'.$aMeses[$iMes].'</option>';
	};
	echo '</select>';


};

echo '<div id="accordion" class="accordion">';

$qry = "select me.* from metricos0.marco_enc me ";
if($recordsetM = $vinculo->query($qry)){
	while ($rowM = $recordsetM->fetch(PDO::FETCH_ASSOC)  ) {
		$m_id = $rowM['id'];

		echo "\n".'<div class="marco" ><h3>'.$rowM['comentario'].'</h3><div>'."\n";

		$qry = "select md.* from metricos0.marco_det md where marco_enc_id=$m_id";

		$g = 0;
		if($recordset = $vinculo->query($qry)){
			echo "\n".'<table cellpadding="5" cellspacing="8" border="1" id="marco_'.$m_id.'">'."\n";
			while ($row = $recordset->fetch(PDO::FETCH_ASSOC)  ) {
				echo "<tr>";
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
							echo "</div>\n";
						};
						echo "</div></td>\n";
					};
				};
				echo "<tr>\n";
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
</div><!--termina modulo-->
