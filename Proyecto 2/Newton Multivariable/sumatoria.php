<html>
<head>
  <title>Sumatorio</title>
<style>
body{
  text-align: center;
  font-size: 20px;
}
</style>
</head>
<body>
  <form action="sumatoria.php" method="post">
    <p>
      xi = <input type="string" name="x" value="1,2,3,4,5" />
      yi = <input type="string" name="y" value="5,1,4,2,3" />
    </p>
    <p><input type="submit" value="Cargar" /></p>
  </form>
<?php
if(isset($_POST['x'])&&isset($_POST['y'])){
$s="1/(1+d*(x-)^2)+c/(1+d*(x-z-l)^2)";
echo "<br>".$s."<br>";
function derivard($s){
  $s1=$s;
  $s=str_replace('d','(d+h)',$s);
  $s1=str_replace('d','(d-h)',$s1);
  $s='(('.$s.')-('.$s1.'))/(2*h)';
  return $s;

}
function derivarl($s){
  $s1=$s;
  $s=str_replace('l','(l+h)',$s);
  $s1=str_replace('l','(l-h)',$s1);
  $s='(('.$s.')-('.$s1.'))/(2*h)';
  return $s;
}
function derivarC($s){
  $s1=$s;
  $s=str_replace('c','(c+h)',$s);
  $s1=str_replace('c','(c-h)',$s1);
  $s='(('.$s.')-('.$s1.'))/(2*h)';
  return $s;
}

$xa=$_POST['x'];
$ya=$_POST['y'];
$x = preg_split("/[\s,]+/", $xa);
$y = preg_split("/[\s,]+/", $ya);

$sa="";

for($i=0;$i<sizeof($x);$i++){
$s=str_replace('l','(l+h)',$s);
$sa=$sa."+(".$x[$i]."-".$y[$i].")";
}
echo "<br>".$sa;
}
?>
</body>
</html>
