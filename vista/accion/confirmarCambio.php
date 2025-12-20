<?php
include_once(__DIR__.'/../../modelo/conector/conector.php');
include_once(__DIR__.'/../../control/ABMusuario.php');
include_once(__DIR__.'/../../modelo/Usuario.php');
$datos = $_POST;
$token = $datos['token'] ?? '';
$pass1 = $datos['uspass'] ?? '';
$pass2 = $datos['uspass2'] ?? '';

// 1. Validación básica de contraseñas
if ($pass1 !== $pass2) {
    header("Location: ../vista/actualizarPass.php?token=$token&error=" . urlencode("Las contraseñas no coinciden."));
    exit;
}

$db = new BaseDatos();

// 2. Verificamos que el token siga siendo válido y obtenemos el mail
$sqlToken = "SELECT usmail FROM pass_reset WHERE token = '$token' AND usado = 0 LIMIT 1";
$cant = $db->ejecutar($sqlToken);

if ($cant > 0) {
    $registroToken = $db->registro();
    $emailUsuario = $registroToken['usmail'];

    // 3. Buscamos al usuario para obtener su ID y sus otros datos (necesarios para el ABM)
    $objAbmUsuario = new AbmUsuario();
    $listaUsuarios = $objAbmUsuario->buscar(['usmail' => $emailUsuario]);
    if (count($listaUsuarios) > 0) {
        $objUsuario = $listaUsuarios[0]; // El objeto usuario encontrado
        // 4. Hasheamos la nueva contraseña
        $nuevaPassHash = password_hash($pass1, PASSWORD_DEFAULT);

        // 5. Preparamos los datos para actualizar (usando tu estructura de ABM)
        // Nota: Asegúrate de pasar todos los campos que tu método 'modificar' requiera
        $deshabilit=$objUsuario->getDesHabilitado_usuario();
        if($deshabilit==null || $deshabilit==""){
            $deshabilit="null";
        }
        $datosUpdate = [
            'idusuario' => $objUsuario->getId_usuario(),
            'usnombre'  => $objUsuario->getNom_usuario(),
            'usmail'    => $objUsuario->getEmail_usuario(),
            'uspass'    => $pass1,
            'usdeshabilitado' => $deshabilit 
        ];

        if ($objAbmUsuario->modificar($datosUpdate)) {
            
            // 6. ¡ÉXITO! Ahora invalidamos el token para que no se pueda volver a usar
            $sqlInvalidar = "UPDATE pass_reset SET usado = 1 WHERE token = '$token'";
            $db->ejecutar($sqlInvalidar);

            $msj = "Contraseña actualizada correctamente. Ya puedes iniciar sesión.";
            header("Location: ../login.php?mensaje=" . urlencode($msj));
            exit;
            
        } else {
            $error = "Error crítico al intentar actualizar la base de datos.";
        }
    } else {
        $error = "No se encontró el usuario asociado a este pedido.";
    }
} else {
    $error = "El token ya no es válido o ha expirado.";
}

// Si hubo algún error en el proceso:
header("Location: ../login.php?error=" . urlencode($error));