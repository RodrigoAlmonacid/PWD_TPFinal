<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand text-warning fw-bold fs-4" href="<?= $ruta ?>/vista/index.php">
                    <i class="bi bi-lightning-charge-fill me-2"></i>Ponete Las Pilas
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#categoryNav" aria-controls="categoryNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="categoryNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/productoAA.php">Pilas AA</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/productoAAA.php">Pilas AAA</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $ruta ?>/vista/pruductoEspeciales.php">Especiales</a></li>
                        <li class="nav-item"><a class="nav-link text-warning fw-bold" href="#">Ofertas</a></li>
                    </ul>

                    <div class="d-flex align-items-center">
                        
                        <button class="btn btn-outline-warning me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                            <i class="bi bi-cart-fill"></i> Carrito (<span id="cart-count">0</span>)
                        </button>
                        
                        <a href="login.php" class="btn btn-primary me-2">
                            <i class="bi bi-person-circle"></i> Iniciar Sesión
                        </a>

                        <button id="admin-menu-toggle" class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminOffcanvas" aria-controls="adminOffcanvas">
                            <i class="bi bi-gear-fill"></i> Admin
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>