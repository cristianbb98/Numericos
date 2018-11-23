<?php

function f($x){
	return $x*$x -4;
} 

function simpson($a,$b,$n){
$h=abs(($b-$a)/$n);
$areapar=0;
$areaimpar=0;

for($i=1;$i<($n/2);$i++){
$areaimpar=$areaimpar+(f($a+((2*$i-1)*$h)));
}

for($i=1;$i<(($n/2)-1);$i++){
$areapar=$areapar+(f($a+(2*$i*$h)));
}

return ($h/3)*(f($a)+4*$areapar+2*$areaimpar+f($b));
}

$a=-2;
$b=2;
$error=pow(10,-5);
$n=3;
$inte1=simpson($a,$b,2);
$inte2=simpson($a,$b,$n);
while(true){
if(abs($inte1-$inte2)<$error){
echo "n=".$n."<br>";
echo "Area igual a ".$inte2."<br>";
echo "Error ".abs($inte1-$inte2);
break;
}
$n=$n+1;
$inte1=$inte2;
$inte2=simpson($a,$b,$n);
}

?>