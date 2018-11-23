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

 $sql = "CREATE TABLE Papeleria (
 idPapeleria VARCHAR(16) PRIMARY KEY,
 NombreP VARCHAR(16) NOT NULL
  )";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
