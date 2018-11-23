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

 $sql = "CREATE TABLE Cliente (
 idCliente VARCHAR(16) PRIMARY KEY,
 NombreC VARCHAR(16) NOT NULL,
 ApellidoC VARCHAR(16) NOT NULL,
 TelefonoC VARCHAR(16),
 DireccionC VARCHAR(32),
 NumeroDeCompras INT(6),
 idGarante VARCHAR(16)
 )";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
