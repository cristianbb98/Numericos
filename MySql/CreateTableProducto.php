<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "papeleria";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 $sql = "CREATE TABLE Producto (
 idProducto VARCHAR(16) PRIMARY KEY,
 Descripcion VARCHAR(16) NOT NULL,
 Marca VARCHAR(16) NOT NULL,
 Nombre VARCHAR(16),
 Stock INT(6),
 Papeletria VARCHAR(16)
 )";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
