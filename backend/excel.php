<?php
if ($_GET['action'] !== 'excel_registros') {
    echo json_encode([
        "ok" => false,
        "error" => "Acción no permitida"
    ]);
    exit;
}

header('Content-Type: application/json');
require_once 'conexion.php';

$conexion = (new Conection())->connect();
if ($conexion === null) {
    echo json_encode([
        "ok" => false,
        "error" => "Error de conexión a la base de datos"
    ]);
    exit;
}

/* ==========================
   1️⃣ TRAER FORMULARIO
========================== */
function BBDD($conexion)
{
    $sql = "SELECT id, fecha, documento, nombre, telefono, direccion
            FROM formulario
            ORDER BY fecha ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================
   2️⃣ BUSCAR QUIÉN LO INVITÓ
========================== */
function BuscarInvitador($conexion, $idReceptor)
{
    $sql = "SELECT emisor
            FROM invitacion
            WHERE receptor = ?
            LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$idReceptor]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['emisor'] : 0;
}

/* ==========================
   3️⃣ BUSCAR CÉDULA DEL EMISOR
========================== */
function BuscarCC($conexion, $idEmisor)
{
    if ($idEmisor == 0) {
        return 0;
    }

    $sql = "SELECT documento
            FROM formulario
            WHERE id = ?
            LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$idEmisor]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['documento'] : 0;
}

/* ==========================
   4️⃣ CONJUNTO FINAL
========================== */
function conjunto($conexion)
{
    $datos = BBDD($conexion);
    $resultado = [];

    foreach ($datos as $fila) {

        $idReceptor = $fila['id'];

        // ¿Quién lo invitó?
        $idEmisor = BuscarInvitador($conexion, $idReceptor);

        // Cédula del que invitó
        $cedulaInvitador = BuscarCC($conexion, $idEmisor);

        $resultado[] = [
            "fecha" => $fila['fecha'],
            "cedula" => $fila['documento'],
            "nombre" => $fila['nombre'],
            "telefono" => $fila['telefono'],
            "direccion" => $fila['direccion'],
            "cedula_invitador" => $cedulaInvitador
        ];
    }

    return $resultado;
}

/* ==========================
   RESPUESTA FINAL
========================== */
echo json_encode([
    "ok" => true,
    "data" => conjunto($conexion)
]);

     (new Conection())->close();