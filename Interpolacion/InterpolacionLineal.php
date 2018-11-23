<html>
  <head>
    <title>Interpolacion Linea</title>
  </head>
<link rel="stylesheet" href="css/styles.css">
<body>
<div class="encabezado">
  <h1>Interpolacion Lineal</h1>
</div>
  <div class="Input">
    <form action="" method="post">
      <p>
        Punto 1(x,y)= <input type="number" name="x1" value="5" step="0.01"/>&nbsp<input type="number" name="y1" value="3" step="0.01"/>
      </p>
      <p>
        Punto 2(x,y)= <input type="number" name="x2" value="1" step="0.01"/>&nbsp<input type="number" name="y2" value="4" step="0.01"/>
      </p>
        <input type="submit" name="submit" value="Calcular"/><br>
    </form>
  </div>

<div class="php">
<?php
if(isset($_POST['submit'])){
    $x[0]=$_POST['x1'];
    $x[1]=$_POST['x2'];
    $y[0]=$_POST['y1'];
    $y[1]=$_POST['y2'];
    $m=($y[1]-$y[0])/($x[1]-$x[0]);
    $b=$y[0]-$m*$x[0];
    echo "Pendiente: ".$m.", Punto de corte en el eje x: ".$b."<br>";
    echo "y = ".$m."x + ".$b;
}
  ?>
</div>
</body>
</html>
