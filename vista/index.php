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
                                            <?php  if($objProducto->getStockProducto()>0){ ?>
                                            <form action="accion/altaCarrito.php" method="POST">
                                                <input type="hidden" name="idproducto" value="<?php echo $objProducto->getIdProducto(); ?>">
                                                <input type="hidden" id="cantidad" name="cantidad" value="1" min="1" max="<?php echo $objProducto->getStockProducto(); ?>">
                                                <button class="btn btn-dark add-to-cart" 
                                                        data-product-id="<?php echo $objProducto->getIdproducto(); ?>">
                                                    <i class="bi bi-bag-plus"></i> Añadir
                                                </button>
                                            </form>
                                            <?php 
                                            } else{ ?>
                                            <input type="button" class="btn btn-outline-secondary w-100" value="Producto sin stock">
                                            <?php
                                                }
                                            else : ?>
                                            <a href="login.php" class="btn btn-outline-secondary w-100">
                                                Inicia sesión para comprar
                                            </a>
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
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    
    <?php
        include_once('estructura/footer.php');
    ?>

