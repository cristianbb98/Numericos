<?php
function f($x){
  return $x*$x-3;
}
function derivada($x){
  $derivada=(f($x+0.000001)-f($x-0.000001))/(2*0.000001);
  return $derivada;
}

function metodoNewton(){
  $aux=0;
  $xk=4;
  $k=1;
  while(f($xk)>0.0000001 || abs($xk-$aux)>0.0000001){
    if(derivada($xk)==0){
      echo "E1. Derivada nula";
      return;
    }
    $aux=$xk;
    $xk=$xk-f($xk)/derivada($xk);
    echo $xk."<br><br>";
    $k++;
    if($k>200){
      echo "No converge";
      break;
    }
  }
  echo "La raiz esta en: ".$xk;
}
metodoNewton();
?>
