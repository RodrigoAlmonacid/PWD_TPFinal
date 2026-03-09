<?php
include_once(__DIR__.'/../modelo/conector/conector.php');
include_once(__DIR__.'/../control/ABMPassReset.php');
include_once('estructura/head.php');
require_once(__DIR__.'/../utils/tipoMetodo.php');

$datos = getSubmittedData();
?>
</head>
<?php
$token = $datos['token'] ?? '';
$objAbmPass=new ABMPassReset();
if (empty($token)) { //miro que $token no esté vacío
    $error = "El enlace de recuperación no es válido o falta el token.";
} else {
    $error=$objAbmPass->validaToken($token); //esta función me devuelve null si todo está bien
}

//bloque de captura de errores (ahora sí tiene qué capturar)
if ($error) {
    header("Location: login.php?error=" . urlencode($error));
    exit; //si encuentro errores lo muestro y no permito el reseteo de la clave
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
