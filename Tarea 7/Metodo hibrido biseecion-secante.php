<?php
function f($x){
  return $x*$x-3;
}

function intervalo($a,$b){
  $k=0;
  $c=$b-f($b)*($b-$a)/(f($b)-f($a));
while((abs(f($c))>=0.00000001||abs($b-$c)>0.00000001)&&$k<50000){
  $c=$b-f($b)*($b-$a)/(f($b)-f($a));
  if((f($b)*f($c))<0){
    $a=$c;
  }else{
    $b=$c;
  }
  $k++;
}
  echo "Raiz = ".$c." k = ".$k."<br>";
}

function parametros($a,$b,$n){
  $delta=($a-$b)/$n;
  $cont=1;
  while(true){
    if((f($a+abs($delta*($cont-1)))*f($a+abs($delta*$cont)))<=0){
      echo $a+abs($delta*($cont-1))."<br>";
      echo $a+abs($delta*$cont)."<br>";
    intervalo($a+abs($delta*($cont-1)),$a+abs($delta*$cont));
    }
    if(($cont*$delta)==($a-$b))break;
    $cont++;
  }
}

parametros(-10,10,80);
?>
