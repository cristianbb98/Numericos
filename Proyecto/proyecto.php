
<html lang="es">
<head>
  <title>INTEGRACION POR CURVATURA GAUSSIANA</title>

</head>
  <link rel="stylesheet" href="css/styles.css">
  <meta charset="utf-8"/>
  <script src="https://d3js.org/d3.v3.min.js"></script>
  <script src="https://mauriciopoppe.github.io/function-plot/js/function-plot.js"></script>

<body>
  <section>
    <div class="encabezado">
          <h1>INTEGRACION POR CURVATURA GAUSSIANA</h1>
    </div>
<div class="input">

<form action="proyecto.php" method="POST" name="INTEGRACION POR CURVATURA GAUSSIANA">
  <br><b>Ingrese la funcion a integrar: </b><input type="int" name="txt_funcion" value="1" step="0.01"/><br>
  <br><b>Ingrese el grado n del polinomio de Legendre: </b><input type="int" name="txt_n" value="1" step="0.01"/><br>
  <br><b>Ingrese el numero de subintervalos:</b> <br>
  <br>Intervalo inferior: <input type="int" name="txt_inferior" value="0" step="0.01"/><br>
  <br>Intervalo superior: <input type="int" name="txt_superior" value="1" step="0.01"/><br>
  <br><input type="submit" name="btn_calcular" value="Calcular"/><br>
</form>
</div>
<div class="grafica">
<?php

  if(isset($_POST['btn_calcular'])){
    $intervalo_Inferior = $_POST['txt_inferior'];
    $intervalo_Superior = $_POST['txt_superior'];
    $n = $_POST['txt_n'];
    $funcion = $_POST['txt_funcion'];

    echo "Funcion = ".$funcion."<br>";
    $funcionJava=$funcion;
    $funcion = str_replace('x', '$x', $funcion);
    $polinomio = polinomioLegendre($n);
    $subintervalos = 100;
    $a = -1;
    $b = 1;
    $valor = ($b-$a)/$subintervalos;

    $raices = busquedaCambioSigno($a, $a + $valor, $valor, $b, $polinomio);
    echo nl2br ("\nRaices del polinomio de Legendre:\n");

    for($j = 0; $j < $n; $j++){
      echo nl2br("\n Raiz[$j] = $raices[$j]");
    }

    $integral = calcularIntegral($intervalo_Inferior, $intervalo_Superior, $n, $raices, $polinomio, $funcion);
    echo nl2br ("\n\n INTEGRAL = $integral")."<br>";
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

<div id="myFunction"></div>
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
      fn: '1118.82*(1 / (1 + (8.8852358742779E-7) * ((x - 4119.07)^ 2)))+(0.049400348243159 / (1 + (8.8852358742779E-7 )* ((x - 3269.0701704248)^ 2)))',
    color: 'red'
 }
        ],
  grid: true,
  yAxis: {domain: [0,1200]},
  xAxis: {domain: [0,8000]}
};
functionPlot(parameters);
</script>
</div>
</section>
</body>
</html>
