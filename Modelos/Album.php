<?php
class Album {
    private $conn;
    private $table = "albumes";

    public function __construct($cx) {
        $this->conn = $cx;
    }

    public function listar($usuario_id, $rol_id) {
        try {
            $qry = "SELECT * FROM view_albumes";
            if ($rol_id != 1) {
                $qry .= " WHERE artista_id IN (
                            SELECT id FROM artistas WHERE usuario_id = :usuario_id
                        )";
            }
    
            $st = $this->conn->prepare($qry);
            if ($rol_id != 1) {
                $st->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            }
            $st->execute();
            return $st->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Error en listar álbumes: " . $e->getMessage());
        }
    }
    
    
    

    public function agregar($titulo, $descripcion, $imagen, $fecha_lanzamiento, $artista_id) {
        try {
            $qry = "INSERT INTO " . $this->table . " (titulo, descripcion, imagen, fecha_lanzamiento, artista_id) VALUES (:titulo, :descripcion, :imagen, :fecha_lanzamiento, :artista_id)";
            $st = $this->conn->prepare($qry);
            $st->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $st->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $st->bindParam(':imagen', $imagen, PDO::PARAM_STR);
            $st->bindParam(':fecha_lanzamiento', $fecha_lanzamiento);
            $st->bindParam(':artista_id', $artista_id, PDO::PARAM_INT);
            $st->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getAlbum($id) {
        try {
            $qry = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $st = $this->conn->prepare($qry);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function editar($id, $titulo, $imagen, $descripcion, $fecha_lanzamiento, $artista_id) {
        try {
            if ($imagen != "") {
                $qry = "UPDATE " . $this->table . " SET titulo = :titulo, descripcion = :descripcion, imagen = :imagen, fecha_lanzamiento = :fecha_lanzamiento, artista_id = :artista_id WHERE id = :id";
            } else {
                $qry = "UPDATE " . $this->table . " SET titulo = :titulo, descripcion = :descripcion, fecha_lanzamiento = :fecha_lanzamiento, artista_id = :artista_id WHERE id = :id";
            }
            $st = $this->conn->prepare($qry);
            $st->bindParam(":titulo", $titulo, PDO::PARAM_STR);
            $st->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            if ($imagen != "") {
                $st->bindParam(":imagen", $imagen, PDO::PARAM_STR);
            }
            $st->bindParam(":fecha_lanzamiento", $fecha_lanzamiento);
            $st->bindParam(":artista_id", $artista_id, PDO::PARAM_INT);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function borrar($id) {
        try {
            $qry = "DELETE FROM " . $this->table . " WHERE id = :id";
            $st = $this->conn->prepare($qry);
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}