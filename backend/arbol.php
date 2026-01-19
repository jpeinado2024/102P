<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$conexion = (new Conection())->connect();

if (!$conexion) {
    echo json_encode([
        "ok" => false,
        "error" => "Error de conexión"
    ]);
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode([
        "ok" => false,
        "error" => "ID no recibido"
    ]);
    exit;
}

// ==========================
// 1️⃣ DATOS DEL USUARIO
// ==========================
$sqlUsuario = "
    SELECT nombre, documento
    FROM formulario
    WHERE id = ?
";
$stmt = $conexion->prepare($sqlUsuario);
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo json_encode([
        "ok" => false,
        "error" => "Usuario no encontrado"
    ]);
    exit;
}

// ==========================
// 2️⃣ INVITADOS (JOIN REAL)
// ==========================
$sqlInvitados = "
    SELECT 
        f.id,
        f.nombre,
        f.documento
    FROM invitacion i
    INNER JOIN formulario f ON f.id = i.receptor
    WHERE i.emisor = ?
";

$stmtInv = $conexion->prepare($sqlInvitados);
$stmtInv->execute([$id]);
$invitados = $stmtInv->fetchAll(PDO::FETCH_ASSOC);

// ==========================
// RESPUESTA FINAL
// ==========================
echo json_encode([
    "ok" => true,
    "usuario" => $usuario,
    "invitados" => $invitados
]);

$conexion = null;
