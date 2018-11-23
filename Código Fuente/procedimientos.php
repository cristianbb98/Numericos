<html>
<head>
  <title>PROCEDIMIENTOS</title>

</head>
<link rel="stylesheet" href="css/styles.css">
<body class = "body">
<section>
	<div class = "input">
		<form action="" method="GET" name="Procedimientos">
				<?php
				$n = $_GET['n'];
				$intervalo_Inferior = $_GET['inf'];
				$intervalo_Superior = $_GET['sup'];
				$metodo = $_GET['metodo'];
				$funcion = $_GET['funcion'];
				$subintervalos = 200;
				$a = -1;
				$b = 1;
				$valor = ($b-$a)/$subintervalos;
				$polinomio = polinomioLegendre($n);
				$raices = busquedaCambioSigno($a, $a + $valor, $valor, $b, $polinomio,$metodo);
				echo '<div><fieldset align = "center"> <legend> RAICES DEL POLINOMIO DE LEGENDRE </legend>
				<table cellspacing="0" cellpadding="10" border = "5" align = "center" color = "solid black">
				<br>';
				for($i = 0; $i < $n; $i++){
							echo '<tr>';
							echo '<td cellspacing="10" cellpadding="10" width: auto height: auto style="border:1px solid dimgray">'."Raiz[$i]".'</td>';
							echo '<td cellspacing="10" cellpadding="10" width: auto height: auto style="border:1px solid dimgray">'.$raices[$i].'</td>';
						}
				echo '</table>
				<br>
				</div></fieldset>';
				calcularIntegral($intervalo_Inferior, $intervalo_Superior, $n, $raices, $polinomio, $funcion);
				function polinomioLegendre($n){
					if($n == 0){
						return '1';
					}else if($n == 1){
						return '$x';
					}else{
						return (1/$n).'*('.(2*$n-1).'*$x*'.polinomioLegendre($n-1).'-'.($n-1).'*'.polinomioLegendre($n-2).')';
					}
				}
	
				function busquedaCambioSigno($m, $n, $valor,$b, $polinomio, $metodo){
					$i = 0;
					$raices = array();
					while($m <= $b){
						eval('$f_m = '.evaluarFuncion($polinomio, '$m').';');
						eval('$f_n = '.evaluarFuncion($polinomio, '$n').';');

						if($f_m*$f_n <= 0){
							if($metodo == "1")
								$raices[$i] = metodoSecanteBiseccion($m, $n, $polinomio); //Bisección-Secante
							else
								$raices[$i] = metodoNewtonBiseccion($m, $n, $polinomio); //Bisección-Newton
							
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
						$derivada = calcularDerivada($polinomio, $c_k, 1,0);
						eval('$funcion_c_k = '.str_replace('$x', '($c_k)', $polinomio).';');

						if($derivada == 0){
							echo nl2br ("\n E1: Derivada nula");
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
				function calcularDerivada($polinomio,$t,$valor,$i){

					$delta_t = 0.1;
					$cont = 1;
					$derivada = 0;
					$derivadas[0][0] = "Numero Iteracion";
					$derivadas[0][1] = "Derivada";
					$derivadas[0][2] = "Valor de delta_t";
					$derivadas[0][3] = "Error";
					do{
						$derivada_anterior = $derivada;
						eval('$fun1 = '.str_replace('$x', '($t + $delta_t)', $polinomio).';');
						eval('$fun2 = '.str_replace('$x', '($t - $delta_t)', $polinomio).';');
						$derivada=($fun1 - $fun2)/(2*$delta_t);
						$delta_t = $delta_t/2;
						$derivadas[$cont][0] = $cont;
						$derivadas[$cont][1] = $derivada;
						$derivadas[$cont][2] = $delta_t;
						$derivadas[$cont][3] = $delta_t;
						$cont++;
						$error =abs($derivada-$derivada_anterior);
					}while($error > pow(10, -8) && $delta_t > pow(10, -8));
					if($valor != 1){
						echo '<div><fieldset align = "center"> <legend> VALORES DE LA DERIVADA DEL POLINOMIO DE LEGENDRE</legend>';
						echo "<pre>";
						echo "<font size=5>RAIZ[$i] = $t </font>"; 
						echo "</pre>";
						imprimirMatriz($derivadas,$cont,4);
						echo '</div></fieldset>';
					}
					return $derivada;
				}
				function imprimirMatriz($matriz,$n,$m){
					echo '<table cellspacing="0" cellpadding="10" border = "5"  align = "center"  width: auto height: auto color = "solid black">';
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
				function evaluarFuncion($funcion, $parametro){
							return str_replace('$x', $parametro, $funcion).';';
				}
				function calcularXi($a, $b, $raiz){
					return (($b-$a)/2)*$raiz + (($b+$a)/2);
				}

				function calcularWi($x, $n,$polinomio,$i){
					eval('$polinomio_n_1 = '.polinomioLegendre($n+1).';');
					return (-2)/(($n+1)*calcularDerivada($polinomio, $x,0,$i)*$polinomio_n_1);
				}

				function calcularIntegral($a, $b, $n, $raices, $polinomio, $funcion_cad){
					$sumatorio = 0;
					for($i = 0; $i < $n ; $i++){
						$x = calcularXi($a, $b, $raices[$i]);
						eval('$funcion = '.$funcion_cad.';');
						$sumatorio = $sumatorio + $funcion*calcularWi($raices[$i], $n, $polinomio,$i);
					}
					$integral = (($b-$a)/2)*$sumatorio;
					//return  round($integral, 4);
					return $integral;
				}
				
				
				?>
</section>
</body>
</html>