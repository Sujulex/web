<?php 
    include "../config/Mysql.php";
    include "../modelos/Artista.php";
    $base = new Mysql();
    $cx = $base->connect();
    $artista = new Artista($cx);
    if (isset($_GET["op"])) {
        $op = $_GET["op"];
        if ($op == 1) {
            $titulo = "Agregar Artículo";
        } else {
            $titulo = "Editar Artículo";
        }
    }
    if (isset($_GET["id"])){
        $id = $_GET["id"];
        $a = $articulo->getArticulo($id);
    }
    if (isset($_POST["gestionArticulo"])){
        $title = $_POST["titulo2"];
        $texto = $_POST["texto"];
        if (empty($title) || $title==""  || empty($texto) || $texto==""){
            $error = "Todos los campos deben de tener información";
        } else {
            if ($_FILES['imagen']['error']>0){
                if ($op!=2)
                    $error = "Error al subir la imagen";
                else {
                    if ($articulo->editar($id,$title,'',$texto)){
                        $mensaje = "Articulo editado correctamente";
                        header ("Location:Artista.php?mensaje=".urlencode($mensaje));
                    } else {
                        $error = "No se ha podido editar el articulo";
                    }
                }
            } else {
                $image = $_FILES['imagen']['name'];
                $imgArr = explode(".", $image);
                $rand = rand(1000,9999);
                $newImage = $imgArr[0].$rand.".".$imgArr[1];
                $rutaFinal = "../img/articulos/".$newImage;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal)){
                    if ($op==1){
                        
                        if ($articulo->agregar($title,$newImage,$texto,$_SESSION["id"])){
                            $mensaje = "Articulo creado correctamente";
                            header ("Location:Artista.php?mensaje=".urlencode($mensaje));
                        } else {
                            $error = "No se ha podido editar el articulo";
                        }
                    } else {
                        if ($articulo->editar($id, $title, $newImage, $texto)){
                            $mensaje = "Articulo editado correctamente";
                            header ("Location:Artista.php?mensaje=".urlencode($mensaje));
                        } else {
                            $error = "No se ha podido editar el articulo";
                        }
                    }
                }
            }
        }       
    }
    if (isset($_POST["borrarArticulo"])){
        if ($articulo->borrar($id)){
            $mensaje = "Artículo borrado con éxito";
            header ("Location:Artista.php?mensaje=".urlencode($mensaje));
        } else {
            $error = "No se pudo borrar el artículo";
        }    
    }
?>


<div class="row">
        <div class="col-sm-12">
            <?php if (isset($error)):?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?=$error?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif;?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if (isset($mensaje)):?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?=$mensaje?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif;?>
        </div>
    </div>

<div class="row">
       
    </div>

<div class="row">
        <div class="col-sm-6">
            <h3><?=$titulo?></h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?=(isset($a->id)?$a->id:"")?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Artista:</label>
                <input type="text" class="form-control" name="titulo2" id="titulo2" value="<?=(isset($a->titulo)?$a->titulo:"")?>">               
            </div>
            <?php if ($op==2):?>
            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="../img/articulos/<?=$a->imagen?>" alt="<?=$a->imagen?>">
            </div>
            <?php endif;?>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Selecciona una imagen">               
            </div>
            <div class="mb-3">
                <label for="texto">Descripción</label>   
                <textarea class="form-control" placeholder="Escriba la descripción del artista" name="texto" style="height: 200px">
                <?=(isset($a->texto)?$a->texto:"")?>
                </textarea>              
            </div>          
        
            <br />
            <button type="submit" name="gestionArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> <?=$titulo?></button>
            <?php if ($op==2):?>
            <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
            <?php endif;?>
            </form>
        </div>
    </div>
