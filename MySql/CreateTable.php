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
 Nombre VARCHAR(16) NOT NULL,
// Apellido VARCHAR(16) NOT NULL,
 Telefono VARCHAR(16),
 Direccion VARCHAR(32),
 NumeroDeCompras INT(6),
 idGarante VARCHAR(16)
 )";


// $sql = "CREATE TABLE Empleado(
// idEmpleado VARCHAR(16) PRIMARY KEY,
// Nombre VARCHAR(16) NOT NULL,
// Apellido VARCHAR(16) NOT NULL,
// Telefono VARCHAR(16),
// Direccion VARCHAR(32)
// )";
// $sql = "CREATE TABLE Factura(
// idFactura VARCHAR(16) PRIMARY KEY,
// PrecioTotal INT(8) NOT NULL,
// CantidadTotal INT(4) NOT NULL,
// FechaFactura DATE,
// idEmpleado VARCHAR(16) NOT NULL,
// idCliente VARCHAR(16) NOT NULL,
// FOREIGN KEY (idEmpleado) REFERENCES Empleado(idEmpleado),
// FOREIGN KEY (idCliente) REFERENCES Cliente(idCliente)
// )";
//$sql = "CREATE TABLE Detalle(
//idDetalle VARCHAR(16) PRIMARY KEY,
//SubTotal INT(8) NOT NULL,
//Cantidad INT(4) NOT NULL,
//idFactura VARCHAR(16) NOT NULL,
//idProducto VARCHAR(16) NOT NULL,
//FOREIGN KEY (idFactura) REFERENCES Factura(idFactura),
//FOREIGN KEY (idProducto) REFERENCES Producto(idProducto)
//)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
