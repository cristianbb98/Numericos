<?php

function f($x){
	return $x*$x -4;
} 

function trapecio($a,$b,$n){
$h=abs(($b-$a)/$n);
$area=0;
for($i=1;$i<$n-1;$i++){
$area=$area+(f($a+($i*$h)));
}
return $h*((f($a)/2)+$area+(f($b)/2));
}

$a=-2;
$b=2;
$error=pow(10,-8);
$n=3;
$inte1=trapecio($a,$b,2);
$inte2=trapecio($a,$b,$n);
while(true){
if(abs($inte1-$inte2)<$error){
echo "n=".$n."<br>";
echo "Area igual a ".$inte2."<br>";
echo "Error ".abs($inte1-$inte2);
break;
}
$n=$n+1;
$inte1=$inte2;
$inte2=trapecio($a,$b,$n);
}

?>