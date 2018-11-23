<html>
  <head>
    <title>Interpolacion Cuadratica</title>
  </head>
<link rel="stylesheet" href="css/styles.css">
<body>
<div class="encabezado">
  <h1>Interpolacion Cuadratica</h1>
</div>
  <div class="Input">
    <form action="" method="post">
      <p>
        Punto 1(x,y)= <input type="number" name="x1" value="5" step="0.01"/>&nbsp<input type="number" name="y1" value="3" step="0.01"/>
      </p>
      <p>
        Punto 2(x,y)= <input type="number" name="x2" value="1" step="0.01"/>&nbsp<input type="number" name="y2" value="4" step="0.01"/>
      </p>
      <p>
        Punto 3(x,y)= <input type="number" name="x3" value="6" step="0.01"/>&nbsp<input type="number" name="y3" value="2" step="0.01"/>
      </p>
        <input type="submit" name="submit" value="Calcular"/><br>
    </form>
  </div>

<div class="php">
<?php
if(isset($_POST['submit'])){
    $x1=$_POST['x1'];
    $x2=$_POST['x2'];
    $x3=$_POST['x3'];

  $a[0][0]=$x1*$x1;
  $a[0][1]=$x1;
  $a[0][2]=1;

  $a[1][0]=$x2*$x2;
  $a[1][1]=$x2;
  $a[1][2]=1;

  $a[2][0]=$x3*$x3;
  $a[2][1]=$x3;
  $a[2][2]=1;

  $b[0]=$_POST['y1'];
  $b[1]=$_POST['y2'];
  $b[2]=$_POST['y3'];

  function imprimirMatriz($matriz,$b){
  for($i=0;$i<sizeof($matriz);$i++){
    for($j=0;$j<sizeof($matriz);$j++){
      echo $matriz[$i][$j]."a".($j+1);
      if($j<sizeof($matriz)-1)echo " + ";
    }
    echo " = ".$b[$i]."<br>";
  }
  }


  function eliminacionGaussiana(){
  global $a;
  global $b;
  for ($i = 0; $i < sizeof($a)-1; $i++) {
             for ($j = $i+1; $j < sizeof($a); $j++) {
                 $mik=$a[$j][$i]/$a[$i][$i];
                 for ($k = 0; $k < sizeof($a); $k++) {
                     $a[$j][$k]=$a[$j][$k]-$mik*$a[$i][$k];
                 }
                 $b[$j]=$b[$j]-$mik*$b[$i];
             }
         }
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

          for($i = 0; $i < sizeof($x) ; $i++){
            echo "a".($i+1)." = ".$x[$i]."<br>";
          }

          echo "<br>y = ".$x[0]."x^2 + ".$x[1]."x + ".$x[2]."<br>";
    }

  imprimirMatriz($a,$b);
  echo "<br>";
  eliminacionGaussiana();
}
  ?>
</div>
</body>
</html>
