<?php
// connect.php
class Conection
{
    private $conn = null;
    // Establece la conexión a la base de datos
    public function connect()
    {
        
        $host = 'localhost';
        $db = '102pl';
        $user = 'root';
        $pass = '';
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);   //conexión a la base de datos
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // optiene los errores
            // echo "ok";
            return $this->conn;
        } catch (PDOException $e) {
            // echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }

    // Cierra la conexión a la base de datos
    public function close()
    {
        $this->conn = null;
        return $this->conn;
    }
}

// (new Conection())->connect();

