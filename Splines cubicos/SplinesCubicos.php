<html>
<head>
  <title>Splines Cubicos</title>
<style>
body{
  text-align: center;
  font-size: 20px;
}
</style>
</head>
<body>
  <form action="SplinesCubicos.php" method="post">
    <p>
      xi = <input type="string" name="x" value="1,2,3,4,5" />
      yi = <input type="string" name="y" value="5,1,4,2,3" />
    </p>
    <p><input type="submit" value="Cargar" /></p>
  </form>
<?php
if(isset($_POST['x'])&&isset($_POST['y'])){
  function imprimirTabla($x,$y){
    echo "
    <center><table>
        <tr>
          <th align=center width=40 style=border:1px solid black>i</th>
          <th align=center width=40 style=border:1px solid black>xi</th>
          <th align=center width=40 style=border:1px solid black>yi</th>
        </tr>";
        for($i=0;$i<sizeof($x);$i++){
          echo "
              <tr>
                <th align=center width=40 style=border:1px solid black>".($i+1)."</th>
                <th align=center width=40 style=border:1px solid black>".$x[$i]."</th>
                <th align=center width=40 style=border:1px solid black>".$y[$i]."</th>
              </tr>";
        }
        echo "</table></center>";
  }
  function imprimirTablaDeUnValor($x){
    echo "
    <center><table>";
        for($i=1;$i<sizeof($x)+1;$i++){
          echo "
              <tr>
                <th align=center width=40 style=border:1px solid black>".($i)."</th>
                <th align=center width=40 style=border:1px solid black>".$x[$i]."</th>
              </tr>";
        }
        echo "</table></center>";
  }
  function imprimirTablaDeUnValor1($x){
    echo "
    <center><table>";
        for($i=1;$i<sizeof($x)+1;$i++){
          echo "
              <tr>
                <th align=center width=40 style=border:1px solid black>".($i)."</th>
                <th align=center width=40 style=border:1px solid black>".$x[$i]."</th>
              </tr>";
        }
        echo "</table></center>";
  }
  function imprimirMatriz($matriz,$b){
    echo "<center><table >";
  for($i=0;$i<sizeof($matriz);$i++){
      echo "
          <tr>
          <th align=center width=100 style=border:1px solid black>".$matriz[$i][0]."</th>
          <th align=center width=100 style=border:1px solid black>".$matriz[$i][1]."</th>
          <th align=center width=100 style=border:1px solid black>".$matriz[$i][2]."</th>
          <th align=center width=100 style=border:1px solid black>|</th>
          <th align=center width=100 style=border:1px solid black> ".$b[$i]."</th>
          </tr>";
  }
  echo "</table></center>";
  }
  function eliminacionGaussiana(){
  global $a;
  global $b;
  imprimirMatriz($a,$b);
  echo "<br>";
  for ($i = 0; $i < sizeof($a)-1; $i++) {
             for ($j = $i+1; $j < sizeof($a); $j++) {
                 $mik=$a[$j][$i]/$a[$i][$i];
                 for ($k = 0; $k < sizeof($a); $k++) {
                     $a[$j][$k]=$a[$j][$k]-$mik*$a[$i][$k];
                 }
                 $b[$j]=$b[$j]-$mik*$b[$i];
             }
         }

         imprimirMatriz($a,$b);
         echo "<br>";
         for($i=0;$i<sizeof($a)+1;$i++){
            $x[$i]=0;
         }
         for($i=0;$i<5;$i++){
            $x1[$i]=0;
         }
         for ($i = sizeof($a)-1; $i >= 0 ; $i--) {
                $suma=0;
                for ($j = $i; $j < sizeof($a); $j++) {
                $suma = $suma+$a[$i][$j]*$x[$j];
                }
                $x[$i]=(1/$a[$i][$i])*($b[$i]-$suma);
            }
            for ($i = 0; $i <3 ; $i++) {
                   //$x1[$i+1]=$x[2-$i];
                   $x1[$i+1]=$x[$i];
               }
          return $x1;
    }

  $x=$_POST['x'];
  $y=$_POST['y'];
  $xi = preg_split("/[\s,]+/", $x);
  $yi = preg_split("/[\s,]+/", $y);
  if(sizeof($xi)==sizeof($yi)){
    imprimirTabla($xi,$yi);
    echo "<br>";
  for($i=1;$i<sizeof($xi);$i++){
      $h[$i]=$xi[$i]-$xi[$i-1];
  }
  echo "<br>h";
  imprimirTablaDeUnValor($h);
  for($i=1;$i<sizeof($xi);$i++){
    $g[$i]=($yi[$i]-$yi[$i-1])/$h[$i];
  }
  echo "<br>g";
  imprimirTablaDeUnValor($g);
  for($i=1;$i<sizeof($xi)-1;$i++){
    $lan[$i]=$h[$i]/($h[$i]+$h[$i+1]);
  }
  echo "<br>lan";
  imprimirTablaDeUnValor($lan);
  for($i=1;$i<sizeof($xi)-1;$i++){
    $u[$i]=$h[$i+1]/($h[$i]+$h[$i+1]);
  }
  echo "<br>u";
  imprimirTablaDeUnValor($u);

  for($i=1;$i<sizeof($xi)-1;$i++){
    $d[$i]=6*($g[$i+1]-$g[$i])/($h[$i]+$h[$i+1]);
  }
  echo "<br>d";
  imprimirTablaDeUnValor1($d);
  echo "<br>";
  $a[0][0]=2;
  $a[0][1]=$lan[2];
  $a[0][2]=0;
  $a[1][0]=$u[2];
  $a[1][1]=2;
  $a[1][2]=$lan[3];
  $a[2][0]=0;
  $a[2][1]=$u[3];
  $a[2][2]=2;

  $b[0]=$d[1];
  $b[1]=$d[2];
  $b[2]=$d[3];
  $M=eliminacionGaussiana();
  for($i=1;$i<sizeof($xi);$i++){
    $r[$i]=$M[$i-1]/(6*$h[$i]);
  }
  echo "<br>r";
  imprimirTablaDeUnValor1($r);
  for($i=1;$i<sizeof($xi);$i++){
    $s[$i]=$M[$i]/(6*$h[$i]);
  }
  echo "<br>s";
  imprimirTablaDeUnValor1($s);
  for($i=1;$i<sizeof($xi);$i++){
    $t[$i]=($yi[$i-1]-($M[$i-1] * (pow($h[$i], 2)/6)))/ $h[$i];
  }
  echo "<br>t";
  imprimirTablaDeUnValor($t);
  for($i=1;$i<sizeof($xi);$i++){
    $u[$i]= ($yi[$i]-($M[$i] * (pow($h[$i], 2)/6)))/ $h[$i];
  }
  echo "<br>u";
  imprimirTablaDeUnValor($u);
  for($i=1;$i<sizeof($xi);$i++){
    $v[$i]= $s[$i] - $r[$i];
  }
  echo "<br>v";
  imprimirTablaDeUnValor($v);
  for($i=1;$i<sizeof($xi);$i++){
    $w[$i]=3*($r[$i]*$xi[$i]-$s[$i]*$xi[$i-1]);
  }
  echo "<br>w";
  imprimirTablaDeUnValor($w);
  for($i=1;$i<sizeof($xi);$i++){
    $f[$i]= 3*($s[$i]*pow($xi[$i-1],2) - $r[$i]*pow($xi[$i],2)) + $u[$i] - $t[$i];
  }
  echo "<br>f";
  imprimirTablaDeUnValor($f);
  for($i=1;$i<sizeof($xi);$i++){
    $g[$i]= $xi[$i]*($r[$i]*pow($xi[$i],2) + $t[$i]) - $xi[$i-1]*($s[$i]*pow($xi[$i-1],2) + $u[$i]);
  }
  echo "<br>g";
  imprimirTablaDeUnValor($g);
  echo "<br>";
  for($i=1;$i<sizeof($xi);$i++){
    echo "P(x)=".$v[$i]."x^3+".$w[$i]."x^2+".$f[$i]."x+".$g[$i]."<br>";
  }
}else{
  echo "<br>No hay el mismo numero de x que de y";
}
}
?>
</body>
</html>
