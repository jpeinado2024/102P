<?php
if ($_GET['action'] !== 'listar_registros') {
    echo json_encode([
        "ok" => false,
        "error" => "Acción no permitida"
    ]);
    exit;
}
header('Content-Type: application/json');
require_once 'conexion.php';

// ==================
// CONEXIÓN
// ==================
$conexion = (new Conection())->connect();

if ($conexion === null) {
    echo json_encode([
        "ok" => false,
        "error" => "Error de conexión a la base de datos"
    ]);
    exit;
}
//======
function BBDD($conexion)
{
    $sql = "SELECT * FROM formulario ORDER BY fecha DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$datos = BBDD($conexion);
echo json_encode([
    "ok" => true,
    "data" => $datos
]);
(new Conection())->close();
