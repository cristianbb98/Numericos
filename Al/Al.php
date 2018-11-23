<html>
<body>

  <form action="Al.php" method="post">
    <p>Estimado inicial 1: <input type="number" name="estimado0" step="0.01" /></p>
    <p>Estado inicial 2: <input type="number" name="estimado1" /></p>
    <p>Numero de intervalos: <input type="number" name="inter" /></p>
    <p><input type="submit" value="calcular" /></p>
  </form>
  <?php
    #funcion = x^2 - 4

    if(isset($_POST['estimado0']) && isset($_POST['estimado1']) && isset($_POST['inter'])){
      $x0=$_POST['estimado0'];
      $x1=$_POST['estimado1'];
      $inter=$_POST['inter'];

          $tam = ($x1-$x0)/$inter;

          for($i = 0 ; $i<$inter ; $i++){
            $a=$x0+($tam*$i);
            $b=$x0+($tam*($i+1));
            $f0=pow($a,2)-4;
            $f1=pow($b,2)-4;
            $kmax=log((($a-$b)/pow(10,-8)),2)-1;
            if($f0*$f1 < 0){
              $x=($a+$b)/2;
              $raiz = newton(($a+$b)/2,$kmax);
            }
          }

    }

    function newton($x1,$kmax){
      $n=1;
      $k=0;
      $fd=derivarF($x1);
      $resp = $x1;
      while((pow($x1,2)-4) > 0.00000001){
        $k=$k+1;
        $f=pow($x1,2)-4;
        $fd=derivarF($x1);
        if($fd == 0){
          exit("E1: Derivada nula\n");
        }
        $xk=$x1-($n*$f/$fd);
        if((pow($x1,2)-4) < 0.000000001){
          $resp = $xk;
          break;
        }
        $x1=$xk;
        if($k==$kmax){
          exit("E2: No converge en $k iteraciones");
        }
      }
      echo "Respuesta es $x1" . '</br>' ;
      echo "En $k iteraciones";
    }



    function derivarF($X){
      $dt=0.0000001;
        $resp = ((pow($X+$dt,2) - 4)-(pow($X-$dt,2) - 4))/($dt * 2);
      return $resp;
    }


   ?>
</body>

</html>
