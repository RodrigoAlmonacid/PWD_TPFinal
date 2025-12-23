<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
    <h2 class="mb-4 border-bottom pb-2">Productos Destacados</h2>

    <div id="carouselProductos" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $gruposProductos = array_chunk($arregloProductos, 4);
            $isFirst = true;
            foreach ($gruposProductos as $grupo) :
            ?>
                <div class="carousel-item <?php echo $isFirst ? 'active' : ''; ?>">
                    <div class="row g-4">
                        <?php foreach ($grupo as $objProducto) : ?>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="card h-100 shadow-sm border-0 product-card">
                                    <a href="detalleProducto.php?id=<?php echo $objProducto->getIdProducto(); ?>">
                                        <img src="<?php echo $objProducto->getImgProd(); ?>" 
                                             class="card-img-top p-3" 
                                             alt="<?php echo $objProducto->getNomProducto(); ?>"
                                             style="height: 200px; object-fit: contain;">
                                    </a>
                                    
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-truncate"><?php echo $objProducto->getNomProducto(); ?></h5>
                                        <p class="card-text text-warning fw-bold fs-5">$<?php echo $objProducto->getProPrecio(); ?></p>
                                        
                                        <?php if ($objSession->activa()) : ?>
                                            <button class="btn btn-dark add-to-cart" 
                                                    data-product-id="<?php echo $objProducto->getIdproducto(); ?>">
                                                <i class="bi bi-bag-plus"></i> Añadir
                                            </button>
                                        <?php else : ?>
                                            <p class="small text-muted">Inicia sesión para comprar</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
                $isFirst = false;
            endforeach;
            ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductos" data-bs-slide="prev" style="width: 5%; filter: invert(1);">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselProductos" data-bs-slide="next" style="width: 5%; filter: invert(1);">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</main>
    <script type="text/javascript" src="js/javaScript.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <?php
        include_once('estructura/footer.php');
    ?>

