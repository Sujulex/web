<?php

class Mysql{
    private $host = "localhost";
    private $db_name = "blog_musical";
    private $user = "root";
    private $password = "";
    private $conn;

    //REgresar la conexión de la base de datos
    public function connect(){
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Se conecto";
        } catch (PDOException $e) {
            echo "Error con la conexión : " . $e->getMessage();
        }
        return $this->conn;
    }
}