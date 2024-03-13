<?php
require_once 'Database.php';

class Conexion
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function conectar()
    {
        return $this->db->conectar();
    }
}
?>
