<?php

$n = 2;

function polinomioLegendre($n){
if($n==0){
  return "1";
}else if($n==1){
  return '$x';
}else{
  return (1/$n).'*'.((2*$n-1).'*$x*'.polinomioLegendre($n-1).'-'.($n-1)*polinomioLegendre($n-2));
}
}

function f($x){
global $n;
  eval('$f='.polinomioLegendre($n).';');
  return $f;
}

function calcularDerivada1($x){
  $delta_t = 0.1;
  $derivada = 0;
do {
  $derivada_anterior=$derivada;
  $derivada=(f($x+$delta_t) - f($x-$delta_t))/(2*$delta_t);
} while (abs($derivada-$derivada_anterior) > pow(10, -8));
  return $derivada;
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

echo calcularDerivada(polinomioLegendre(2),2)."<br>";
echo calcularDerivada1(2);
//echo calcularDerivada(polinomioLegendre(2),2);
//echo polinomioValor();

/*$hola=3;
$frase= 'es un $hola como estas';
echo $frase."<br>";
eval('$fun1 = '.'$hola+4'.';');
echo $fun1;*/

?>
