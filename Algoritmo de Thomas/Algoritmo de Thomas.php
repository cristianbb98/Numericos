<html>
  <head>
    <title>Resolver matrices por Gauss</title>
  </head>
  <link rel="stylesheet" href="css/stylesG.css">
<body>
<div class="encabezado">
  <h1>Algoritmo de Thomas</h1>
</div>

  <div class="Input">
    <form action="Algoritmo de Thomas.php" method="post">
      <p>
        a[0][0]: <input type="number" name="a00" value="9" step="1" />&emsp;
        a[0][1]: <input type="number" name="a01" value="3" step="1" />&emsp;
        d[0]: <input type="number" name="d0" value="3" step="1" />
      </p>
      <p>
        a[1][0]: <input type="number" name="a10" value="1" step="1" />
        a[1][1]: <input type="number" name="a11" value="3" step="1" />
        a[1][2]: <input type="number" name="a12" value="1" step="1" />
        d[1]: <input type="number" name="d1" value="1" step="1" />
      </p>
      <p>
        a[2][0]: <input type="number" name="a21" value="7" step="1" />
        a[2][1]: <input type="number" name="a22" value="5" step="1" />
        a[2][2]: <input type="number" name="a23" value="4" step="1" />
        d[2]: <input type="number" name="d2" value="1" step="1" />
      </p>
      <p>
        a[3][0]: <input type="number" name="a32" value="2" step="1" />
        a[3][1]: <input type="number" name="a33" value="3" step="1" />
        a[3][2]: <input type="number" name="a34" value="9" step="1" />
        d[3]: <input type="number" name="d3" value="5" step="1" />
      </p>
      <p>
        a[4][0]: <input type="number" name="a43" value="5" step="1" />&emsp;
        a[4][1]: <input type="number" name="a44" value="3" step="1" />&emsp;
        d[4]: <input type="number" name="d4" value="7" step="1" />
      </p>
      <p><input type="submit" value="Cargar" /></p>
    </form>
  </div>

<div class="php">
<?php
if(isset($_POST['a00']) && isset($_POST['a01'])
&& isset($_POST['a10']) && isset($_POST['a11']) && isset($_POST['a12'])
&& isset($_POST['a21']) && isset($_POST['a22']) && isset($_POST['a23'])
&& isset($_POST['a32']) && isset($_POST['a33']) && isset($_POST['a34'])
&& isset($_POST['a43']) && isset($_POST['a44'])
&& isset($_POST['d0']) && isset($_POST['d1']) && isset($_POST['d2'])&& isset($_POST['d3'])&& isset($_POST['d4'])
){

  for($i=0;$i<5;$i++){
    for($j=0;$j<5;$j++){
      $a[$i][$j]=0;
    }
  }

  $a[0][0]=$_POST['a00'];
  $a[0][1]=$_POST['a01'];
  $d[0]=$_POST['d0'];

  $a[1][0]=$_POST['a10'];
  $a[1][1]=$_POST['a11'];
  $a[1][2]=$_POST['a21'];
  $d[1]=$_POST['d1'];

  $a[2][1]=$_POST['a21'];
  $a[2][2]=$_POST['a22'];
  $a[2][3]=$_POST['a23'];
  $d[2]=$_POST['d2'];

  $a[3][2]=$_POST['a32'];
  $a[3][3]=$_POST['a33'];
  $a[3][4]=$_POST['a34'];
  $d[3]=$_POST['d3'];

  $a[4][3]=$_POST['a43'];
  $a[4][4]=$_POST['a44'];
  $d[4]=$_POST['d4'];

  function imprimirMatriz($matriz,$d){
    $input="";
    for($i=0;$i<sizeof($matriz);$i++){
      for($j=0;$j<sizeof($matriz);$j++){
        $input=$input+$matriz[$i][$j];
        echo round($matriz[$i][$j],2).'&nbsp &nbsp';
      }
      echo " | ".round($d[$i],2)."<br>";
    }
  }

 function imprimirVector1($vector){
    for($i=0;$i<sizeof($vector);$i++){
      echo $vector[$i]."&emsp;";
    }
    echo "<br>";
  }

  imprimirMatriz($a,$d);

  $b[sizeof($a)-1]=0;
  $q[0]=0;
  for($i=0;$i<sizeof($a);$i++){
    $b[$i]=$a[$i][$i];
  }
  for($i=0;$i<sizeof($a)-1;$i++){
    $c[$i]=$a[$i][$i+1];
  }
  for($i=0;$i<sizeof($a)-1;$i++){
    $q[$i+1]=$a[$i+1][$i];
  }
  function thomas($a,$b,$c,$d){
    $c[0]=$c[0]/$b[0];
    $d[0]=$d[0]/$b[0];
    for($i=1;$i<sizeof($b)-1;$i++){
      $c[$i]=$c[$i]/($b[$i]-$c[$i-1]*$a[$i]);//$b[$i]-$c[$i-1]*$a[$i]
    }
    for($i=1;$i<sizeof($a);$i++){
      $d[$i]=($d[$i]-$d[$i-1]*$a[$i])/($b[$i]-$a[$i]*$c[$i-1]);
    }
    for($i=0;$i<sizeof($a)-1;$i++){
      $x[$i]=0;
    }
    $x[sizeof($a)-1]=$d[sizeof($a)-1];
    for($i=(sizeof($a)-2);$i>=0;$i--){
      $x[$i]=$d[$i]-$x[$i+1]*$c[$i];
    }
    for($i=0;$i<sizeof($a);$i++){
      for($j=0;$j<sizeof($a);$j++){
        if($i==$j){
          $res[$i][$j]=1;

        }else{
          $res[$i][$j]=0;
        }
      }
    }
    for($i=0;$i<sizeof($a)-1;$i++){
    $res[$i][$i+1]=$c[$i];
    }
    echo "<br>";
    imprimirMatriz($res,$d);
    echo "<br>";
    for($i=0;$i<sizeof($a);$i++){
      echo "x[".$i."] = ".round($x[$i],4)."<br>";
    }
  }
  echo "<br>";
  thomas($q,$b,$c,$d);

}
  ?>
</div>
</body>
</html>
