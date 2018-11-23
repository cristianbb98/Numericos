
<html>
<head>
  <title>INTEGRACION POR CUADRATURA GAUSSIANA</title>

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
				<div align = "center" class = "encabezado"><b>INTEGRACIÓN POR CUADRATURA GAUSSIANA</b></div>
			</tr>
		</table>
    </div>
	
	<div class = "input">
		<form action="" method="POST" name="INTEGRACIÓN POR CURVATURA GAUSSIANA">
			<div> 
				<table align = "center" >
					<td width="800" > 
						<div><fieldset align = "center"><legend> INGRESO DE DATOS </legend>
							<table align = "center" cellpadding = "10" border = "4">
								<tr class = "h3">
									<td> 
										Ingrese la función a integrar:
									</td>
									<td align = "center"> 
										<input type = "text" name = "txt_funcion" value = "<?php if(isset($_POST['txt_funcion'])){echo $_POST['txt_funcion'];}?>"/>
										<?php if(isset($_POST['txt_funcion'])) $funcionJava = $_POST['txt_funcion']; ?>
									</td>
								</tr>
								<tr class = "h3">
									<td> 
										Ingrese el grado [n] del polinomio de Legendre:
									</td>
									<td> 
										<input type="number" name = "txt_n"   value = "<?php if(isset($_POST['txt_n'])){echo $_POST['txt_n'];}?>" step="1"/>
									</td>
								</tr>				
								<tr class = "h3">
							     	<td colspan = "2"> 
										Intervalo de integración: 
									</td>
								</tr>	
								<tr class = "h3">
									<td> 
										Límite inferior: 
									</td>
									<td> 
										<input type = "number" name = "txt_inferior" value = "<?php if(isset($_POST['txt_inferior'])){echo $_POST['txt_inferior'];}?>" step="1"/>
									</td>
								</tr>
								<tr class = "h3">
									<td> 
										Límite superior:
									</td>
									<td> 
										<input type = "number" name = "txt_superior" value = "<?php if(isset($_POST['txt_superior'])){echo $_POST['txt_superior'];}?>" step="1"/>
									</td>
								</tr>
								<tr class = "h3">
									<td> 
										Método para las raices:
									</td>
									<td> 
										<div align = "center"><select name = "opciones" style = "font-size: 15px">
										<option value = "1" name = "opc_bisecante"> Bisección-Secante </option>
										<option value = "2" name = "opc_binewton"> Bisección-Newton </option>
									</select> </div>
									</td>
								</tr>
								</table>
								<table  align = "center" cellpadding = "10">
								<tr class = "h3">
									<td class = "h2" colspan = "2"> 
											<input type="submit" name="btn_calcular" value="Calcular Integral" class = "button" />
									</td>
									
								</tr>
							</table>
						</div></fieldset>
					</td>
					<td width="775" >
						<div> <fieldset align = "center"> <legend> GRÁFICA DE LA FUNCIÓN </legend>
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
								target: '#myFunction',
								data: [{
									fn: '<?php echo $funcionJava?>',
									color: 'red'
								}
								],
								grid: true,
								yAxis: {domain: [-10, 10]},
								xAxis: {domain: [-10,10]}
							};
							functionPlot(parameters);
							</script>
						</div></fieldset>
					</td>
				</table>
			</div>
			<div class="grafica"><fieldset align = center><legend> RESULTADOS </legend><br>
				<table align = "center"> <td colspan = "2">
					<?php
						if(isset($_POST['btn_calcular'])){
							$intervalo_Inferior = $_POST['txt_inferior'];
							$intervalo_Superior = $_POST['txt_superior'];
							$n = $_POST['txt_n'];
							$funcion = $_POST['txt_funcion'];
							echo "<pre align='center'>";
							echo "<font size=5> \nFUNCIÓN = $funcion </font>"; 
							echo "</pre>";
						
							$funcion = str_replace('x', '$x',preg_replace_callback('/(\w+)["^"](\d+)/',//para validar "^"
							function ($m){
								return 'pow('.$m[1].','.$m[2].')';
							},$funcion));
							
							$polinomio = polinomioLegendre($n);
							$subintervalos = 2*$n;
							$a = -1;
							$b = 1;
							$valor = ($b-$a)/$subintervalos;
						
							$raices = busquedaCambioSigno($a, $a + $valor, $valor, $b, $polinomio);
					
							$integral[0][0] = "Integral por Cuadratura Gaussiana";
							$integral[0][1] = calcularIntegral($intervalo_Inferior, $intervalo_Superior, $n, $raices, $polinomio, $funcion);
							$integral[1][0] = "Integral por método de Trapecios";
							$integral[1][1] = metodoTrapecios($intervalo_Inferior, $intervalo_Superior, $n, $funcion);
							$integral[2][0] = "Integral por método de Simpson";
							$integral[2][1] = metodoSimpson($intervalo_Inferior, $intervalo_Superior, $n, $funcion);
							imprimirMatriz($integral,3,2);
							if($_POST['opciones'] == "1")
								$metodo = "1";
							else
								$metodo = "2";
						
							if(isset($_POST['btn_calcular'])){
								echo "<div align = 'center'>";
								echo "<a href='procedimientos.php ?funcion=".urlencode($funcion)."&inf=" . $intervalo_Inferior . "&sup=" . $intervalo_Superior . "&n=" . $n ."&metodo=".$metodo. "' class = 'button' target='_blank' onclick=\"window.open(this.href, this.target, width=800, height=800, menubar=no');return false;\"> Ver Procedimientos </a>";
								echo "<br>";
								echo "</div>";
							}	
						}
						
						function polinomioLegendre($n){
							if($n == 0){
								return '1';
							}else if($n == 1){
								return '$x';
							}else{
								return (1/$n).'*('.(2*$n-1).'*$x*'.polinomioLegendre($n-1).'-'.($n-1).'*'.polinomioLegendre($n-2).')';
							}
						}

						function calcularDerivada($polinomio,$t){
							$delta_t = 0.1;
							$cont = 0;
							$derivada = 0;
							do{
								$derivada_anterior = $derivada;
								eval('$fun1 = '.str_replace('$x', '($t + $delta_t)', $polinomio).';');
								eval('$fun2 = '.str_replace('$x', '($t - $delta_t)', $polinomio).';');
								$derivada=($fun1 - $fun2)/(2*$delta_t);
								$delta_t = $delta_t/2;
								$cont++;
							}while($delta_t > pow(10, -8));
							return $derivada;
						}

						function busquedaCambioSigno($m, $n, $valor,$b, $polinomio){
							$i = 0;
							$raices = array();
							$opcion = $_POST['opciones'];
							while($m <= $b){
								eval('$f_m = '.evaluarFuncion($polinomio, '$m').';');
								eval('$f_n = '.evaluarFuncion($polinomio, '$n').';');

								if($f_m*$f_n <= 0){
									if($opcion == "1"){
										$raices[$i] = metodoSecanteBiseccion($m, $n, $polinomio); //Bisección-Secante
									}else{
										$raices[$i] = metodoNewtonBiseccion($m, $n, $polinomio); //Bisección-Newton
									}
														
									$i++;
								}
								$m = $n;
								$n = $n + $valor;
							}
							return $raices;
					    }
						
						function metodoNewtonBiseccion($a_k, $b_k, $polinomio){
							$k = 0;
							$c_k = ($b_k+$a_k)/2;
							do{
								$derivada = calcularDerivada($polinomio, $c_k);
								eval('$funcion_c_k = '.str_replace('$x', '($c_k)', $polinomio).';');
								if($derivada == 0){
									echo "<pre align='center'>";
									echo "<font size=3> \nEl polinomio tiene una derivada nula.\n No se puede calcular por este método.\n </font>"; 
									echo "</pre>";
									exit(1);
									break;
								}
									$raiz = $c_k;
									$c_k = $c_k - ($funcion_c_k/$derivada);

								if($c_k < $raiz){
									$raiz = $c_k;
									break;
								}
								$k++;
							}while(abs($funcion_c_k) >= pow(10,-8));
							return $raiz;
						}
						function metodoSecanteBiseccion($a_k, $b_k, $polinomio){    
							$k = 0;
							$maximo_iteraciones=(log(((1-(-1))/pow(10,-8)),2)-1);
							while($k < $maximo_iteraciones){
								eval('$funcion_a_k ='.evaluarFuncion($polinomio, $a_k).';'); //f(a_k)
								eval('$funcion_b_k ='. evaluarFuncion($polinomio, $b_k).';'); //f(b_k)
							 
								$c_k = $b_k - ($funcion_b_k*(($b_k-$a_k)/($funcion_b_k-$funcion_a_k))); //x_c
								eval('$funcion_c_k ='. evaluarFuncion($polinomio, $c_k).';'); //f(x_c)
								if(abs($b_k-$c_k) < pow(10,-8) || abs($funcion_c_k) < pow(10, -8)) break;
								
								if(($funcion_b_k*$funcion_c_k) < 0){
									$a_k = $c_k;
								}else{
									$b_k = $c_k;
								}
								$k++;
							}
							return $c_k;
						}

						function calcularXi($a, $b, $raiz){
							return (($b-$a)/2)*$raiz + (($b+$a)/2);
						}

						function calcularWi($x, $n,$polinomio){
							eval('$polinomio_n_1 = '.polinomioLegendre($n+1).';');
							return (-2)/(($n+1)*calcularDerivada($polinomio, $x)*$polinomio_n_1);
						}

						function calcularIntegral($a, $b, $n, $raices, $polinomio, $funcion_cad){
							$sumatorio = 0;
							for($i = 0; $i < $n ; $i++){
								$x = calcularXi($a, $b, $raices[$i]);
								eval('$funcion = '.$funcion_cad.';');
								$sumatorio = $sumatorio + $funcion*calcularWi($raices[$i], $n, $polinomio);
							}
							$integral = (($b-$a)/2)*$sumatorio;
							return $integral;
						}
						
						function metodoSimpson($a, $b ,$n, $funcion){
							$area_n = -1;
							$k = 2;
							while($k <= $n){
								$area_Ant = $area_n;
								$sumatorioImpares = 0;
								$sumatorioPares = 0;
								$h = ($b-$a)/$k;
								for($j = 1 ; $j <= $k/2 ; $j++){
									eval('$fun = '.evaluarFuncion($funcion, '($a+$h*(2*$j-1))'));
									$sumatorioImpares = $sumatorioImpares + $fun;
								}
								for($j = 1 ; $j <= $k/2-1 ; $j++){
									eval('$fun = '.evaluarFuncion($funcion, '($a+($h*2*$j))'));
									$sumatorioPares = $sumatorioPares + $fun;
								}
								eval('$fun = '.evaluarFuncion($funcion, '$a'));
								eval('$fun1 = '.evaluarFuncion($funcion, '$b'));
								
								$area_n = ($h/3)*($fun+ 4*$sumatorioImpares+2*$sumatorioPares+$fun1);	
								if(abs($area_Ant - $area_n) < pow(10,-8)) break;
								$k = $k + 2;
							}
							return $area_n;
						}
						function evaluarFuncion($funcion, $parametro){
							return str_replace('$x', $parametro, $funcion).';';
						}	
							
						function metodoTrapecios($a, $b, $n, $funcion){
							$area_n = 0;
							$area_Ant = $area_n;
							$h=($b-$a)/($n);
							$sumatorio=0;
							for($j=1 ; $j <= $n-1 ; $j++){
								$fun = evaluarFuncion($funcion, '($a+($h*$j))');
								eval('$fun = '.evaluarFuncion($funcion, '($a+($h*$j))'));
								$sumatorio = $sumatorio + $fun;
							}
							eval('$fun1 = '.evaluarFuncion($funcion, '$a'));
							eval('$fun2 = '.evaluarFuncion($funcion, '$b'));
							$area_n= ($h)*(($fun1/2)+ $sumatorio + $fun2/2);	
							return $area_n;
						}
						function imprimirMatriz($matriz,$n,$m){
							echo '<table cellspacing="0" cellpadding="10" border = "5"  width: auto height: auto color = "solid black">';
							echo '<br>';
							for($i = 0; $i < $n; $i++){
								echo '<tr>';
								for($j = 0; $j < $m; $j++){
									echo '<td cellspacing="10" cellpadding="10" width: auto height: auto style="border:1px solid dimgray">'.$matriz[$i][$j].'</td>';
								}
							}
							echo '</table>';
							echo "<br>";
						}				
					 ?><br> 
				</td></table>
			</fieldset></div>
	</form>
</div>
</section>
</body>
</html>
