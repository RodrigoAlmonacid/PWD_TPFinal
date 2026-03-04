<?php
require_once('../../control/ABMProducto.php');
require_once('../../modelo/Producto.php'); 
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos = getSubmittedData(); //la operación viene por get, los demás datos por post
$abmProducto = new ABMProducto();
$respuesta = array('success' => false, 'errorMsg' => 'Operación no reconocida.');

//uso 
if(!empty($datos["imgProducto"]["name"])){
  $target_dir = "../imagenes/"; //especifica el directorio donde se colocará el archivo
  $target_file = $target_dir . basename($datos["imgProducto"]["name"]); //especifica la ruta del archivo que se cargará
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); //contiene la extensión del archivo (en minúsculas)
  $datos['proimagen']="imagenes/".basename($datos["imgProducto"]["name"]);
//Comprueba si el archivo de imagen es una imagen real o una imagen falsa
if(isset($datos["submit"])) {
  $check = getimagesize($datos["imgProducto"]["tmp_name"]);
  if($check !== false) {
    $respuesta['mensaje']="El archivo es una imagen - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    $respuesta['mensaje']="El archivo no es una imagen.";
    $uploadOk = 0;
  }
}
//comprueba si el archivo ya existe
if (file_exists($target_file)) {
  $respuesta['mensaje']="La imagen ya existe.";
  $uploadOk = 0;
}
//comprueba el tamaño
if ($datos["imgProducto"]["size"] > 1048576) { //limito la imagen a 1 mega (el valor se expresa en bytes 1Mb = 1024b) 
  $respuesta['mensaje']="La imagen no puede ser mayor a 1 Mb.";
  $uploadOk = 0;
}

//formatos admitidos
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $respuesta['mensaje']="Formato incorrecto. Solo se admiten JPG, JPEG, PNG y GIF.";
  $uploadOk = 0;
}

//Comprueba si $uploadOk está establecido en 0 por un error
if ($uploadOk == 0) {
  $respuesta['mensaje']="El archivo no pudo ser cargado.";
//si todo está bien, intenta cargar el archivo
} else {
  if (move_uploaded_file($datos["imgProducto"]["tmp_name"], $target_file)) {
    $respuesta['mensaje']="El archivo ". htmlspecialchars( basename( $datos["imgProducto"]["name"])). " fue cargado con éxito.";
  } else {
    $respuesta['mensaje']="Error al cargar el archivo.";
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
}
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
        'prodeshabilitado' => $datos['prodeshabilitado']
    );
    if (!empty($datos['proimagen'])) {
        $param_abm['proimagen'] = $datos['proimagen'];
    }
    if ($abmProducto->modificar($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la modificación (revisar modificar() en abmProducto). id:'.$param_abm['idproducto'];
    }
    
} elseif ($operacion == 'eliminar') { 

    $param_abm = array(
        'idproducto' => $datos['idproducto']);

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