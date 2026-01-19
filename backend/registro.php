<?php


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

// ==================
// DATOS POST
// ==================
$nombre = $_POST['nombre'] ?? '';
$cc = $_POST['cc'] ?? '';
$tel = $_POST['tel'] ?? '';
$dir = $_POST['dir'] ?? '';
$fecha = date('Y-m-d H:i:s');
$invitacion = $_POST['invitacion'] ?? '0';
// ==================
// CLASE
// ==================
class Registros
{
    private $db;

    public function __construct($conexion)
    {
        $this->db = $conexion;
    }

    // 🔍 Verificar si ya existe la cédula
    public function buscarPorCedula($cc)
    {
        $sql = "SELECT id FROM formulario WHERE documento = :cc LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cc', $cc, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // 💾 Guardar formulario
    public function guardar($nombre, $cc, $tel, $dir, $fecha, $invitacion)
    {
        $invitacion = base64_decode($invitacion);
        $identificacion = $this->Formulario($nombre, $cc, $tel, $dir, $fecha);
        if ($invitacion > 0) {
            $this->Invitacion($invitacion, $identificacion);
        }
   
        if ($identificacion) {
            return $identificacion;
        } else
            return false;
    }
    public function Invitacion($invitacion, $id)
    {

        $sql = "INSERT INTO invitacion (emisor, receptor)
            VALUES (:emisor, :receptor)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':emisor', $invitacion, PDO::PARAM_INT);
        $stmt->bindParam(':receptor', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function Formulario($nombre, $cc, $tel, $dir, $fecha)
    {
        $sql = "INSERT INTO formulario
                (nombre, documento, telefono, direccion, fecha)
                VALUES
                (:nombre, :cc, :tel, :dir, :fecha)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cc', $cc, PDO::PARAM_INT);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':dir', $dir);
        $stmt->bindParam(':fecha', $fecha);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
}

// ==================
// EJECUCIÓN
// ==================
$registro = new Registros($conexion);

// validar duplicado
if ($registro->buscarPorCedula($cc)) {
    echo json_encode([
        "ok" => false,
        "error" => "Esta cédula ya se encuentra registrada"
    ]);
    exit;
}

// guardar registro
$dominio = $_SERVER['HTTP_HOST'].'/index.html?invit=';



$id =$dominio.base64_encode($registro->guardar($nombre, $cc, $tel, $dir, $fecha, $invitacion));

if ($id) {
    echo json_encode([
        "ok" => true,
        "id" => $id
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "error" => "No se pudo guardar el registro"
    ]);
}

// cerrar conexión
(new Conection())->close();
