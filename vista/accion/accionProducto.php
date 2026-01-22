<?php
require_once('../../control/ABMProducto.php');
require_once('../../modelo/Producto.php'); 
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos = getSubmittedData(); //la operación viene por get, los demás datos por post

$abmProducto = new ABMProducto();
$respuesta = array('success' => false, 'errorMsg' => 'Operación no reconocida.');


$target_dir = "../imagenes/";
$target_file = $target_dir . basename($datos["imgProducto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$datos['proimagen']=$target_file;
// Check if image file is a actual image or fake image
if(isset($datos["submit"])) {
  $check = getimagesize($datos["imgProducto"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($datos["imgProducto"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($datos["imgProducto"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $datos["imgProducto"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
/*
documentacion:
$target_dir = "uploads/" - especifica el directorio donde se colocará el archivo
$target_file especifica la ruta del archivo que se cargará
$uploadOk=1 aún no se utiliza (se utilizará más adelante)
$imageFileType contiene la extensión del archivo (en minúsculas)
A continuación, verifique si el archivo de imagen es una imagen real o una imagen falsa.
Nota: Deberá crear un nuevo directorio llamado "uploads" en el directorio donde se encuentra el archivo "upload.php". Los archivos subidos se guardarán allí.
*/

// Obtener la operación a realizar
$operacion = isset($datos['operacion']) ? $datos['operacion'] : ''; 

if ($operacion == 'guardar') {
    $param_abm = array(
        'pronombre' => $datos['pronombre'], 
        'prodetalle' => $datos['prodetalle'], 
        'procantstock' => $datos['procantstock'],
        'proprecio' => $datos['proprecio'],
        'proimagen' => $datos['proimagen'],
    );
    
    if ($abmProducto->alta($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la inserción (revisar alta() en abmProducto).';
    }

} elseif ($operacion == 'actualizar') {
    $param_abm = array(
        'idproducto' => $datos['idproducto'],
        'pronombre' => $datos['pronombre'], 
        'prodetalle' => $datos['prodetalle'], 
        'procantstock' => $datos['procantstock'],
        'proprecio' => $datos['proprecio'],
        'proimagen' => $datos['proimagen'],
        'prodeshabilitado' => $datos['prodeshabilitado']
    );
    if ($abmProducto->modificar($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la modificación (revisar modificar() en abmProducto). id:'.$param_abm['idproducto'];
    }
    
} elseif ($operacion == 'eliminar') { 

    $param_abm = array(
        'idproducto' => $datos['id']);

    if ($abmProducto->baja($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la baja (Revisar baja() en abmProducto o las relaciones en la base).';
    }
}

//Enviar la respuesta en JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>