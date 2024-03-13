<?php
class Database
{
    private $hostname = "localhost";
    private $database = "lote"; // Cambia el nombre de la base de datos aquí
    private $username = "root";
    private $password = "";
    private $charset = "utf8";

    public function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . ";dbname=" . $this->database . ";charset=" . $this->charset;
            $option = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $option);

            return $pdo;
        } catch (PDOException $e) {
            echo 'Error de Conexion: ' . $e->getMessage();
            exit;
        }
    }
}
?>
