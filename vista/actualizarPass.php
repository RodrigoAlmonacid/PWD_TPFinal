<?php
include_once(__DIR__.'/../modelo/conector/conector.php');
include_once(__DIR__.'/');
$token = $_GET['token'] ?? '';

// 1. Buscar el token en la DB
$db = new BaseDatos();
$res = $db->ejecutar("SELECT * FROM password_resets WHERE token = '$token' AND usado = 0 LIMIT 1");
$pedido = ($res) ? $res->fetch(PDO::FETCH_ASSOC) : null;

$error = null;
if (!$pedido) {
    $error = "El enlace es inválido o ya fue utilizado.";
} else {
    $ahora = date("Y-m-d H:i:s");
    if ($ahora > $pedido['vencimiento']) {
        $error = "El enlace ha expirado. Por favor, solicita uno nuevo.";
    }
}

// Si hay error, lo mandas al login con el mensaje
if ($error) {
    header("Location: login.php?error=" . urlencode($error));
    exit;
}

// Si está todo OK, muestras el formulario de "Nueva Contraseña"
// ... (Aquí pones un formulario similar al de registro con uspass y uspass2)
?>
<form action="accion/confirmarCambio.php" method="POST">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="uspass" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="uspass" name="uspass" required>
        </div>
        <div class="col-md-6 mb-4">
            <label for="uspass2" class="form-label">Repetir Contraseña</label>
            <input type="password" class="form-control" id="uspass2" name="uspass2" required>
        </div>
    </div>
</form>