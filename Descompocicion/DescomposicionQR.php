<html>
<head>
<title>Descomposicion QR</title>
</head>
<link rel="stylesheet" href="css/stylesG.css">
<body>
  <div class="main">
  	<h1>Descomposicion QR</h1>
  </div>

<div class="Input">
  <form action="DescomposicionQR.php" method="post">
    <p>
      a[0][0]: <input type="number" name="a00" value="1" step="1" />
      a[0][1]: <input type="number" name="a01" value="-1" step="1" />
      a[0][2]: <input type="number" name="a02" value="3" step="1" />
    </p>
    <p>
      a[1][0]: <input type="number" name="a10" value="4" step="1" />
      a[1][1]: <input type="number" name="a11" value="1" step="1" />
      a[1][2]: <input type="number" name="a12" value="-1" step="1" />
    </p>
    <p>
      a[2][0]: <input type="number" name="a20" value="2" step="1" />
      a[2][1]: <input type="number" name="a21" value="-1" step="1" />
      a[2][2]: <input type="number" name="a22" value="3" step="1" />
    </p>
    <p>
      b[0]: <input type="number" name="b0" value="11" step="1" />
      b[1]: <input type="number" name="b1" value="-4" step="1" />
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

  $id[0][0]=1;
  $id[0][1]=0;
  $id[0][2]=0;
  $id[1][0]=0;
  $id[1][1]=1;
  $id[1][2]=0;
  $id[2][0]=0;
  $id[2][1]=0;
  $id[2][2]=1;

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

function proyeccion($v,$u){
  $num=0;
  $div=0;
  for($i=0;$i<3;$i++){
    $num=$num+$v[$i]*$u[$i];
    $div=$div+$u[$i]*$u[$i];
  }
  for($i=0;$i<3;$i++){
    $u[$i]=$u[$i]*($num/$div);
  }
  return $u;
}

function descompocicionQR(){
global $a;
global $b;
global $id;
$b1=$b;
for ($i = 0; $i < sizeof($a)-1; $i++) {
           for ($j = $i+1; $j < sizeof($a); $j++) {
               $mik=$a[$j][$i]/$a[$i][$i];
               for ($k = 0; $k < sizeof($a); $k++) {
                   $a[$j][$k]=$a[$j][$k]-$mik*$a[$i][$k];
                   $id[$j][$k]=$id[$j][$k]-$mik*$id[$i][$k];
               }
               $b[$j]=$b[$j]-$mik*$b[$i];
           }
       }
       echo "Matriz R<br>";
       imprimirMatriz($a);
       echo "<br>";

       $v1[0]=$id[0][0];
       $v1[1]=$id[1][0];
       $v1[2]=$id[2][0];
       $v2[0]=$id[0][1];
       $v2[1]=$id[1][1];
       $v2[2]=$id[2][1];
       $v3[0]=$id[0][2];
       $v3[1]=$id[1][2];
       $v3[2]=$id[2][2];
       for($i=0;$i<3;$i++){
         $u1[$i]=$v1[$i];
         $u2[$i]=0;
         $u3[$i]=0;
       }
       $u2=proyeccion($u1,$v2);
       for($i=0;$i<3;$i++){
         $u2[$i]=$v2[$i]-$u2[$i];
       }
       $aux=proyeccion($u1,$v3);
       $u3=proyeccion($u2,$v3);
       for($i=0;$i<3;$i++){
         $u3[$i]=$v3[$i]-$aux[$i]-$u3[$i];
       }
       $resp;
       for($i=0;$i<3;$i++){
         $resp[$i][0]=$u1[$i];
         $resp[$i][1]=$u2[$i];
         $resp[$i][2]=$u3[$i];
       }
       echo "Matriz Q<br>";
       imprimirMatriz($resp);
  }
echo "Matriz original<br>";
imprimirMatriz($a);
echo "<br>";
descompocicionQR();
}
?>
</div>


</body>
</html>
