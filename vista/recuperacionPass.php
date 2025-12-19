<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">

                    <div class="card shadow-lg p-4">
                        <div class="card-body">

                            <h2 class="card-title text-center mb-4">
                                <i class="bi bi-person-fill me-2 text-warning"></i>Recuperar contraseña
                            </h2>
                            <p class="text-center text-muted mb-4">Se enviará un link de recuperación</p>
                            <?php
                            if (isset($_GET['error'])) {
                                echo "
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <i class='bi bi-exclamation-triangle-fill me-2'></i> " . htmlspecialchars($_GET['error']) . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                                ";
                            }
                            
                            if (isset($_GET['mensaje'])) {
                                echo "
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <i class='bi bi-check-circle-fill me-2'></i> " . htmlspecialchars($_GET['mensaje']) . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                                ";
                            }
                            ?>
                            <form action="accion/generaToken.php" method="POST">

                                <div class="mb-3">
                                    <label for="inputEmail" class="form-label">Email (Usuario)</label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="inputEmail" 
                                        name="usmail" 
                                        placeholder="ejemplo@dominio.com" 
                                        required
                                    >
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-dark btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Solicitar
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