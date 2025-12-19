<?php
// Incluimos los archivos necesarios

include_once(__DIR__.'/../../control/ABMusuario.php'); // Donde tengas tus clases y PHPMailer
include_once(__DIR__.'/../../vendor/autoload.php');
include_once(__DIR__.'/../../utils/funciones.php');
$datos = $_POST; //
$respuesta = "";

// 1. Validar que las contraseñas coincidan
if ($datos['uspass'] !== $datos['uspass2']) {
    header("Location: ../registro.php?error=" . urlencode("Las contraseñas no coinciden."));
    exit;
}

// 2. Instanciar el control de Usuario
$objAbmUsuario = new AbmUsuario();
// 3. Verificar si el email ya existe
$checkEmail = $objAbmUsuario->buscar(['usmail' => $datos['usmail']]);
if (count($checkEmail) > 0) {
    header("Location: ../registro.php?error=" . urlencode("El email ya está registrado."));
    exit;
}

// 4. Preparar los datos para la DB
// Hasheamos la contraseña por seguridad
$passSegura = md5($datos['uspass']);

$datosRegistro = [
    'usnombre' => $datos['usnombre'],
    'usmail'   => $datos['usmail'],
    'uspass'   => $passSegura
];

// 5. Intentar insertar en la Base de Datos
if ($objAbmUsuario->alta($datosRegistro)) {
    
    // --- PARTE DEL EMAIL ---
    // Preparamos el aviso para el administrador
    $adminEmail = "rodrigo.almonacid@est.fi.uncoma.edu.ar"; 
    $asunto = "Nueva solicitud de registro: " . $datos['usnombre'];
    $cuerpo = "
        <h2>Nuevo usuario pendiente de aprobación</h2>
        <p>Un nuevo usuario se ha registrado en el sistema 'Ponete las pilas' y espera ser habilitado.</p>
        <ul>
            <li><strong>Nombre:</strong> {$datos['usnombre']}</li>
            <li><strong>Email:</strong> {$datos['usmail']}</li>
        </ul>
        <p>Puedes habilitarlo desde el panel de administración de usuarios.</p>
    ";

    // Intentamos enviar el mail (asumiendo que tienes configurado PHPMailer)
    try {
        enviarMail($adminEmail, $asunto, $cuerpo); 
    } catch (Exception $e) {
        // Si el mail falla, no detenemos el proceso, el usuario ya se creó.
        // Podrías loguear el error aquí.
    }

    // Redirigir con éxito
    $mensajeExito = "Registro solicitado con éxito. El administrador revisará tu cuenta.";
    header("Location: ../login.php?mensaje=" . urlencode($mensajeExito));
    exit;

} else {
    header("Location: ../registro.php?error=" . urlencode("Error al procesar el registro en la base de datos."));
    exit;
}