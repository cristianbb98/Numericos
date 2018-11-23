<?php
$string = <<<XML
<book nombre="Cien años de soledad">
  <title lang="es">Cien Anos de Soledad</title>
  <autor>Gabriel Garcia Marquez</autor>
  <isbn>9780307474728</isbn>
  <año>1967</año>
  <paginas>496</paginas>
  <precio>13.41</precio>
</book>
XML;

$xml = new SimpleXMLElement($string);

/* Busca <a><b><c> */
$resultado = $xml->xpath('/book/title');

while(list( , $nodo) = each($resultado)) {
    echo $nodo,"<br>";
}

/* Rutas relativas también funcionan... */
$resultado = $xml->xpath('b/c');

while(list( , $nodo) = each($resultado)) {
    echo 'b/c: ',$nodo,"\n";
}
?>
