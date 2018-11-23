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


 $sql = "CREATE TABLE Factura(
 idFactura VARCHAR(16) PRIMARY KEY,
 PrecioTotal INT(8) NOT NULL,
 CantidadTotal INT(4) NOT NULL,
 FechaFactura DATE,
 idEmpleado VARCHAR(16) NOT NULL,
 idCliente VARCHAR(16) NOT NULL,
 FOREIGN KEY (idEmpleado) REFERENCES Empleado(idEmpleado),
 FOREIGN KEY (idCliente) REFERENCES Cliente(idCliente)
 )";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
