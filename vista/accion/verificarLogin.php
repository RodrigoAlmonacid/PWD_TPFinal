<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once ('../../control/Session.php');

$datos = $_POST;
$objSession = new Session();
// Llamamos al método iniciar modificado
$exito = $objSession->iniciar($datos['usmail'], $datos['uspass']);

if ($exito) {
    // Login correcto -> Al inicio
    header('Location: ../index.php');
    exit;
} else {
    // Login fallido -> Volver al login con error
    // Nota: Session->iniciar devuelve false si falla pass o usuario, 
    // por seguridad no decimos cuál de los dos falló.
    $mensaje = "Usuario o contraseña incorrectos, o cuenta deshabilitada.";
    header('Location: ../login.php?error=' . urlencode($mensaje));
    exit;
}
?>