<html>
<head>
  <title> TRABAJO COMPUTACIONAL</title>

</head>
  <link rel="stylesheet" href="css/styles.css">
  <meta charset="utf-8"/>
  <script src="https://d3js.org/d3.v3.min.js"></script>
  <script src="https://mauriciopoppe.github.io/function-plot/js/function-plot.js"></script>

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
						<div><fieldset align = "center"><legend> INGRESO DE DATOS </legend>
							<table align = "center" cellpadding = "20" border = "4">
								<tr class = "h3">
									<td colspan = "3">
										Ingrese la estimativa inicial de los valores del vector Z:
									</td>
								</tr>
								<tr>
									<td align = "center">
										Alfa: <input type = "float" name = "txt_alfa" value = "<?php if(isset($_POST['txt_alfa'])){echo $_POST['txt_alfa'];}?>"/>
									</td>
									<td align = "center">
										Delta: <input type = "float" name = "txt_delta" value = "<?php if(isset($_POST['txt_delta'])){echo $_POST['txt_delta'];}?>"/>
									</td>
									<td align = "center">
										C: <input type = "float" name = "txt_c" value = "<?php if(isset($_POST['txt_c'])){echo $_POST['txt_c'];}?>"/>
									</td>
								</tr>
								<tr class = h3>
									<td colspan = "3">
										Seleccione el acelerador de convergencia:
									</td>
								</tr>
								<tr>
									<td colspan = "3" align = center>
										<input type = "radio" name= "metodo"
										<?php if (isset($metodo) && $metodo=="0") echo "checked" ?>
										value = "0"> Método de Levenberg
										<input type = "radio" name= "metodo"
										<?php if (isset($metodo) && $metodo=="1") echo "checked" ?>
										value = "1"> Metodo de Marquard
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
						<div class "input" align = "center">


              <?php
								$y = valoresInicialesConteo();
								crearTabla(valoresInicialesCanal(), $y , conteoNormalizado($y, yMax()));
							?>
              
						</div>
					</td>
				</table>
			</div>
			<div class="grafica"><fieldset align = center>
				<table align = "center">
					<tr><td><div><fieldset align = center>
						<?php
							if(isset($_POST['btn_calcular'])){
								//PASO 1:
								//estimativa inicial
								$alfa = $_POST['txt_alfa'];
								$delta = $_POST['txt_delta'];
								$c = $_POST['txt_c'];

								$metodo = $_POST['metodo'];

								$k = 0;
								$lambda = 1;
								$z = array($alfa, $delta, $c);
								$aux = 0;
								$x0 = 4109.3;
								$yMax = yMax();
								//canal
								$x = valoresInicialesCanal();
								//conteo
								$y = valoresInicialesConteo();

								$yNormalizado = conteoNormalizado($y, $yMax);

								$F = vectorF($x0, $x, $yNormalizado, $z);
								$S = calcularFuncional($F);
								while(true){

									//PASO 2:
									$S_anterior = $S;
									//imprimirMatriz($S, 1,1,'funcional');
									//crearTabla($x, $y, $yNormalizado);
									//PASO 3:
									$J = matrizJacobiana($x, $x0, $z, $yNormalizado);
									//imprimirMatriz($J, 23, 3, 'jacobiana');
									$JTranpuesta = matrizTranspuesta($J, 23, 3);
									//imprimirMatriz($JTranpuesta, 3, 23, 'jacobiana tranpuesta');
									//PASO 4:
									if($metodo == 0){
										$a = sumarMatrices (multiplicarMatrices($JTranpuesta, 3, 23, $J, 23, 3), generarMatrizDiagonalLevenberg(3, $lambda), 3, 3);
									}else{
										$matrizMult = multiplicarMatrices($JTranpuesta, 3, 23, $J, 23, 3);
										$a = sumarMatrices ($matrizMult, generarMatrizDiagonalMarquad($matrizMult, 3, $lambda), 3, 3);
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
									echo '<br>';
									echo 'Para k = '. $k.'<br>';
											$puntosY = valoresInicialesConteo();
											crearTabla2(valoresInicialesCanal(), $puntosY , conteoNormalizado($puntosY, yMax()), calcularError($y, $nuevoY));
									echo '<br>';
									$F = vectorF($x0, $x, $y, $yNormalizado);
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
									if($aux == 3)
										break;
									else
										$aux = 0;
									$k++;
									$y = $nuevoY;
								}
								//imprimirVector($z,3,'vector z');
								//imprimirMatriz($S, 1,1,'funcional');

								$funcionAjuste = respuesta($x0, $z);

								echo '<br><br>';
								echo 'TABLA DE RESULTADOS: <br><table align = "center" cellpadding = "10" border = "4">';
								echo '<tr>';
								echo '<td align = "center" colspan = "3">
										Funcional: <input type = "float" value = '.$S[0][0].' readonly>
									</td>';
								echo '<tr>';
								echo '<tr>';
								echo '<td align = "center">
										Alfa: <input type = "float" value = '.$z[0].' readonly>
									</td>
									<td align = "center">
										Delta: <input type = "float" value = '.$z[1].' readonly>
									</td>
									<td align = "center">
										C: <input type = "float" value = '.$z[2].' readonly>
									</td>';
								echo '</tr>';
								echo '<tr><td colspan = "3">';
								echo 'Ecuacion de ajuste de la curva: <textarea name = "txt_funcion" rows = "1" cols = "100" readonly>'.$funcionAjuste.'</textarea>';
								echo '</td></tr>';
								echo '</tr>';
								echo '<tr>';

								echo '</td></tr>';

								echo '</table>';
								echo '<br><br>';
								echo '<div width="775"> <fieldset align = center> <legend> GRÁFICA DE LA FUNCIÓN </legend>
									<div  id="myFunction"></div>
									<script  id="jsbin-source-css" type="text/css">div {
										float: left;
										}
										#myFunction {
											padding: 25px;
											width: 250px;
											height: 250px;
										}
									</script>
									<script id="jsbin-source-javascript" type="text/javascript">var parameters = {
										target: '.'#myFunction'.',
										data: [{
											fn: '.funcionGrafica($x0, $z).',
											color: red
										}
										],
										grid: true,
										yAxis: {domain: [-10, 10]},
										xAxis: {domain: [-10,10]}
									};
									functionPlot(parameters);
									</script>
								</div></fieldset>';

							}

							function respuesta($x0, $z){
								$z =  redondearValores($z);
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

							function vectorF($x0, $x, $yNormalizado, $z){
								for($i = 0; $i < 23; $i++){
									$F[$i][0] = valorConteo($x0, $x[$i], $z[0], $z[1], $z[2]) - $yNormalizado[$i];
								}
								return $F;
							}

							function calcularFuncional($F){
								return multiplicarMatrices(matrizTranspuesta($F, 23, 1), 1, 23, $F, 23, 1);
							}

							function funcionY(){
								return 'pow(((1 / (1 + $alfa * pow(($x - $x0), 2)))+($c / (1 + $alfa * pow(($x - $x0 - $delta), 2))) - $yNormalizado), 2)';
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

							function imprimirMatriz($matriz,$n,$m,$nombre){
								echo '<table  cellspacing="0" cellpadding="0">';
								echo "<b align = center>".$nombre."</b><br>";
								echo '<br>';
								for($i = 0; $i < $n; $i++){
									echo '<tr>';
									for($j = 0; $j < $m; $j++){
										echo '<td align = "center" width="40" style="border:1px solid black">'.$matriz[$i][$j].'</td>';
									}
								}
								echo '</table>';
								echo "<br>";
							}

							function imprimirVector($vector,$n,$nombre){
								echo '<table cellspacing="0" cellpadding="0">';
								echo "<b>".$nombre."</b><br>";
								echo '<br>';
								for($i=0; $i<$n; $i++){
									echo '<tr>';
									echo ('<td align="center" width="40" style="border:1px solid black">'.$vector[$i].'</td>');
									echo '</tr>';
								}
								echo '</table>';
								echo "<br>";
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
								}while($delta_t > pow(10, -8) );
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
							function generarMatrizDiagonalMarquad($matriz, $n, $cte){
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
										$m[$i][$k] = ($a[$i][$k] / $a[$k][$k]);
										$a[$i][$k] = 0;
										for($j = $k+1; $j < $n ; $j++){
											$a[$i][$j] = $a[$i][$j] - $m[$i][$k] * $a[$k][$j];
										}
										$b[$i][0] = $b[$i][0] - $m[$i][$k] * $b[$k][0];
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

							function crearTabla($x, $y, $yNormalizado){

								echo '<table  cellspacing="0" cellpadding="0">';
								echo "<b align = center>".'Tabla 1: Contenido obtenido a partir de un difractometro de rayos X'."</b><br>";
								echo '<br>';
								echo '<tr>';
										echo '<td align = "center" width="40" style="border:1px solid black">'.'i'.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.'Xi (Canal)'.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.'Yi (Conteo)'.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.'Yi Normalizado (Conteo Normalizado)'.'</td>';
								echo '</tr>';
								for($i = 0; $i < 23; $i++){
									echo '<tr>';
										echo '<td align = "center" width="40" style="border:1px solid black">'.$i.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.$x[$i].'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.$y[$i].'</td>';
										echo '<td align = "center" width="300" style="border:1px solid black">'.$yNormalizado[$i].'</td>';
									echo '</tr>';
								}
								echo '</table>';
								echo "<br>";
							}
							function crearTabla2($x, $y, $yNormalizado, $error){

								echo '<table  cellspacing="0" cellpadding="0">';
								echo "<b align = center>".'Tabla 2: Comparacion de los resultados obtenidos'."</b><br>";
								echo '<br>';
								echo '<tr>';
									echo '<td align = "center" width="40" style="border:1px solid black">'.'i'.'</td>';
									echo '<td align = "center" width="100" style="border:1px solid black">'.'Xi (Canal)'.'</td>';
									echo '<td align = "center" width="100" style="border:1px solid black">'.'Yi (Conteo)'.'</td>';
									echo '<td align = "center" width="300" style="border:1px solid black">'.'Yi Normalizado (Conteo Normalizado)'.'</td>';
									echo '<td align = "center" width="150" style="border:1px solid black">'.'Diferencia ( % )'.'</td>';
									echo '</tr>';
								for($i = 0; $i < 23; $i++){
									echo '<tr>';
										echo '<td align = "center" width="40" style="border:1px solid black">'.$i.'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.$x[$i].'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.$y[$i].'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.$yNormalizado[$i].'</td>';
										echo '<td align = "center" width="100" style="border:1px solid black">'.$error[$i].'</td>';
									echo '</tr>';
								}
								echo '</table>';
								echo "<br>";
							}

							function cambiarSignoMatriz($matriz){
								for($i = 0; $i < sizeof($matriz) ; $i++){
									$matriz[$i][0] = (-1)*$matriz[$i][0];
								}
								return $matriz;
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
