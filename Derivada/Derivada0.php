        <?php

		function f($x){
			return 1/$x;
		}
        echo "Derivada de y = 1/x en el punto x = 0.001<br><br>";

		/*function DiferenciaAtrasadas(){
            $n1=0.1;
            $x=1;
			$error=1;
			echo "Por medio del diferencia atrasada:<br>";
            while($error>0.00000001||$error==0){
                $dif=(f($x)-f($x-$n1))/$n1;
				$n1=$n1/2;
				$error=abs(abs($dif)-2);
            }
            echo $dif."<br>".$n1."<br><br>";
        }
*/
        function DiferenciaCentrada(){
			$n1=1;
      $x=2;
			$error=1;
			echo "Por medio del diferencia centrada:<br>";
            while($error>0.00000001||$error==0){
                $dif=(f($x+$n1)-f($x-$n1))/($n1*2);
				$n1=$n1/2;
				$error=abs(abs($dif)-2);
			}
            echo $dif."<br>".$n1."<br><br>";
        }

  /*      function DiferenciaAdelantada(){
			$n1=0.1;
            $x=1;
			$error=1;
			echo "Por medio del diferencia adelantada:<br>";
            while($error>0.0000001||$error==0){
                $dif=(f($x+$n1)-f($x))/$n1;
				$n1=$n1/2;
				$error=abs(abs($dif)-2);
			}
            echo $dif."<br>".$n1."<br><br>";
        }
*/
        //DiferenciaAtrasadas();

    DiferenciaCentrada();
		//DiferenciaAdelantada();
        ?>