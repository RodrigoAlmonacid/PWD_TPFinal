<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); 
    //recupero el producto
    $encuentra=false;
    $i=0;
    $cant=count($arregloProductos);
    $idProducto=$_GET['id'];
    do{
        $objProducto=$arregloProductos[$i];
        if($objProducto->getIdProducto() == $idProducto){
            $encuentra=true;
        }
        $i++;
    }while(!$encuentra && $i<$cant);
    ?>
    <main class="container my-5 flex-grow-1">

<div class="container my-5">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $ruta ?>/vista/index.php" class="text-decoration-none text-dark">Inicio</a></li>
            <li class="breadcrumb-item"><a href="productos.php" class="text-decoration-none text-dark">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $objProducto->getNomProducto(); ?></li>
        </ol>
    </nav>
    
    <div class="row">
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <img src="<?php echo $objProducto->getImgProd(); ?>" 
                    class="card-img-top p-3" 
                    alt="<?php echo $objProducto->getNomProducto(); ?>"
                    style="height: 300px; object-fit: contain;">
            </div>

        </div>
        
        <div class="col-md-6">
            <h1 class="fw-bold"><?php echo $objProducto->getNomProducto(); ?></h1>
            
            <h2 class="text-warning display-4 my-3 fw-bold border-bottom pb-2">
                $<?php echo $objProducto->getProPrecio(); ?> <small class="text-muted fs-5">(IVA incluido)</small>
            </h2>

            <p class="lead">
                <?php echo $objProducto->getDetallesProd(); ?>
                        </p>
            
            <hr>

            <form action="accion/altaCarrito.php" method="POST">
                <input type="hidden" name="idproducto" value="<?php echo $objProducto->getIdProducto(); ?>">
                

                <div class="row align-items-center mb-4">
                    <?php  if($objProducto->getStockProducto()>0){ ?>
                    <div class="col-auto">
                        <label for="inputCantidad" class="form-label fw-bold">Cantidad:</label>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <input 
                            type="number" 
                            class="form-control text-center" 
                            id="inputCantidad" 
                            name="cantidad" 
                            value="1" 
                            min="1" 
                            max="<?php echo $objProducto->getStockProducto(); ?>"
                            required
                        >
                    </div>
                    <?php } ?>
                    <div class="col-12 mt-2">
                        <span class="text-success small">Stock disponible: <?php echo $objProducto->getStockProducto(); ?></span>
                    </div>
                </div>

                <?php if ($objSession->activa()){ 
                            if($objProducto->getStockProducto()>0){?>
                            <button class="btn btn-dark w-100 add-to-cart" 
                                    data-product-id="<?php echo $objProducto->getIdProducto(); ?>">
                                <i class="bi bi-cart-plus me-2"></i>Añadir al Carrito
                            </button>
                        <?php 
                            } else{ ?>
                            <a href="productos.php" class="btn btn-outline-secondary w-100">
                                Producto sin stock, volver a productos
                            </a>
                        <?php
                            }
                        } 
                        else { ?>
                            <a href="login.php" class="btn btn-outline-secondary w-100">
                                Inicia sesión para comprar
                            </a>
                        <?php } ?>
            </form>
            
        </div>
    </div>

    <hr class="my-5">
    <script type="text/javascript" src="js/javaScript.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>

    </main>

<?php
        include_once('estructura/footer.php');
    ?>