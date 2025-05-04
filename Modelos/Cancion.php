<?php
class Cancion {
    private $conn;
    private $table = "canciones";

    public function __construct($cx){
        $this->conn = $cx;
    }

    public function listar($usuario_id, $rol_id){
        try {
            $cad = "";
            if ($rol_id != 1) {
                $cad = " WHERE usuario_id = :usuario_id";
            }
            $qry = "SELECT * FROM view_" . $this->table . $cad;
            $st = $this->conn->prepare($qry);
            if ($rol_id != 1) {
                $st->bindParam(':usuario_id', $usuario_id);
            }
            $st->execute();
            return $st->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function agregar($titulo, $imagen, $duracion, $archivo_audio, $album_id, $artista_id) {
        try {
            $qry = "INSERT INTO " . $this->table . " (titulo, imagen, duracion, archivo_audio, album_id, artista_id) VALUES (:titulo, :imagen, :duracion, :archivo_audio, :album_id, :artista_id)";
            $st = $this->conn->prepare($qry);
            $st->bindParam(':titulo', $titulo);
            $st->bindParam(':imagen', $imagen);
            $st->bindParam(':duracion', $duracion);
            $st->bindParam(':archivo_audio', $archivo_audio);
            $st->bindParam(':album_id', $album_id);
            $st->bindParam(':artista_id', $artista_id);
            $st->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getCancion($id) {
        try {
            $qry = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $st = $this->conn->prepare($qry);
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function editar($id, $titulo, $imagen, $duracion, $archivo_audio, $album_id, $artista_id) {
        try {
            if ($imagen != "") {
                $qry = "UPDATE " . $this->table . " SET titulo = :titulo, imagen = :imagen, duracion = :duracion, archivo_audio = :archivo_audio, album_id = :album_id, artista_id = :artista_id WHERE id = :id";
            } else {
                $qry = "UPDATE " . $this->table . " SET titulo = :titulo, imagen = :imagen, duracion = :duracion, archivo_audio = :archivo_audio, album_id = :album_id, artista_id = :artista_id WHERE id = :id";
            }
            $st = $this->conn->prepare($qry);
            $st->bindParam(':titulo', $titulo);
            if ($imagen != "") {
                $st->bindParam(':imagen', $imagen);
            }
            $st->bindParam(':duracion', $duracion);
            $st->bindParam(':archivo_audio', $archivo_audio);
            $st->bindParam(':album_id', $album_id);
            $st->bindParam(':artista_id', $artista_id);
            $st->bindParam(':id', $id);
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
            $st->bindParam(':id', $id, PDO::PARAM_INT);
            $st->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
?>
