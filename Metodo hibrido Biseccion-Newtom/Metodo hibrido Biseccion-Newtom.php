<?php
function f($x){
  return $x*$x-3;
}

function derivada($x){
  $derivada=(f($x+0.000001)-f($x-0.000001))/(2*0.000001);
  return $derivada;
}

function metodoNewton($xk){
  $aux=0;
  $k=1;
  while(f($xk)>0.0000001 || abs($xk-$aux)>0.0000001){
    if(derivada($xk)==0){
      echo "E1. Derivada nula";
      return;
    }
    $aux=$xk;
    $xk=$xk-f($xk)/derivada($xk);
    echo $xk."<br>";
    $k++;
    if($k>200){
      echo "No converge";
      break;
    }
  }
  echo "La raiz esta en: ".$xk."<br><br>";
}

function parametros($a,$b,$n){
  $delta=($a-$b)/$n;
  $cont=1;
  while(true){
    if((f($a+abs($delta*($cont-1)))*f($a+abs($delta*$cont)))<=0){
      $a1=$a+abs($delta*($cont-1));
      $b1=$a+abs($delta*$cont);
    metodoNewton(($b1+$a1)/2);
    }
    if(($cont*$delta)==($a-$b))break;
    $cont++;
  }
}
parametros(-10,10,15);
?>
