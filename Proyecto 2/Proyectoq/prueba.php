<?php
	$m1 = generarMatrizDiagonalLevenberg(3, 1);
	$m2 = generarMatrizDiagonalLevenberg(3, 2);
	
	$matriz = array($m1, $m2);
	for($i = 0; $i < sizeof($matriz); $i++){
		imprimirMatriz($matriz[$i],$n,3,"matriz");
	}
	
	
	
	function generarMatrizDiagonalLevenberg($n, $cte){
		for($i = 0; $i < $n; $i++){
			for($j = 0; $j < $n; $j++){
				if($i == $j)
					$matriz[$i][$j] = 1 * $cte;
				else
					$matriz[$i][$j] = 0;
			}
		}
		return $matriz;
	}
	function imprimirMatriz($matriz,$n,$m,$nombre){
		echo '<table  cellspacing="0" cellpadding="0" class="h4">';
		echo "<b align = center>".$nombre."</b><br>";
		echo '<br>';
		for($i = 0; $i < $n; $i++){
			echo '<tr>';
			for($j = 0; $j < $m; $j++){
				echo '<td align = "center" width="40" style="border:1px solid white">'.$matriz[$i][$j].'</td>';
			}
		}
		echo '</table>';
		echo "<br>";
	}
?>