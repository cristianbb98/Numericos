<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">

<style>
h1,h2,h3,h4,h5,h6 {font-family: "Oswald"}
body {font-family: "Open Sans"}
</style>
<body class="w3-light-grey">

<!-- Navigation bar with social media icons -->
<div class="w3-bar w3-black w3-hide-small">
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-facebook-official"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-instagram"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-snapchat"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-flickr"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-twitter"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-linkedin"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-right"><i class="fa fa-search"></i></a>
</div>

<!-- w3-content defines a container for fixed size centered content,
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1600px">

  <!-- Header -->
  <header class="w3-container w3-center w3-padding-48 w3-white">
    <h1 class="w3-xxxlarge"><b>INTEGRACIÓN POR CURVATURA GAUSSIANA</b></h1>
    <h6></h6>

    <head>
  <title>Plotting functions in JavaScript using the function plot library</title>
  <meta charset="utf-8"/>
  <script src="https://d3js.org/d3.v3.min.js"></script>
  <script src="https://mauriciopoppe.github.io/function-plot/js/function-plot.js"></script>
<style id="jsbin-css">
div {
  float: left;
}
#myFunction {
  padding: 25px;
  width: 250px;
  height: 250px;
}
</style>
</head>

<?php

  if(isset($_POST['btn_calcular'])){
    $intervalo_Inferior = $_POST['txt_inferior'];
    $intervalo_Superior = $_POST['txt_superior'];
    $n = $_POST['txt_n'];
    $funcion = $_POST['txt_funcion'];

    $polinomio = polinomioLegendre($n);
    $subintervalos = 100;
    $a = -1;
    $b = 1;
    $valor = ($b-$a)/$subintervalos;

    $raices = busquedaCambioSigno($a, $a + $valor, $valor, $b, $polinomio);
    echo nl2br ("\nRaices del polinomio de Legendre:\n");

    for($j = 0; $j < $n; $j++){
      echo nl2br("\n Raiz[$j] => $raices[$j]");
    }

    $integral = calcularIntegral($intervalo_Inferior, $intervalo_Superior, $n, $raices, $polinomio, $funcion);
    echo nl2br ("\n\n INTEGRAL = $integral");
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
    }while(abs($derivada-$derivada_anterior) > pow(10, -8));

    return $derivada;
  }

  function busquedaCambioSigno($m, $n, $valor,$b, $polinomio){
    $i = 0;
    $raices = array();

    while($m <= $b){
      eval('$f_m = '.str_replace('$x', '($m)', $polinomio).';');
      eval('$f_n = '.str_replace('$x', '($n)', $polinomio).';');

      if($f_m*$f_n <= 0){
        $raices[$i] = metodoNewtonBiseccion($m, $n, $polinomio);
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
        echo nl2br ("\n E1: Derivada nula");
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
    return (($b-$a)/2)*$sumatorio;
  }

  ?>

</body>

<body>
  <form action="prueba3.php" method="POST" name="INTEGRACIÓN POR CURVATURA GAUSSIANA">
  <br><b>Ingrese la función a integrar: <input type="int" name="txt_funcion" value="1" step="0.01"/><br>
  <br><b>Ingrese el grado n del polinomio de Legendre: </b><br>
  <br>Grado del polinomio N= <input type="int" name="txt_n" value="1" step="0.01"/><br>
  <br>Intervalo inferior<input type="int" name="txt_inferior" value="1" step="0.01"/><br>
  <br>Intervalo superior<input type="int" name="txt_superior" value="1" step="0.01"/><br>
  <br><b>Ingrese el numero de subintervalos:</b> <br>
  <br><input type="submit" name="btn_calcular" value="Calcular"/><br>


  <div id="myFunction"></div>
<script id="jsbin-javascript">
var parameters = {
  target: '#myFunction',
  data: [{
    fn: 'sin(x)',
    color: 'red'
 }
        ],
  grid: true,
  yAxis: {domain: [-1.5, 1.5]},
  xAxis: {domain: [-3*Math.PI, 3*Math.PI]}
};
functionPlot(parameters);
</script>


<script id="jsbin-source-css" type="text/css">div {
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
    fn: 'y=x*x',
    color: 'red'
 }
        ],
  grid: true,
  yAxis: {domain: [-1.5, 1.5]},
  xAxis: {domain: [-3*Math.PI, 3*Math.PI]}
};
functionPlot(parameters);
</script></body>
</html>



  </header>


}
</script></body>
</html>
