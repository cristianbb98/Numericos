<html>
<head>
  <title> TRABAJO COMPUTACIONAL</title>

</head>
  <link rel="stylesheet" href="css/styles.css">
  <meta charset="utf-8"/>
  
<body class = "body">
<section>
	<div>
		<table>
			<tr>
				<div class = "imagen"></div>
				<div class = "titulo">
					<b>ESCUELA POLITÉCNICA NACIONAL<br>
					FACULTAD DE INGENIERÍA DE SISTEMAS<br>
					INGENIERÍA DE SISTEMAS INFORMÁTICOS Y DE COMPUTACIÓN</b><br>
				</div>
		</table>
		<table align="center">
			</tr>
			<tr align = "center" >
				<div align = "center" class = "encabezado"><b> TRABAJO COMPUTACIONAL</b></div>
			</tr>
		</table>
    </div>

	<div class = "input">
		<form action="" method="POST" name="">
			<div>
				<table align = "center" cellspacing = "80" >
					<td>
						<div><fieldset align = "center" class = "h4"><legend> INGRESO DE DATOS </legend>
							<table align = "center" cellpadding = "20" border = "10" bordercolor = "white">
								<tr class = "h3">
									<td colspan = "3">
										Ingrese la estimativa inicial de los valores del vector Z:
									</td>
								</tr>
								<tr class = "h3">
									<td align = "center">
										Alfa = <input type = "float" name = "txt_alfa" value = "<?php if(isset($_POST['txt_alfa'])){echo $_POST['txt_alfa'];} else echo '7.5e-7';?>"/>
									</td>
									<td align = "center">
										Delta = <input type = "float" name = "txt_delta" value = "<?php if(isset($_POST['txt_delta'])){echo $_POST['txt_delta'];} else echo '850';?>"/>
									</td>
									<td align = "center">
										C = <input type = "float" name = "txt_c" value = "<?php if(isset($_POST['txt_c'])){echo $_POST['txt_c'];} else echo '0.7';?>"/>
									</td>
								</tr>
								<tr class = h3>
									<td colspan = "3">
										Seleccione el método para acelerar la convergencia:
									</td>
								</tr>
								<tr class = "h3">
									<td colspan = "3" align = center>
										<input type = "radio" name= "metodo"
										<?php if (isset($metodo) && $metodo=="0") echo "checked" ?>
										value = "0" checked> Método de Levenberg
										<input type = "radio" name= "metodo"
										<?php if (isset($metodo) && $metodo=="1") echo "checked" ?>
										value = "1"> Método de Levenberg-Marquardt
									</td>
								</tr>
								<tr>
									<td class = "h3" align = center colspan = "3">
										<input type="submit" name="btn_calcular" value="Calcular" class = "button" />
									</td>
								</tr>
							</table>
						</div></fieldset>
					</td>
					<td>
						<div class "input" align = "center" class="h4">
							<?php
								$y = valoresInicialesConteo();
								crearTabla(valoresInicialesCanal(), $y , conteoNormalizado($y, yMax()));
							?>
								<br>
								<table align = "center" border = "3" bordercolor = "white" class="h4" cellspacing="2" cellpadding = "4">
									<tr>
										<td align = "center" >
										Xo
										</td>
										<td align = "center">
										Ymax
										</td>
									</tr>
									<tr>
										<td>
										4119.07
										</td>
										<td>
										<?php
											echo yMax();
										?>
										</td>
									</tr>
								</table>




						</div>
					</td>
				</table>
			</div>
			<div class="grafica"><fieldset align = center>
				<table align = "center">
					<tr><td><div align = "center"><fieldset align = center>
						<?php

            function imprimirMatriz333($matriz){
              echo "<center><table>";
            for($i=0;$i<sizeof($matriz);$i++){
                echo "
                    <tr>
                      <th align=center width=40 style=border:1px solid black>".$matriz[$i][0]."</th>
                      <th align=center width=40 style=border:1px solid black>".$matriz[$i][1]."</th>
                      <th align=center width=40 style=border:1px solid black>".$matriz[$i][2]."</th>
                    </tr>";
            }
            echo "</table></center>";
            }

							if(isset($_POST['btn_calcular'])){
								//PASO 1: ||		||
								//estimativa inicial
								$alfa = $_POST['txt_alfa'];
								$delta = $_POST['txt_delta'];
								$c = $_POST['txt_c'];

								$metodo = $_POST['metodo'];
								$k = 0;
								$lambda = 1;
								$z = array($alfa, $delta, $c);
								$aux = 0;
								$x0 = 4119.07;
								$yMax = yMax();

								//canal
								$x = valoresInicialesCanal();
								//conteo
								$y = valoresInicialesConteo();
								$puntosY = $y;
								$yNormalizado = conteoNormalizado($y, $yMax);

								$F = vectorF($x0, $x, $z, $yNormalizado);

                for ($i=0; $i < count($F) ; $i++) {
                  for ($j=0; $j < count($F[0]) ; $j++) {
                    echo $F[$i][$j];
                  }
                  echo "<br>";
                }
                $S = calcularFuncional($F);
                for ($i=0; $i < count($F) ; $i++) {
                  for ($j=0; $j < count($F[0]) ; $j++) {
                    echo $F[$i][$j];
                  }
                  echo "<br>";
                }
								$valoresVectorZ[0][0] = 'N° Iteracion';
								$valoresVectorZ[0][1] = 'Alfa';
								$valoresVectorZ[0][2] = 'Delta';
								$valoresVectorZ[0][3] = 'c';
								$valoresVectorZ[0][4] = 'Funcional';
								while(true){

									$S_anterior = $S;
									//Calculo matriz Jacobiana
									$J = matrizJacobiana($x, $x0, $z, $yNormalizado);
                  echo "<br>";
                  for ($i=0; $i < count($J) ; $i++) {
                    for ($j=0; $j < count($J[0]) ; $j++) {
                      echo $J[$i][$j]."&nbsp";
                    }
                    echo "<br>";
                  }
                  echo "<br>";
									$JTranpuesta = matrizTranspuesta($J, 23, 3);

									//Metodos para acelerar la convergencia
									if($metodo == 0){ //Levenberg
										$a = sumarMatrices (multiplicarMatrices($JTranpuesta, 3, 23, $J, 23, 3), generarMatrizDiagonalLevenberg(3, $lambda), 3, 3);
									}else{ //Marquardt
										$matrizMult = multiplicarMatrices($JTranpuesta, 3, 23, $J, 23, 3);
										$a = sumarMatrices ($matrizMult, generarMatrizDiagonalMarquadt($matrizMult, 3, $lambda), 3, 3);
									}

									//imprimirMatriz($a, 3, 3, 'matriz A');
									$b = cambiarSignoMatriz(multiplicarMatrices($JTranpuesta, 3, 23, $F, 23, 1));
									//imprimirMatriz($b, 3, 1, 'matriz B');
									$delta_z = eliminacionGaussiana($a, $b, 3);

									$z_anterior = $z;
									for($i = 0; $i < 3; $i++){
										$z[$i] += $delta_z[$i];
									}
									$nuevoY = conteo($x0, $x, $z);
									$error = calcularError($y, $nuevoY);
									$vectorResultados[$k] = matrizResultados($x, $puntosY, $yNormalizado, $nuevoY, $error);

									$F = vectorF($x0, $x, $z, $yNormalizado);
									$S = calcularFuncional($F);
									if($S[0][0] <= ($S_anterior[0][0] / 2)){
										$lambda = $lambda / 2;
									}else{
										$lambda = 2 * $lambda;
									}
									for($i = 0; $i < 3; $i++){
										if(abs($z[$i] - $z_anterior[$i]) < pow(10, -8))
											$aux++;
									}
									$valoresVectorZ[$k+1][0] = $k;
									$valoresVectorZ[$k+1][1] = $z[0];
									$valoresVectorZ[$k+1][2] = $z[1];
									$valoresVectorZ[$k+1][3] = $z[2];
									$valoresVectorZ[$k+1][4] = $S[0][0];
									if($aux == 3)
										break;
									else
										$aux = 0;
									$k++;
									$y = $nuevoY;
								}

								impresionResultados($x0, $z, $S);
								generarTablas($valoresVectorZ, $vectorResultados, $k);

							}

							function respuesta($x0, $z){
								//$z =  redondearValores($z);
								$variables = array('$alfa', '$res', '$x0', '$c');
								$valores = array($z[0], $x0 - $z[1], $x0, $z[2]);
								return str_replace($variables, $valores,'(1 / (1 + ($alfa) * pow((x - $x0), 2)))+($c / (1 + ($alfa )* pow((x - $res), 2)))');
							}

							function funcionGrafica($x0, $z){
								$variables = array('$alfa', '$res', '$x0', '$c');
								$valores = array($z[0], $x0 - $z[1], $x0, $z[2]);
								return str_replace($variables, $valores,'(1 / (1 + ($alfa) * pow((x - $x0), 2)))+($c / (1 + ($alfa )* pow((x - $res), 2)))');
							}

							function redondearValores($vector){
								for($i = 0; $i < sizeof($vector); $i++){
									$vector[$i] = round($vector[$i],2);
								}
								return $vector;
							}

							function calcularError($y, $y1){
								for($i = 0; $i < sizeof($y); $i++){
									$error[$i] = ( abs($y[$i] - $y1[$i]) / $y[$i] );
								}
								return $error;
							}


							function valoresInicialesCanal(){
								$x[0] = 1400;
								$x[1] = 1600;
								$x[2] = 1800;
								$x[3] = 2000;
								$x[4] = 2200;
								$x[5] = 2400;
								$x[6] = 2600;
								$x[7] = 2800;
								$x[8] = 3000;
								$x[9] = 3200;
								$x[10] = 3400;
								$x[11] = 3600;
								$x[12] = 3800;
								$x[13] = 4000;
								$x[14] = 4200;
								$x[15] = 4400;
								$x[16] = 4600;
								$x[17] = 4800;
								$x[18] = 5000;
								$x[19] = 5200;
								$x[20] = 5400;
								$x[21] = 5600;
								$x[22] = 5800;
								return $x;
							}

							function valoresInicialesConteo(){
								$y[0] = 12.15;
								$y[1] = 37.7;
								$y[2] = 76.76;
								$y[3] = 128.6;
								$y[4] = 193.21;
								$y[5] = 284.87;
								$y[6] = 400;
								$y[7] = 526;
								$y[8] = 650;
								$y[9] = 763.43;
								$y[10] = 878.37;
								$y[11] = 974.4;
								$y[12] = 1050;
								$y[13] = 1100;
								$y[14] = 1112.02;
								$y[15] = 1073.71;
								$y[16] = 1000;
								$y[17] = 900;
								$y[18] = 767.72;
								$y[19] = 623.74;
								$y[20] = 491.3;
								$y[21] = 341.96;
								$y[22] = 221.38;

								return $y;
							}

							function yMax(){
									return 1118.82;
							}

							function conteo($x0, $x, $z){
								for($i = 0; $i < 23; $i++){
									$y[$i] = (1 / (1 + $z[0] * pow(($x[$i] - $x0), 2)))+($z[2] / (1 + $z[0] * pow(($x[$i] - $x0 - $z[1]), 2)));
								}
								return $y;
							}

							function valorConteo($x0, $x, $alfa, $delta, $c){
								return (1 / (1 + $alfa * pow(($x - $x0), 2)))+($c / (1 + $alfa * pow(($x - $x0 - $delta), 2)));
							}

							function conteoNormalizado($y, $yMax){

								for($i = 0; $i < 23; $i++){
									$vector[$i] = $y[$i] / $yMax;
								}
								return $vector;
							}

							function vectorF($x0, $x, $z, $yNormalizado){
								for($i = 0; $i < 23; $i++){
									$F[$i][0] = valorConteo($x0, $x[$i], $z[0], $z[1], $z[2]) - $yNormalizado[$i];
								}
								return $F;
							}

							function calcularFuncional($F){
								return multiplicarMatrices(matrizTranspuesta($F, 23, 1), 1, 23, $F, 23, 1);
							}

							function funcionY(){
								return '(1 / (1 + $alfa * pow(($x - $x0), 2)))+($c / (1 + $alfa * pow(($x - $x0 - $delta), 2)))';
							}

							function matrizJacobiana($x , $x0, $z, $yNormalizado){
								$funcion = funcionY();
								for($i = 0; $i < 23; $i++){
									$jacobiana[$i][0] = calcularDerivadaParcial($funcion, $x[$i], $x0, $z[0], '$alfa', $z[1], $z[2], $yNormalizado[$i]);
									$jacobiana[$i][1] = calcularDerivadaParcial($funcion, $x[$i], $x0, $z[1], $z[0], '$delta', $z[2], $yNormalizado[$i]);
									$jacobiana[$i][2] = calcularDerivadaParcial($funcion, $x[$i], $x0, $z[2], $z[0], $z[1], '$c', $yNormalizado[$i]);
								}
								return $jacobiana;
							}

							function calcularDerivadaParcial($funcion, $x, $x0, $t, $alfa, $delta, $c, $yNormalizado){
								$delta_t = 0.1;
								$cont = 0;
								$derivada = 0;
								if($alfa == '$alfa')
									$variable = '$alfa';
								else if($delta == '$delta')
									$variable = '$delta';
								else if($c == '$c')
									$variable = '$c';
								do{
									$derivada_anterior = $derivada;
									eval('$fun1 = '.str_replace($variable, '($t + $delta_t)', $funcion).';' );
									eval('$fun2 = '.str_replace($variable, '($t - $delta_t)', $funcion).';' );
									$derivada=($fun1 - $fun2)/(2*$delta_t);
									$delta_t = $delta_t/2;
									$cont++;
								}while(abs($derivada_anterior-$derivada)>pow(10,-8));
								return $derivada;
							}

							function matrizTranspuesta($matriz, $n, $m){
								for($i = 0; $i < $n; $i++){
									for($j = 0; $j < $m ; $j++){
										$ma[$j][$i] = $matriz[$i][$j];
									}
								}
								return $ma;
							}

							function multiplicarMatrices($A, $nA, $mA, $B, $nB, $mB){
								for($i = 0; $i < $nA; $i++){
									for($j = 0; $j < $mB; $j++){
										$C[$i][$j] = 0;
										for($k = 0; $k < $mA; $k++){
											$C[$i][$j] = $C[$i][$j] + $A[$i][$k] * $B[$k][$j];
										}
									}
								}
								return $C;
							}

							function sumarMatrices($A, $B, $n, $m){
								for($i = 0; $i < $n; $i++){
									for($j = 0; $j < $m; $j++){
										$C[$i][$j] = $A[$i][$j]+ $B[$i][$j];
									}
								}
								return $C;
							}

							function cambiarSignoMatriz($matriz){
								for($i = 0; $i < sizeof($matriz) ; $i++){
									$matriz[$i][0] = (-1)*$matriz[$i][0];
								}
								return $matriz;
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
							function generarMatrizDiagonalMarquadt($matriz, $n, $cte){
								for($i = 0; $i < $n; $i++){
									for($j = 0; $j < $n; $j++){
										if($i == $j)
											$diagonal[$i][$j] = $matriz[$i][$j] * $cte;
										else
											$diagonal[$i][$j] = 0;
									}
								}
								return $diagonal;
							}


							function eliminacionGaussiana($a, $b, $n){
								$k = 0;
								while($k < $n - 1){
									for($i = $k + 1; $i < $n; $i++){
										$m = ($a[$i][$k] / $a[$k][$k]);
										$a[$i][$k] = 0;
										for($j = $k+1; $j < $n ; $j++){
											$a[$i][$j] = $a[$i][$j] - $m * $a[$k][$j];
										}
										$b[$i][0] = $b[$i][0] - $m * $b[$k][0];
									}
									$k++;
								}
								for($k = $n-1; $k >= 0; $k--){
									$sumatorio = 0;
									for($j = $k + 1; $j <= $n-1; $j++){
										$sumatorio = $sumatorio + $a[$k][$j] * $x[$j];
									}
									$x[$k] = (1 / $a[$k][$k]) * ($b[$k][0] - $sumatorio);
								}
								return $x;
							}

							function matrizResultados($x, $y, $yNormalizado, $yNuevo, $error){

								$m[0][0] = 'i';
								$m[0][1] = 'Xi (Canal)';
								$m[0][2] = 'Yi (Conteo)';
								$m[0][3] = 'Yi Normalizado (Conteo Normalizado)';
								$m[0][4] = 'Yi Nuevo';
								$m[0][5] = 'Diferencia ( % )';
								for($i = 0; $i < 23; $i++){
									$m[$i+1][0] = $i;
									$m[$i+1][1] = $x[$i];
									$m[$i+1][2] = $y[$i];
									$m[$i+1][3] = $yNormalizado[$i];
									$m[$i+1][4] = $yNuevo[$i];
									$m[$i+1][5] = $error[$i];
								}
								return $m;
							}

							function crearTabla($x, $y, $yNormalizado){

								echo '<table  cellspacing="0" cellpadding="0" bordercolor = "white"  class="h4">';
								echo "<b align = center><font color=white>".'Tabla 1: Contenido obtenido a partir de un difractometro de rayos X'."</font></b><br>";
								echo '<br>';
								echo '<tr>';
										echo '<td align = "center" width="40" style="border:1px solid white">'.'i'.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid white">'.'Xi (Canal)'.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid white">'.'Yi (Conteo)'.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid white">'.'Yi Normalizado (Conteo Normalizado)'.'</td>';
								echo '</tr>';
								for($i = 0; $i < 23; $i++){
									echo '<tr>';
										echo '<td align = "center" width="40" style="border:1px solid white">'.$i.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid white">'.$x[$i].'</td>';
										echo '<td align = "center" width="100" style="border:1px solid white">'.$y[$i].'</td>';
										echo '<td align = "center" width="300" style="border:1px solid white">'.$yNormalizado[$i].'</td>';
									echo '</tr>';
								}
								echo '</table>';
								echo "<br>";
							}

							function impresionResultados($x0, $z, $S){
								$funcionAjuste = respuesta($x0, $z);
								echo '<br><br>';
								echo '<b><font color=white> RESULTADOS: </font></b><br><table class=h4 bordercolor="white" align = "center" cellpadding = "10" cellspacing="0" border = "3">';
								echo '<tr>';
								echo '<td align = "center" colspan = "3">
										Funcional = <input type = "float" value = '.$S[0][0].' readonly>
									</td>';
								echo '<tr>';
								echo '<tr>';
								echo '<td align = "center">
										Alfa = <input type = "float" value = '.$z[0].' readonly>
									</td>
									<td align = "center">
										Delta = <input type = "float" value = '.$z[1].' readonly>
									</td>
									<td align = "center">
										C = <input type = "float" value = '.$z[2].' readonly>
									</td>';
								echo '</tr>';
								echo '<tr><td colspan = "3">';
								echo '<b align= center> Ecuacion de ajuste de la curva:<br> </b><textarea name = "txt_funcion" rows = "2" cols = "100" readonly> y(x) = '. $funcionAjuste.'</textarea>';
								echo '</td></tr>';
								echo '</tr>';
								echo '<tr>';

								echo '</td></tr>';

								echo '</table>';
								echo '<br><br>';
								echo '<div class="h4"> <fieldset align = "center"> <legend> GRÁFICA DE LA FUNCIÓN </legend>
								<img src = "graficarFuncion.php?funcion='.urlencode($funcionAjuste).'">
								</div></fieldset>';
							}

							function imprimirMatriz($matriz,$n,$m,$nombre){
								echo '<table  cellspacing="0" cellpadding="4" class="h4">';
								echo "<b align = center>".$nombre."</b><br>";
								echo '<br>';
								for($i = 0; $i < $n; $i++){
									echo '<tr>';
									for($j = 0; $j < $m; $j++){
										echo '<td align = "center" style="border:1px solid white">'.$matriz[$i][$j].'</td>';
									}
								}
								echo '</table>';
								echo "<br>";
							}

							function generarTablas($valoresVectorZ, $vectorResultados, $k){
								echo "<br><b align = center ><font size=5 color=white>".'Valores obtenidos en las iteraciones'."</font></b><br>";
								echo '<br>';
								imprimirMatriz($valoresVectorZ, $k, 5, "");
								$cont = 0;
								echo '<table cellspacing =10 cellspacing=10><tr>';
								echo "<br><b align = center ><font size=5 color=white>".'Comparacion de los resultados obtenidos'."</font></b><br>";
								echo '<br>';

								for($i = 0; $i < $k; $i++){
									if($cont < 3){
										echo '<td align=center>';
											echo '<br>';
											echo '<font size = 4 color=white>Para k = '. $i.'</font>';
											imprimirMatriz($vectorResultados[$i], 24, 6, "");
											echo '<br>';
										echo '</td>';
										$cont++;
									}else{
										$cont = 0;
										echo '</tr>';
										echo '<tr>';
									}
								}
							}

						?>
					</div></td>
					</tr>
				</table>
			</fieldset></div>
	</form>
</div>
</section>
</body>
</html>
