<center>
<?php
$s="x*x*y+x*y*y+x+y-3";
echo "S(x,y)=".$s."<br><br>";
//echo "J(x,y)*&#916(x,y)=-F(x,y)<br><br>";
function derivarX($s){
  $s1=$s;
  $s=str_replace('x','(x+h)',$s);
  $s1=str_replace('x','(x-h)',$s1);
  $s='(('.$s.')-('.$s1.'))/(2*h)';
  return $s;

}

function derivarY($s){
  $s1=$s;
  $s=str_replace('y','(y+h)',$s);
  $s1=str_replace('y','(y-h)',$s1);
  $s='(('.$s.')-('.$s1.'))/(2*h)';
  return $s;
}


function calcular($x,$y,$f){
  $f=str_replace('x','$x',$f);
  $f=str_replace('y','$y',$f);
  $f=str_replace('h','$h',$f);
  $h=1;
  eval('$res = '.$f.';');
  $resA=$res;
  do{
  $h/=2;
  eval('$res = '.$f.';');
}while(abs($resA-$res)>0.00000001);
  return $res;
}


function Jacobiano($x,$y){
  global $s;
  $f1=derivarX($s);
  $f2=derivarY($s);

  echo "<br>".$f1."<br>".$f2;
  echo "<br><br>".derivarX($f1);
  $J[0][0]=calcular($x,$y,derivarX($f1));
  $J[0][1]=calcular($x,$y,derivarY($f1));
  $J[1][0]=calcular($x,$y,derivarX($f2));
  $J[1][1]=calcular($x,$y,derivarY($f2));
  return $J;
}

function F($x,$y){
  global $s;
  $f1=derivarX($s);
  $f2=derivarY($s);
  $f[0]=-calcular($x,$y,$f1);
  $f[1]=-calcular($x,$y,$f2);
  return $f;
}

function imprimirMatriz($matriz,$b){
for($i=0;$i<sizeof($matriz);$i++){
  for($j=0;$j<sizeof($matriz);$j++){
    echo " ".$matriz[$i][$j]." ";
  }
  echo " | ".$b[$i]."<br>";
}
echo "<br>";
}
$x=1;
$y=1;
$j=Jacobiano($x,$y);
$b=F($x,$y);
echo "<br>";
imprimirMatriz($j,$b);
?>
</center>
