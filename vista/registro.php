<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6"> <div class="card shadow-lg p-4">
                        <div class="card-body">

                            <h2 class="card-title text-center mb-4">
                                <i class="bi bi-person-plus-fill me-2 text-warning"></i> Crear Cuenta
                            </h2>
                            <p class="text-center text-muted mb-4">Regístrate para comenzar a usar "Ponete las pilas"</p>
                            
                            <?php
                            // Reutilizamos tu lógica de alertas para mostrar errores de validación (ej: email duplicado)
                            if (isset($_GET['error'])) {
                                echo "
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <i class='bi bi-exclamation-triangle-fill me-2'></i> " . htmlspecialchars($_GET['error']) . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                                ";
                            }
                            ?>

                            <form action="accion/accionNuevoUsuario.php" method="POST" id="formRegistro">

                                <div class="mb-3">
                                    <label for="usnombre" class="form-label">Nombre Completo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="usnombre" name="usnombre" placeholder="Juan Pérez" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="usmail" class="form-label">Email (Será tu usuario)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="usmail" name="usmail" placeholder="ejemplo@dominio.com" required>
                                    </div>
                                </div>

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

                                <div class="alert alert-info small py-2">
                                    <i class="bi bi-info-circle-fill me-1"></i> Tu cuenta quedará pendiente de aprobación por un administrador.
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-dark btn-lg">
                                        <i class="bi bi-check-circle me-2"></i> Solicitar Registro
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <span class="text-muted small">¿Ya tienes cuenta?</span>
                                    <a href="login.php" class="text-warning small fw-bold ms-1">Inicia Sesión aquí</a>
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