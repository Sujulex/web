<?php
    class Artista {
        private $conn;
        private $table="artistas";

        public function __construct($cx){
            $this->conn = $cx;
        }

        public function listar($usuario_id, $rol_id){
            try {
                $cad="";
                if ($rol_id!=1){
                    $cad = " where usuario_id = :usuario_id";
                }
                $qry = "select * from view_".$this->table.$cad;
                $st = $this->conn->prepare($qry);
                if ($rol_id != 1){
                    $st->bindParam(':usuario_id', $usuario_id);
                }
                $st->execute();
                $rows = $st->fetchAll(PDO::FETCH_OBJ);
                return $rows;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function agregar ($nombre, $imagen, $descripcion, $usuario_id) {
            try {
                $qry = "insert into ".$this->table." (nombre, imagen, descripcion, usuario_id) values (:nombre, :imagen, :descripcion, :usuario_id)";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $st->bindParam(':imagen', $imagen, PDO::PARAM_STR);
                $st->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $st->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $st->execute();
                //echo "<h1>".$qry."</h1>";
                return true;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            } catch (Exception $e) {
                echo "Error del servidor : ".$e->getMessage();
                return false;
            }
        }

        public function getArtista ($id) {
            try {
                $qry = "select * from " . $this->table . " where id = :id";
                $st = $this->conn->prepare($qry);
                $st->bindParam(":id", $id, PDO::PARAM_INT);
                $st->execute();
                return  $st->fetch(PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                echo "Excepción generada : " . $e->getMessage();
                return false;
            }
        }

        public function editar ($id, $nombre, $imagen, $descripcion) {
            try {
                $qry = "update " . $this->table . " set nombre=:nombre, imagen=:imagen, descripcion=:descripcion where id=:id";
                if ($imagen != ""){
                    $qry = "update " . $this->table . " set nombre=:nombre, imagen=:imagen, descripcion=:descripcion where id = :id";
                }
                $st = $this->conn->prepare($qry);
                $st->bindParam (":nombre", $nombre, PDO::PARAM_STR);
                if ($imagen != ""){
                    $st->bindParam (":imagen", $imagen, PDO::PARAM_STR);
                }
                $st->bindParam (":descripcion", $descripcion, PDO::PARAM_STR);
                $st->bindParam (":id", $id, PDO::PARAM_INT);
                $st->execute();
                return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function borrar ($id) {
            $qry = "delete from " . $this->table . " where id = :id";
            try {
                $st = $this->conn->prepare($qry);
                $st->bindParam (":id", $id, PDO::PARAM_STR);
                $st->execute();
                return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }