<?php
session_start();
require_once 'conexion.php';

if (isset($_POST['codigo'])) {
    $codigo = base64_decode($_POST['codigo']);

    $conexion = (new Conection())->connect();
    new Login_User($conexion, $codigo);
} else {
    header("location: ../index.html");
    exit();
}
class Login_User
{
    private $conexion;
    private $codigo;

    public function __construct($conexion, $codigos)
    {
        $this->conexion = $conexion;
        $this->codigo = $this->Buscar()[0]['pass'];
        $this->Verificar($codigos);
    }

    private function Buscar()
    {
        $sql  = "SELECT * FROM login ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        (new Conection())->close();
    }
    private function Verificar($pass)
    {
        // $pass = trim($pass);
        echo "<br> pass " . $pass . " <br> hast " . $this->codigo;
        if (password_verify($pass, $this->codigo)) {
            $_SESSION['admi'] = "session_iniciadada";
            header("location: ../inicio.php");
        } else
            header("location: ../index.html?error=passtype");
    }
}
