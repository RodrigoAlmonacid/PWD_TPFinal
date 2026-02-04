<?php
include_once(__DIR__.'/../modelo/conector/conector.php');
include_once(__DIR__.'/../control/ABMPassReset.php');
include_once('estructura/head.php');
?>
</head>
<?php
$token = $_GET['token'] ?? '';

$error = null; // Inicializo la variable

if (empty($token)) { //miro que $token no esté vacío
    $error = "El enlace de recuperación no es válido o falta el token.";
} else {
    $abmPass=new ABMPassReset();
    $objPass=$abmPass->buscar(['token'=>$token, 'usado'=>0]);

    /*
    $db = new BaseDatos();
    // 1. Buscamos el token. Nota: Filtramos por usado = 0
    $sql = "SELECT * FROM pass_reset WHERE token = '$token' AND usado = 0 LIMIT 1";
    $cant = $db->ejecutar($sql);
    */
    if ($objPass) {
        
        //Validamos el vencimiento
        $ahora = date("Y-m-d H:i:s");
        if ($ahora > $objPass->getVencimiento()) {
            $error = "El enlace ha expirado. Los tokens duran solo 1 hora.";
        }
    } else {
        // Si no encontró nada o ya fue usado
        $error = "El enlace es inválido o ya fue utilizado previamente.";
    }
}

//Tu bloque de captura de errores (ahora sí tiene qué capturar)
if ($error) {
    header("Location: login.php?error=" . urlencode($error));
    exit;
}

// Si llego, el token es VÁLIDO. 

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
