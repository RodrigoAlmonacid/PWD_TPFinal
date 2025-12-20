<?php
include_once(__DIR__.'/../modelo/conector/conector.php');
    include_once('estructura/head.php');
?>
</head>
<?php
$token = $_GET['token'] ?? '';

$error = null; // Inicializamos la variable

if (empty($token)) {
    $error = "El enlace de recuperación no es válido o falta el token.";
} else {
    $db = new BaseDatos();
    // 1. Buscamos el token. Nota: Filtramos por usado = 0
    $sql = "SELECT * FROM pass_reset WHERE token = '$token' AND usado = 0 LIMIT 1";
    $cant = $db->ejecutar($sql);

    if ($cant > 0) {
        $pedido = $db->registro(); // Obtenemos los datos
        
        // 2. Validamos el vencimiento
        $ahora = date("Y-m-d H:i:s");
        if ($ahora > $pedido['vencimiento']) {
            $error = "El enlace ha expirado. Los tokens duran solo 1 hora. Hora venc: ".$pedido['vencimiento'].", hora:".$ahora;
        }
    } else {
        // Si no encontró nada o ya fue usado
        $error = "El enlace es inválido o ya fue utilizado previamente.";
    }
}

// 3. Tu bloque de captura de errores (ahora sí tiene qué capturar)
if ($error) {
    header("Location: login.php?error=" . urlencode($error));
    exit;
}

// Si llegamos aquí, el token es VÁLIDO. 
// Aquí mostrarías el formulario para ingresar la nueva contraseña.

// Si está todo OK, muestras el formulario de "Nueva Contraseña"
// ... (Aquí pones un formulario similar al de registro con uspass y uspass2)
?>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">

                    <div class="card shadow-lg p-4">
                        <div class="card-body">

                            <h2 class="card-title text-center mb-4">
                                <i class="bi bi-person-fill me-2 text-warning"></i> Reseteo de Clave
                            </h2>
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
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-dark btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Cambiar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
    include_once('estructura/footer.php');
?>
