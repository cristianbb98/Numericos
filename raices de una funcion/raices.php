<?php
function f($x){
    return $x*$x-4;
}

function intervalo($a,$b){
  $k=0;
  $c=($a+$b)/2;
while(abs(f($c))>=0.00000001){
  $c=($a+$b)/2;
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
    intervalo($a+abs($delta*($cont-1)),$a+abs($delta*$cont));
    }
    if(($cont*$delta)==($a-$b))break;
    $cont++;
  }
}

if(isset($_POST['a']) && isset($_POST['b']) && isset($_POST['n'])){
  $a=$_POST['a'];
  $b=$_POST['b'];
  $n=$_POST['n'];
  parametros($a,$b,$n);

}

#echo "[".($a+abs($delta*($cont-1))).",";
#echo ($a+abs($delta*$cont))."]<br>";
#echo "[".f($a+abs($delta*($cont-1))).",";
#echo f($a+abs($delta*$cont))."]<br>";
#echo f($a)*f($a+abs($delta*$cont))."<br><br>";

?>

<form action="raices.php" method="POST">
<p>Inicion: <input type="text" name="a" />
<p>Final: <input type="text" name="b" />
<p>Numero de intevalos: <input type="text" name="n" />
<p><input type="submit" value="Calcular" />
</form>
