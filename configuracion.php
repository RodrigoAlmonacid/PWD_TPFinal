<?php
//  Definimos la raíz de forma dinámica relativa a este archivo
// __DIR__ devuelve la ruta absoluta de la carpeta donde está este archivo.
$ROOT = __DIR__ . "/";
require_once($ROOT . 'vendor/autoload.php');
require_once($ROOT . 'modelo/conector/conector.php');
require_once($ROOT . 'modelo/Usuario.php');
require_once($ROOT . 'modelo/Rol.php');
require_once($ROOT . 'modelo/UsuarioRol.php');
require_once($ROOT . 'modelo/Producto.php');
require_once($ROOT . 'utils/funciones.php');
require_once($ROOT . 'control/ABMUsuario.php');
require_once($ROOT . 'control/ABMRol.php');
require_once($ROOT . 'control/ABMUsuarioRol.php');
require_once($ROOT . 'control/ABMProducto.php');
require_once($ROOT . 'control/Session.php');

// Opcional: Configuración de errores para desarrollo
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
?>