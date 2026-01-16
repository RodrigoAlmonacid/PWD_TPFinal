<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
    include_once('estructura/menuPrincipal.php'); 
    include_once(__DIR__.'/../control/ABMCompra.php');
    include_once(__DIR__.'/../control/ABMCompraItem.php');
    ?>
    <main class="container my-5 flex-grow-1">
    <?php 
    if($objSession->activa()){ //condición para mostar solo en caso de que haya una sesion activa
         
        
        if($carritoActivo){ //condición para mostrar un cartel de que no hay compras activas
        $objABMCompraItem=new ABMCompraItem();
        $idCompra=$carritoActivo->getIdCompra();
        $compraItem=$objABMCompraItem->buscar(['idcompra' => $idCompra]); //Aca ya logré obtener los items 
    ?>
    
    <div class="container my-5">
    
    <h1 class="fw-bold mb-4 border-bottom pb-2">
        <i class="bi bi-cart-fill me-2 text-warning"></i> Tu Carrito de Compras
    </h1>

    <div class="row">
        
        <div class="col-lg-8">
            
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="py-3 ps-4">Producto</th>
                                    <th scope="col" class="py-3">Precio Unitario</th>
                                    <th scope="col" class="py-3">Stock</th>
                                    <th scope="col" class="py-3" style="width: 150px;">Cantidad</th>
                                    <th scope="col" class="py-3">Subtotal</th>
                                    <th scope="col" class="py-3"></th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                //acá armo el carrito dinámico
                                $sumaTotal=0;
                                foreach($compraItem as $unItem){
                                    $objProducto=$unItem->getobjProducto();
                                    $cantidad=$unItem->getCantidad();
                                    $subTotal=$objProducto->getProPrecio()*$cantidad;
                                    $sumaTotal=$sumaTotal+$subTotal;
                                    //acá podría poner un if($cantidad>0) para no eliminar un item en la base, sino que poner cantidad en cero
                                ?>
                                <tr>
                                    <td class="py-3 ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $objProducto->getImgProd(); ?>" class="me-3" alt="Pila AA" style="width: 50px; height: 50px; object-fit: contain;">
                                            <div>
                                                <h6 class="mb-0 fw-bold"><?= $objProducto->getNomProducto(); ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">$<?= $objProducto->getProPrecio(); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold"><?= $objProducto->getStockProducto(); ?></span>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary btn-decrease" type="button">-</button>
                                            <input type="number" class="form-control text-center quantity-input" value="<?= $cantidad; ?>" min="0" max="<?= $objProducto->getStockProducto(); ?>" data-product-id="101" style="max-width: 60px;">
                                            <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-warning fw-bold">$<?= $subTotal; ?></span> 
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger btn-remove" data-product-id="101">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php }//acá cierro el carrito dinámico ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="productos.php" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-2"></i> Continuar Comprando
                </a>
                <button class="btn btn-light border" onclick="location.reload();">
                    <i class="bi bi-arrow-clockwise me-2"></i> Actualizar Carrito
                </button>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white fw-bold fs-5">
                    Resumen de Pedido
                </div>
                <div class="card-body">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal de Productos:</span>
                        <span class="fw-semibold" id="subtotal-val">$<?= $sumaTotal ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span>Costo de Envío:</span>
                        <span class="text-success fw-semibold" id="shipping-val">Gratis</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-3">
                        <span class="fs-4 fw-bold">Total a Pagar:</span>
                        <span class="fs-4 text-danger fw-bolder" id="total-val">$<?= $sumaTotal ?></span>
                    </div>
                    <form action="accion/finalizarCarrito.php" method="post">
                        <input type="hidden" name="idcompra" value="<?= $idCompra; ?>">
                        <div class="d-grid mt-4">
                            <button id="btnFinalizar" class="btn btn-success btn-lg">
                                <i class="bi bi-send-check"></i> Finalizar y Enviar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <?php 
        } //cierro el if si no hay compras activas
        else{ ?>
            <div class="text-center py-5 my-5">
                <div class="mb-4">
                    <i class="bi bi-cart-x text-muted opacity-50" style="font-size: 6rem;"></i>
                </div>
                <h1 class="display-5 fw-bold">Tu carrito está vacío</h1>
                <p class="lead mb-4 text-muted">Parece que todavía no has sumado ninguna pila o bateria a tu pedido.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="index.php" class="btn btn-dark btn-lg px-5 shadow">
                        <i class="bi bi-arrow-left me-2"></i>Ir a ver Productos
                    </a>
                </div>
            </div>
    <?php    }
    } //cierro el if de la sesion activa 
    else{ ?>
        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <div class="card shadow border-0 text-center p-5">
                    <div class="card-body">
                        <div class="mb-4">
                            <i class="bi bi-person-lock text-warning display-1"></i>
                        </div>
                        <h2 class="fw-bold">¡Alto!</h2>
                        <p class="text-muted fs-5">Para ver tu carrito y empezar a comprar en <strong>Ponete las Pilas</strong>, necesitas iniciar sesión.</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                            <a href="login.php" class="btn btn-warning btn-lg px-4 gap-3 fw-bold">Iniciar Sesión</a>
                            <a href="registro.php" class="btn btn-outline-dark btn-lg px-4">Crear Cuenta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <?php  } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/javaScript.js"> </script>
    <script src="js/carrito.js" type="text/javascript"> </script>
    
    </main>
    <?php
        include_once('estructura/footer.php');
    ?>