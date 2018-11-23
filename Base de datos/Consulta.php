<html>
<head>
</head>
<link rel="stylesheet" href="css/stylesG.css">
<body>

    <?php
  $xml = simplexml_load_file("Libros.xml");
  $titulos = $xml->xpath('/librosLeidos/book/title');
  $mayorQues = $xml->xpath('/librosLeidos/book[precio>12]/title');
  $dosp = $xml->xpath('/librosLeidos/book[position()<3]/title');
  echo "<br>Titulos de los libros almacenados<br><br>";
  foreach($titulos as $titulo) {
    echo $titulo."<br />";
  }
  echo "<br>";
  foreach($mayorQues as $mayorQue) {
    echo $mayorQue."<br />";
  }
  echo "<br>";



    ?>

</body>
</html>
