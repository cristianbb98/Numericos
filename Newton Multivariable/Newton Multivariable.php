<html>
  <head>
    <title>Resolver matrices por Gauss</title>
  </head>
  <link rel="stylesheet" href="css/stylesG.css">
<body>
<div class="encabezado">
  <h1>Newton Multivariable</h1>
</div>

  <div class="Input">
    <form action="Newton Multivariable.php" method="post">
      <p>S(x,y) = <input type="text" name="s" value="x*x*y+x*y*y+x+y-3" /></p>
      <p>
        x = <input type="number" name="x" value="1" step="1"/>
        y = <input type="number" name="y" value="1" step="1"/>
      </p>
      <p><input type="submit" value="Cargar" /></p>
    </form>
  </div>
<div class="php">
<?php
if(isset($_POST['s'])&&isset($_POST['x'])&&isset($_POST['y'])){
$s=$_POST['s'];
echo "S(x,y)=".$s."<br><br>";
echo "J(x,y)*&#916(x,y)=-F(x,y)<br><br>";
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
function eliminacionGaussiana($a,$b){
  imprimirMatriz($a,$b);
for ($i = 0; $i < sizeof($a)-1; $i++) {
           for ($j = $i+1; $j < sizeof($a); $j++) {
             try {
               $mik=$a[$j][$i]/$a[$i][$i];
             } catch (Exception $e) {
                 echo 'Excepción capturada: ',  $e->getMessage(), "\n";
             }
               for ($k = 0; $k < sizeof($a); $k++) {
                   $a[$j][$k]=$a[$j][$k]-$mik*$a[$i][$k];
               }
               $b[$j]=$b[$j]-$mik*$b[$i];
           }
       }

       imprimirMatriz($a,$b);
       for($i=0;$i<sizeof($a);$i++){
          $x[$i]=0;
       }

       for ($i = sizeof($a)-1; $i >= 0 ; $i--) {
              $suma=0;
              for ($j = $i; $j < sizeof($a); $j++) {
              $suma = $suma+$a[$i][$j]*$x[$j];
              }

              $x[$i]=(1/$a[$i][$i])*($b[$i]-$suma);
          }
          echo "x = ".$x[0]."<br>";
          echo "y = ".$x[1]."<br>";
  }

$x=$_POST['x'];
$y=$_POST['y'];
$J=Jacobiano($x,$y);
$b=F($x,$y);
eliminacionGaussiana($J,$b);
}
?>
</div>
</body>
</html>
