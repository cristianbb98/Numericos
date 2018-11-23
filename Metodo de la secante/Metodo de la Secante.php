<?php
function f($x){
  return $x*$x-4;
  #return $x*$x+1;
}

function secante(){
  $xk=-2;
  $xkm1=1;
  $xk1=$xk-f($xk)*($xk-$xkm1)/(f($xk)-f($xkm1));
  $k=1;
  $aux;
  while(abs(f($xk1))>0.0000001 || abs($xk1-$xk)>0.0000001){
    if((f($xk)==f($xkm1))){
      echo "<br>Error divicion para cero.<br>";
      break;
    }
    $aux=$xk1;
    $xk1=$xk-f($xk)*(($xk-$xkm1)/(f($xk)-f($xkm1)));
    echo $xk1."<br>";
    $xkm1=$xk;
    $xk=$aux;
    $k++;
    if($k>1000){
      echo "<br>Error<br>";
      break;
    }
    }
  echo "<br>Raiz = ".$xk1;
}

secante();

?>
