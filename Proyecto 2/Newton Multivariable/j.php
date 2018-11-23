<center>
<?php
$s="1/(1+x*(t-1)^2)+c/(1+x*(t-1-y)^2)";
echo "S(x,y)=".$s."<br><br>";
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

function derivarC($s){
  $s1=$s;
  $s=str_replace('c','(c+h)',$s);
  $s1=str_replace('c','(c-h)',$s1);
  $s='(('.$s.')-('.$s1.'))/(2*h)';
  return $s;
}

function calcular($x,$y,$c,$f){
  $f=str_replace('x','$x',$f);
  $f=str_replace('y','$y',$f);
  $f=str_replace('c','$c',$f);
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


function Jacobiano($x,$y,$c){
  global $s;
  $f1=derivarX($s);
  $f2=derivarY($s);
  $f3=derivarC($s);

  echo "<br>".$f1."<br>".$f2."<br>".$f3;
  echo "<br><br>".derivarX($f1);
  /*
  $J[0][0]=calcular($x,$y,derivarX($f1));
  $J[0][1]=calcular($x,$y,derivarY($f1));
  $J[1][0]=calcular($x,$y,derivarX($f2));
  $J[1][1]=calcular($x,$y,derivarY($f2));
  return $J;*/
}

function F($x,$y){
  global $s;
  $f1=derivarX($s);
  $f2=derivarY($s);
  $f3=derivarC($s);
  $f[0]=-calcular($x,$y,$c,$f1);
  $f[1]=-calcular($x,$y,$c,$f2);
  $f[2]=-calcular($x,$y,$c,$f3);
  return $f;
}

Jacobiano(1,1,1);
?>
</center>
