<?php
function f($x){
  return $x*$x-3;
}
function derivada($x){
  $derivada=(f($x+0.000001)-f($x-0.000001))/(2*0.000001);
  return $derivada;
}

function metodoNewton(){
  $aux=0;
  $xk=4;
  $k=1;
  while(f($xk)>0.0000001 || abs($xk-$aux)>0.0000001){
    if(derivada($xk)==0){
      echo "E1. Derivada nula";
      return;
    }
    $aux=$xk;
    $xk=$xk-f($xk)/derivada($xk);
    echo $xk."<br><br>";
    $k++;
    if($k>200){
      echo "No converge";
      break;
    }
  }
  echo "La raiz esta en: ".$xk;
}
metodoNewton();


"CREATE TABLE Cliente (
idCliente VARCHAR(16) PRIMARY KEY,
Nombre VARCHAR(16) NOT NULL,
Apellido VARCHAR(16) NOT NULL,
Telefono VARCHAR(16),
Direccion VARCHAR(32),
NumeroDeCompras INT(6),
idGarante VARCHAR(16)
)";
"CREATE TABLE Empleado(
idEmpleado VARCHAR(16) PRIMARY KEY,
Nombre VARCHAR(16) NOT NULL,
Apellido VARCHAR(16) NOT NULL,
Telefono VARCHAR(16),
Direccion VARCHAR(32)
)";
"CREATE TABLE Factura(
idFactura VARCHAR(16) PRIMARY KEY,
PrecioTotal INT(8) NOT NULL,
CantidadTotal INT(4) NOT NULL,
FechaFactura DATE,
idEmpleado VARCHAR(16) NOT NULL,
idCliente VARCHAR(16) NOT NULL,
FOREIGN KEY (idEmpleado) REFERENCES Empleado(idEmpleado),
FOREIGN KEY (idCliente) REFERENCES Cliente(idCliente)
)";
"CREATE TABLE Detalle(
idDetalle VARCHAR(16) PRIMARY KEY,
SubTotal INT(8) NOT NULL,
Cantidad INT(4) NOT NULL,
idFactura VARCHAR(16) NOT NULL,
idProducto VARCHAR(16) NOT NULL,
FOREIGN KEY (idFactura) REFERENCES Factura(idFactura),
FOREIGN KEY (idProducto) REFERENCES Producto(idProducto)
)";
?>
