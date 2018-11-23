<?php

echo "Descompocicion LU<br>";

$a[0][0]=3;
$a[0][1]=2;
$a[0][2]=4;
$a[1][0]=1;
$a[1][1]=4;
$a[1][2]=5;
$a[2][0]=6;
$a[2][1]=7;
$a[2][2]=8;

$id[0][0]=1;
$id[0][1]=0;
$id[0][2]=0;
$id[1][0]=0;
$id[1][1]=1;
$id[1][2]=0;
$id[2][0]=0;
$id[2][1]=0;
$id[2][2]=1;


$b[0]=3;
$b[1]=2;
$b[2]=4;

function imprimirMatriz($matriz){
for($i=0;$i<sizeof($matriz);$i++){
  for($j=0;$j<sizeof($matriz);$j++){
    echo $matriz[$i][$j]." ";
  }
  echo "<br>";
}
}


function eliminacionGaussiana(){
global $a;
global $b;
global $id;
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

       imprimirMatriz($a);
       echo "<br>";
       imprimirMatriz($id);
       echo "<br>";
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
          echo "x[".$i."] = ".$x[$i]."<br>";
        }
  }



imprimirMatriz($a);
echo "<br>";
eliminacionGaussiana();

?>
