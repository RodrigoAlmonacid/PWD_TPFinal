<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="display-6 fw-bold border-bottom pb-3">
                <i class="bi bi-box-seam text-warning me-2"></i>Catálogo de Pilas y Baterías
            </h2>
            <p class="text-muted">Explorá nuestra variedad completa de productos con stock actualizado.</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        
        <?php foreach($arregloProductos as $objProducto){ ?>
        
        <div class="col">
            <div class="card h-100 shadow-sm border-0 bg-light">
                <div class="p-3 bg-white" style="height: 220px;">
                    <img src="<?php echo $objProducto->getImgProd(); ?>" 
                         class="card-img-top w-100 h-100" 
                         alt="..." 
                         style="object-fit: contain;">
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark mb-1">
                        <?php echo $objProducto->getNomProducto(); ?>
                    </h5>
                    
                    <p class="fs-4 text-warning fw-bold mb-2">$<?php echo $objProducto->getProPrecio(); ?></p>

                    <div class="flex-grow-1">
                        <p class="card-text text-muted small mb-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo $objProducto->getDetallesProd(); ?>
                        </p>
                        <a href="detalleProducto.php?id=<?php echo $objProducto->getIdProducto(); ?>" class="btn btn-link btn-sm p-0 text-decoration-none fw-semibold">
                            Ver más...
                        </a>
                    </div>

                    <div class="mt-3 pt-3 border-top">
                        <?php if ($objSession->activa()) : ?>
                            <button class="btn btn-dark w-100 add-to-cart" 
                                    data-product-id="<?php echo $objProducto->getIdProducto(); ?>">
                                <i class="bi bi-cart-plus me-2"></i>Añadir al Carrito
                            </button>
                        <?php else : ?>
                            <a href="login.php" class="btn btn-outline-secondary w-100">
                                Inicia sesión para comprar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php } //cierro el foreach ?>
        <script type="text/javascript" src="js/javaScript.js"> </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</main>

<?php
        include_once('estructura/footer.php');
    ?>