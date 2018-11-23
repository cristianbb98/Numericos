<html>
<body>
<h1>INTERPOLACION CUADRATICA DADOS 3 PUNTOS</h1>
<h3>Ingrese tres punto en x,y:</h3>
<form action="" method="post">
  <p>
    Punto 1(x,y)= <input type="number" name="x1" value="0" step="0.01"/>&nbsp<input type="number" name="y1" value="0" step="0.01"/>
  </p>
  <p>
    Punto 2(x,y)= <input type="number" name="x2" value="0" step="0.01"/>&nbsp<input type="number" name="y2" value="0" step="0.01"/>
  </p>
  <p>
    Punto 3(x,y)= <input type="number" name="x3" value="0" step="0.01"/>&nbsp<input type="number" name="y3" value="0" step="0.01"/>
  </p>
    <input type="submit" name="submit" value="Calcular"/><br>
</form>


<?php

    function interpolacionCuadratica ($x1, $y1, $x2, $y2, $x3, $y3){
        echo "ECUACIONES CON LOS PUNTOS: <br>";
        for($i=0; $i<3; $i++){
            if($i==0){
                $y = $y1;
                $x=$x1;}
            if($i==1){
                $y = $y2;
                $x=$x2;}
            if($i==2){
                $y = $y3;
                $x=$x3;}
            imprimirEcuacion($x, $y, 'a1', 'a2', 'a3');
        }

        echo "<br>MATRICES GENERADAS: <br>";
        $matriz = generarMatriz($x1,$x2,$x3);
        imprimirMatriz(3,$matriz, "Matriz");
        $vector = generarVetor($y1,$y2,$y3);
        imprimirVector(3,$vector, "Vector");

        $vectorGauss = gauss($matriz, $vector);
        echo "<br>RESULTADO DE GAUSS: <br>";
        imprimirVector(3, $vectorGauss, "Resultado Sistema de Ecuaciones");

        echo "<b><br>ECUACION DE LA CURVA: <br></b>";
        echo "y= ";
        for($i=0; $i<3; $i++){
            $a = $vectorGauss[$i];
            echo number_format($a,3);
            if($i==0) echo "X^2 ";
            if($i==1) echo "X ";
            if($i!=2) echo " + ";
        }

    }

    function generarMatriz($x1,$x2,$x3){
        $matriz = array();
        for($i=0; $i<3; $i++){
            if($i==0) $valor = $x1;
            if($i==1) $valor = $x2;
            if($i==2) $valor = $x3;
            for($j=0; $j<3; $j++){
                if($j==0) $elemento = pow($valor, 2);
                if($j==1) $elemento = pow($valor, 1);
                if($j==2) $elemento = pow($valor, 0);
                $matriz[$i][$j]=$elemento;
            }
        }
        return $matriz;
    }

    function generarVetor($y1,$y2,$y3){
        $vector = array();
        for($i=0; $i<3; $i++){
            if($i==0) $valor = $y1;
            if($i==1) $valor = $y2;
            if($i==2) $valor = $y3;
            $vector[$i]=$valor;
        }
        return $vector;
    }

    function imprimirEcuacion($x, $y, $coef1, $coef2, $coef3){
        echo $y." = ".$x*$x.$coef1." + ".$x.$coef2." + ".$coef3." <br>";
    }


    function gauss($matriz, $arrayB){
        $n=3;
        for($k=0; $k<$n-1; $k++){
            for($i=$k+1; $i<$n; $i++){
                $m=($matriz[$i][$k])/($matriz[$k][$k]);
                for($j=$k+1; $j<$n; $j++){
                    $matriz[$i][$j] =$matriz[$i][$j] - ($m*$matriz[$k][$j]);
                    $matriz[$i][$k]=0;
                }
                $arrayB[$i] = $arrayB[$i] - ($m*$arrayB[$k]); //va fuera porque no depende de j.
            }
        }
        //queda una matriz triangular.
        $matrizX[$n]=array();
        for($k=$n-1; $k>=0; $k--){
            $sumatorio=0;
            for($j=$k+1; $j<=$n-1; $j++){
                $sumatorio = $sumatorio + ($matriz[$k][$j] * $matrizX[$j]);
            }
            $matrizX[$k]=(1/$matriz[$k][$k])*($arrayB[$k]-$sumatorio);
        }
        return $matrizX;
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
    function imprimirVector($n,$array,$string){
        echo '<table cellspacing="0" cellpadding="0">';
        echo "<b>".$string."</b><br>";
        for($i=0; $i<$n; $i++){
            echo '<tr>';
            echo '<td align="center" width="40" style="border:1px solid black">['.$i.']</td>';
            echo ('<td align="center" width="40" style="border:1px solid black">'.$array[$i].'</td>');
            echo '</tr>';
        }
        echo '</table>';
        echo "<br>";
    }


    if(isset($_POST['submit'])){
        $x1=$_POST['x1'];
        $y1=$_POST['y1'];
        $x2=$_POST['x2'];
        $y2=$_POST['y2'];
        $x3=$_POST['x3'];
        $y3=$_POST['y3'];
        interpolacionCuadratica($x1, $y1, $x2, $y2, $x3, $y3);
    }

?>

</body>
</html>
