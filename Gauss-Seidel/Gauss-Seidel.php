<html>
  <head>
    <title>Resolver matrices por Gauss</title>
  </head>
  <link rel="stylesheet" href="css/stylesG.css">
<body>
<div class="encabezado">
  <h1>Gauss-Seidel</h1>
</div>


  <div class="Input">
    <form action="Gauss-Seidel.php" method="post">
      <p>
        a[0][0]: <input type="number" name="a00" value="9" step="1" />
        a[0][1]: <input type="number" name="a01" value="3" step="1" />
        a[0][2]: <input type="number" name="a02" value="1" step="1" />
        b[0]: <input type="number" name="b0" value="13" step="1" />
      </p>
      <p>
        a[1][0]: <input type="number" name="a10" value="1" step="1" />
        a[1][1]: <input type="number" name="a11" value="3" step="1" />
        a[1][2]: <input type="number" name="a12" value="1" step="1" />
        b[1]: <input type="number" name="b1" value="5" step="1" />
      </p>
      <p>
        a[2][0]: <input type="number" name="a20" value="1" step="1" />
        a[2][1]: <input type="number" name="a21" value="3" step="1" />
        a[2][2]: <input type="number" name="a22" value="15" step="1" />
        b[2]: <input type="number" name="b2" value="40" step="1" />
      </p>
      <p><input type="submit" value="Cargar" /></p>
    </form>
  </div>

<div class="php">
<?php

if(isset($_POST['a00']) && isset($_POST['a01']) && isset($_POST['a02'])
&& isset($_POST['a10']) && isset($_POST['a11']) && isset($_POST['a12'])
&& isset($_POST['a20']) && isset($_POST['a21']) && isset($_POST['a22'])
&& isset($_POST['b0']) && isset($_POST['b1']) && isset($_POST['b2'])){

  $a[0][0]=$_POST['a00'];
  $a[0][1]=$_POST['a01'];
  $a[0][2]=$_POST['a02'];
  $a[1][0]=$_POST['a10'];
  $a[1][1]=$_POST['a11'];
  $a[1][2]=$_POST['a12'];
  $a[2][0]=$_POST['a20'];
  $a[2][1]=$_POST['a21'];
  $a[2][2]=$_POST['a22'];

  $b[0]=$_POST['b0'];
  $b[1]=$_POST['b1'];
  $b[2]=$_POST['b2'];

  for($i=0;$i<3;$i++){
    $xi[$i]=1;
  }
  function imprimirMatriz($matriz,$b){
  for($i=0;$i<sizeof($matriz);$i++){
    for($j=0;$j<sizeof($matriz);$j++){
      echo " ".$matriz[$i][$j]." ";
    }
    echo " | ".$b[$i]."<br>";
  }
  }
  function imprimirVector($vector){
  for($i=0;$i<sizeof($vector);$i++){
      echo "  ".$vector[$i]." ";
  }
  }
  imprimirMatriz($a,$b);
  do{
    echo "<br>";
    $x0=$xi;
    for ($i = 0; $i <= sizeof($a)-1 ; $i++) {
           $suma=0;
           for ($j = 0; $j < sizeof($a); $j++) {
             if($i==$j)continue;
             if($i==0){
               $suma = $suma+$a[$i][$j]*$x0[$j];
             }else if($i==1 && $j==0){
               $suma = $suma+$a[$i][$j]*$xi[$j];
             }else if($i==1 && $j==2){
               $suma = $suma+$a[$i][$j]*$x0[$j];
             }else{
               $suma = $suma+$a[$i][$j]*$xi[$j];
             }
           }
           $xi[$i]=(1/$a[$i][$i])*($b[$i]-$suma);
    }
    for($i=0;$i<sizeof($xi);$i++){
        echo "x[".($i+1)."] = ".$xi[$i]."<br>";
    }
    echo "<br>";
  }while((($xi[0]-$x0[0])!=0)||(($xi[1]-$x0[1])!=0)||(($xi[2]-$x0[2])!=0)) ;
  echo "<br>";
}
  ?>
</div>
</body>
</html>
