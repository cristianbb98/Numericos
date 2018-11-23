<html>
<body>
<h1>SPLINES CÚBICOS</h1>
<form action="" method="post">
    <input type="submit" name="submit" value="Calcular"/><br>
</form>
<h3>Puntos:</h3>


<?php

    function splinesCuadraticos(){
        $x=puntosX();
        $y=puntosY();
        $n=sizeof($x); //numero de puntos
        imprimirVector($n, $x, "Puntos en X", 0 , $n-1);
        imprimirVector($n, $y, "Puntos en Y", 0 , $n-1);
        //PASO 1
        echo "<b>**PASO 1**</b><br>";
        echo "<br>";
        $h = h($x, $n);
        imprimirVector(sizeof($h), $h, "H", 1 , $n-1);
        $sigma = sigma($y, $n, $h);
        imprimirVector(sizeof($sigma), $sigma, "SIGMA", 1 , $n-1);
        $landa = landa($h, $n);
        imprimirVector(sizeof($landa), $landa, "LANDA", 1 , $n-2);
        $miu = miu($h, $n);
        imprimirVector(sizeof($miu), $miu, "MIU", 1 , $n-2);
        $d = d($sigma, $h, $n);
        imprimirVector(sizeof($d), $d, "D", 1 , $n-2);

        echo "<b>**PASO 2**</b><br>";
        echo "<br>";
        $matriz = generarMatriz(sizeof($landa), $landa, $miu);
        imprimirMatriz(sizeof($landa), $matriz, "Matriz");
        $vectorM = thomas(sizeof($d), $matriz, $d);
        imprimirVector(sizeof($vectorM), $vectorM, "Vector M", 1, $n-2);

        echo "<b>**PASO 3**</b><br>";
        echo "<br>";
        $r = r($n, $vectorM, $h);
        imprimirVector(sizeof($r), $r, "R", 1, $n-1);
        $s = s($n, $vectorM, $h);
        imprimirVector(sizeof($s), $s, "S", 1, $n-1);
        $t = t($n, $vectorM, $h, $y);
        imprimirVector(sizeof($t), $t, "T", 1, $n-1);
        $u = u($n, $vectorM, $h, $y);
        imprimirVector(sizeof($u), $u, "U", 1, $n-1);

        echo "<b>**PASO 4**</b><br>";
        echo "<br>";
        $v = v($n, $s, $r);
        imprimirVector(sizeof($v), $v, "V", 1, $n-1);
        $w = w($n, $s, $r, $x);
        imprimirVector(sizeof($w), $w, "W", 1, $n-1);
        $f = f($n, $s, $r, $x, $u, $t);
        imprimirVector(sizeof($f), $f, "F", 1, $n-1);
        $g = g($n, $s, $r, $x, $u, $t);
        imprimirVector(sizeof($g), $g, "G", 1, $n-1);

        //Polinomios de 3 grado
        echo "<b>**LOS POLINOMIOS SON: **</b><br>";
        echo "<br>";
        $vectorPolinomio = polinomios($n, $v, $w, $f, $g);
        imprimirVector(sizeof($vectorPolinomio), $vectorPolinomio, "POLINOMIOS", 1, $n-1);
    }

    function puntosX(){
        $x = array(1,2,3,4,5);
        return $x;
    }

    function puntosY(){
        $y = array(5,1,4,2,3);
        return $y;
    }

    function h ($x,$n){
        $h = array();
        for($i=1; $i<$n; $i++){
            $h[$i]= $x[$i] - $x[$i-1];
        }
        return $h;
    }

    function sigma ($y, $n, $h){
        $sigma = array();
        for($i=1; $i<$n; $i++){
            $sigma[$i]= ($y[$i] - $y[$i-1])/($h[$i]);
        }
        return $sigma;
    }

    function landa ($h, $n){
        $landa = array();
        for($i=1; $i<$n-1; $i++){
            $landa[$i]= ($h[$i+1])/($h[$i] + $h[$i+1]);
        }
        return $landa;
    }

    function miu ($h, $n){
        $miu = array();
        for($i=1; $i<$n-1; $i++){
            $miu[$i]= ($h[$i])/($h[$i] + $h[$i+1]);
        }
        return $miu;
    }

    function d ($sigma, $h, $n){
        $d = array();
        for($i=1; $i<$n-1; $i++){
            $d[$i]= (6*($sigma[$i+1] - $sigma[$i]))/($h[$i] + $h[$i+1]);
        }
        return $d;
    }

    function generarMatriz($n, $landa, $miu){
        $matriz = array();
        for($i=0; $i<$n; $i++){
            for($j=0; $j<$n; $j++){
                if($i==$j){
                    $matriz[$i][$j]=2;
                } else if($i-$j==-1){
                    $matriz[$i][$j]=$landa[$i+1];
                }else if($i-$j==1){
                    $matriz[$i][$j]=$miu[$i+1];
                }
                else {
                    $matriz[$i][$j]=0;
                }
            }
        }
        return $matriz;
    }

    function thomas($n, $matriz, $arrayB){
        $matrizM = array();
        for($i=1; $i<$n; $i++){
            $matriz[$i][$i] = $matriz[$i][$i] - (($matriz[$i][$i-1] * $matriz[$i-1][$i])/$matriz[$i-1][$i-1]);
            $arrayB[$i+1] = $arrayB[$i+1] - (($matriz[$i][$i-1] * $arrayB[$i])/$matriz[$i-1][$i-1]);
            $matriz[$i][$i-1] = 0;
            $matrizM[$n] = $arrayB[$n]/$matriz[$n-1][$n-1]; //se actualiza segun las matrices a y b
        }
        //queda matriz triangular inferior
        for($k=$n-1; $k>=1; $k--){
            $matrizM[$k] = ($arrayB[$k]-($matriz[$k-1][$k] * $matrizM[$k+1]))/$matriz[$k-1][$k-1];
        }
        return $matrizM;
    }

    function r($n, $M, $h){
        $r= array();
        for($i=1; $i<$n; $i++){
            if($i-1==0) $M[$i-1]=0;
            $r[$i]= ($M[$i-1])/(6*$h[$i]);
        }
        return $r;
    }

    function s($n, $M, $h){
        $s= array();
        for($i=1; $i<$n; $i++){
            if($i==4) $M[$i]=0;
            $s[$i]= ($M[$i])/(6*$h[$i]);
        }
        return $s;
    }

    function t($n, $M, $h, $y){
        $t= array();
        for($i=1; $i<$n; $i++){
            if($i-1==0) $M[$i-1]=0;
            $t[$i]= ($y[$i-1]-($M[$i-1] * (pow($h[$i], 2)/6)))/ $h[$i];
        }
        return $t;
    }

    function u($n, $M, $h, $y){
        $u= array();
        for($i=1; $i<$n; $i++){
            if($i==4) $M[$i]=0;
            $u[$i]= ($y[$i]-($M[$i] * (pow($h[$i], 2)/6)))/ $h[$i];
        }
        return $u;
    }

    function v ($n, $s, $r){
        $v = array();
        for($i=1; $i<$n; $i++){
            $v[$i]= $s[$i] - $r[$i];
        }
        return $v;
    }

    function w ($n, $s, $r, $x){
        $w = array();
        for($i=1; $i<$n; $i++){
            $w[$i]= 3*($r[$i]*$x[$i] - $s[$i]*$x[$i-1]);
        }
        return $w;
    }

    function f ($n, $s, $r, $x, $u, $t){
        $f = array();
        for($i=1; $i<$n; $i++){
            $f[$i]= 3*($s[$i]*pow($x[$i-1],2) - $r[$i]*pow($x[$i],2)) + $u[$i] - $t[$i];
        }
        return $f;
    }

    function g ($n, $s, $r, $x, $u, $t){
        $g = array();
        for($i=1; $i<$n; $i++){
            $g[$i]= $x[$i]*($r[$i]*pow($x[$i],2) + $t[$i]) - $x[$i-1]*($s[$i]*pow($x[$i-1],2) + $u[$i]);
        }
        return $g;
    }


    function imprimirMatriz($n,$matriz,$string){
        echo '<table cellspacing="0" cellpadding="0">';
        echo "<b>".$string."</b><br>";
        for($i=0; $i<$n; $i++){
            echo '<tr>';
            for($j=0; $j<$n; $j++){
                echo '<td align="center" width="40" style="border:1px solid black">['.$i.','.$j.']</td>';
                echo '<td align="center" width="40" style="border:1px solid black">'.$matriz[$i][$j].'</td>';
            }
            //'</tr>';
        }
        echo '</table>';
        echo "<br>";
    }
    function imprimirVector($n,$array,$string, $comienzo, $fin){
        echo '<table cellspacing="0" cellpadding="0">';
        echo "<b>".$string."</b><br>";
        for($i=$comienzo; $i<=$fin; $i++){
            echo '<tr>';
            echo '<td align="center" width="40" style="border:1px solid black">['.$i.']</td>';
            echo ('<td align="center" width="80" style="border:1px solid black">'.$array[$i].'</td>');
            echo '</tr>';
        }
        echo '</table>';
        echo "<br>";
    }

    function polinomios($n, $v, $w, $f, $g){
        $polinomio = array();
        for($i=1; $i<$n; $i++){
            $polinomio[$i]=$v[$i]."x^3 + ".$w[$i]."x^2 + ".$f[$i]."x + ".$g[$i];
        }
        return $polinomio;
    }


    if(isset($_POST['submit'])){
        splinesCuadraticos();
    }

?>

</body>
</html>
