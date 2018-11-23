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

 $sql = "CREATE TABLE Empleado(
 idEmpleado VARCHAR(16) PRIMARY KEY,
 Nombre VARCHAR(16) NOT NULL,
 Apellido VARCHAR(16) NOT NULL,
 Telefono VARCHAR(16),
 Direccion VARCHAR(32),
 Papeleria VARCHAR(16) REFERENCES Empleado(idPapeleria)
 )";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
