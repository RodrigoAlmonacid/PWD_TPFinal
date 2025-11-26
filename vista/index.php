<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
        <h2 class="mb-4 border-bottom pb-2">Nuestros Productos</h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="imagenes/pilaAA.jpg" class="card-img-top p-3" alt="Pila AA" 

[Image of a generic AA battery pack]
>
                    <div class="card-body text-center">
                        <h5 class="card-title">Pila AA Alcalina (Pack x4)</h5>
                        <p class="card-text text-warning fw-bold fs-5">$150</p>
                        <button class="btn btn-dark add-to-cart" data-product-id="1">
                            <i class="bi bi-bag-plus"></i> Añadir
                        </button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="imagenes/pilaAAA.jpg" class="card-img-top p-3" alt="Pila AAA" >
                    <div class="card-body text-center">
                        <h5 class="card-title">Pila AAA Recargable</h5>
                        <p class="card-text text-warning fw-bold fs-5">$250</p>
                        <button class="btn btn-dark add-to-cart" data-product-id="2">
                            <i class="bi bi-bag-plus"></i> Añadir
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header bg-dark text-white">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel"><i class="bi bi-bag-check-fill me-2"></i> Tu Carrito</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group mb-4" id="cart-items">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Pila AA x4
                    <span class="badge bg-warning text-dark">$500</span>
                </li>
                </ul>
            
            <div class="d-flex justify-content-between align-items-center mb-3 fw-bold fs-5 border-top pt-3">
                <span>Total:</span>
                <span class="text-danger">$500</span>
            </div>
            
            <button class="btn btn-success w-100">
                <i class="bi bi-credit-card-fill"></i> Finalizar Compra
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</main>
    <?php
        include_once('estructura/footer.php');
    ?>

