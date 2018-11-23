<html>
<head>
<style>
body{
  text-align: center;
  display: table;
  margin: auto;
}

table, td, th {
    border: 1px solid #ddd;
    text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 10px;
    text-align: left;
}
</style>
</head>
<body>
<br><h1>Tabla Produco</h1><br>
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

  $sql = "SELECT * FROM Producto";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      echo "<table><tr><th>idProducto</th><th>NombreP</th><th>Marca</th><th>Stock</th><th>Descripcion</th></tr>";
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row["idProducto"]."</td><td>".$row["NombreP"]."</td><td>".$row["Marca"]."</td><td>".$row["Stock"]."</td><td>".$row["Descripcion"]."</td></tr>";
      }
      echo "</table>";
  } else {
      echo "0 results";
  }
  $conn->close();
  ?>
</body>
</html>
