<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "", "dbadaptacion");

// Verificar conexión
if ($conexion->connect_error) {
  die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Consulta
$sql = "SELECT 
    d.latitudG,
    d.longG,
    provincia,
    dist.nombreDistrito AS distritos,
    nombreProyecto
    FROM accionadaptacion d
    JOIN distrito dist ON dist.id = d.distrito";
$resultado = $conexion->query($sql);

$datos = [];
while ($fila = $resultado->fetch_assoc()) {
  $datos[] = $fila;
}

echo json_encode($datos);
$conexion->close();
?>

