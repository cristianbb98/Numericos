<html>
<head>
<title>Eliminacion Gaussiana</title>
</head>
<link rel="stylesheet" href="css/stylesG.css">
<body>
  <div class="main">
  	<h1>Descompocicion Cholesku</h1>
  </div>

<div class="Input">
  <form action="Descompocicion Cholesky.php" method="post">
    <p>
      a[0][0]: <input type="number" name="a00" value="1" step="1" />
      a[0][1]: <input type="number" name="a01" value="4" step="1" />
      a[0][2]: <input type="number" name="a02" value="2" step="1" />
    </p>
    <p>
      a[1][0]: <input type="number" name="a10" value="4" step="1" />
      a[1][1]: <input type="number" name="a11" value="20" step="1" />
      a[1][2]: <input type="number" name="a12" value="18" step="1" />
    </p>
    <p>
      a[2][0]: <input type="number" name="a20" value="2" step="1" />
      a[2][1]: <input type="number" name="a21" value="18" step="1" />
      a[2][2]: <input type="number" name="a22" value="30" step="1" />
    </p>
    <p>
      b[0]: <input type="number" name="b0" value="11" step="1" />
      b[1]: <input type="number" name="b1" value="4" step="1" />
      b[2]: <input type="number" name="b2" value="10" step="1" />
    </p>
    <p><input type="submit" value="calcular" /></p>
  </form>
</div>
  <div class='php'>
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

function imprimirMatriz($matriz){
for($i=0;$i<sizeof($matriz);$i++){
  for($j=0;$j<sizeof($matriz);$j++){
    echo " ".$matriz[$i][$j].'&nbsp &nbsp';
  }
  echo "<br>";
}
}
function imprimirVector($matriz){
for($i=0;$i<sizeof($matriz);$i++){
    echo " ".$matriz[$i].'&nbsp &nbsp';
}
echo "<br>";
}

function descompocicionCholesku(){
global $a;
global $b;

       echo "Matriz escalonada<br>";
       $var[0]=sqrt($a[0][0]);//a
       $var[1]=$a[1][0]/$var[0];//b
       $var[2]=$a[2][0]/$var[0];//c
       $var[3]=$a[1][1]-$var[1]*$var[1];//d
       $var[3]=sqrt($var[3]);
       $var[4]=($a[2][1]-$var[1]*$var[2])/$var[3] ;//e
       $var[5]=$a[2][2]-$var[4]*$var[4]-$var[2]*$var[2];//f
       $var[5]=sqrt($var[5]);

       imprimirVector($var);
       echo "<br><br>";

       $l[0][0]=$var[0];
       $l[0][1]=0;
       $l[0][2]=0;
       $l[1][0]=$var[1];
       $l[1][1]=$var[3];
       $l[1][2]=0;
       $l[2][0]=$var[2];
       $l[2][1]=$var[4];
        $l[2][2]=$var[5];

       $lt[0][0]=$var[0];
       $lt[0][1]=$var[1];
       $lt[0][2]=$var[2];
       $lt[1][0]=0;
       $lt[1][1]=$var[3];
       $lt[1][2]=$var[4];
       $lt[2][0]=0;
       $lt[2][1]=0;
       $lt[2][2]=$var[5];

       imprimirMatriz($l);
       echo "<br>";
       imprimirMatriz($lt);
       echo "<br>";
  }
echo "Matriz original<br>";
imprimirMatriz($a);
echo "<br>";
descompocicionCholesku();
}
?>
</div>


</body>
</html>
