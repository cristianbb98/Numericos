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

 $sql = "CREATE TABLE Detalle(
idDetalle VARCHAR(16) PRIMARY KEY,
SubTotal INT(8) NOT NULL,
Cantidad INT(4) NOT NULL,
idFactura VARCHAR(16) NOT NULL,
idProducto VARCHAR(16) NOT NULL,
FOREIGN KEY (idFactura) REFERENCES Factura(idFactura),
FOREIGN KEY (idProducto) REFERENCES Producto(idProducto)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
