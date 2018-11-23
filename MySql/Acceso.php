<?php
$pdo = new PDO('mysql:host=localhost;dbname=papeleria;charset=utf8', 'root', '');
$sql = "SELECT idProducto, NombreP FROM producto";
foreach ($pdo->query($sql) as $row) {
   echo $row['idProducto'] . " " . $row['NombreP'] . "<br />";
   
}
?>
