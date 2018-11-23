<?php
$a[0][0]=25;
$a[0][1]=5;
$a[0][2]=1;
$a[1][0]=1;
$a[1][1]=1;
$a[1][2]=1;
$a[2][0]=36;
$a[2][1]=6;
$a[2][2]=1;


$b[0]=3;
$b[1]=4;
$b[2]=2;

function imprimirMatriz($matriz){
  echo "<center><table>";
for($i=0;$i<sizeof($matriz);$i++){
    echo "
        <tr>
          <th align=center width=40 style=border:1px solid black>".$matriz[$i][0]."</th>
          <th align=center width=40 style=border:1px solid black>".$matriz[$i][1]."</th>
          <th align=center width=40 style=border:1px solid black>".$matriz[$i][2]."</th>
        </tr>";
}
echo "</table></center>";
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

       imprimirMatriz($a);
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
