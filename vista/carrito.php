<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
    include_once('estructura/menuPrincipal.php'); 
    include_once(__DIR__.'/../control/ABMCompra.php');
    ?>
    <?php 
$datos = $_GET;
$objABMCompra= new ABMCompra();
$idUsuario = $_SESSION['idusuario'];
$carritoActivo=$objABMCompra->obtenerCarritoActivo($idUsuario);//acá obtengo un objeto compra
//necesito los productos de esa compra para poder mostar los datos
//tambien necesito la cantidad de productos para hacer la cuenta
if (isset($datos['va']) && $datos['va'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>¡Agregado!</strong> El producto se sumó a tu carrito con éxito.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
    <main class="container my-5 flex-grow-1">
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
                                    <th scope="col" class="py-3" style="width: 150px;">Cantidad</th>
                                    <th scope="col" class="py-3">Subtotal</th>
                                    <th scope="col" class="py-3"></th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3 ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="http://googleusercontent.com/image_collection/image_retrieval/some_id_string" class="me-3" alt="Pila AA" style="width: 50px; height: 50px; object-fit: contain;">
                                            <div>
                                                <h6 class="mb-0 fw-bold">Pila Recargable AA (Pack x4)</h6>
                                                <small class="text-muted">Modelo: 2500mAh</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">$890.00</span>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary btn-decrease" type="button">-</button>
                                            <input type="number" class="form-control text-center quantity-input" value="2" min="1" data-product-id="101" style="max-width: 60px;">
                                            <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-warning fw-bold">$1780.00</span> 
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger btn-remove" data-product-id="101">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="http://googleusercontent.com/image_collection/image_retrieval/some_id_string" class="me-3" alt="Pila AAA" style="width: 50px; height: 50px; object-fit: contain;">
                                            <div>
                                                <h6 class="mb-0 fw-bold">Pila Alcalina AAA (Unidad)</h6>
                                                <small class="text-muted">Modelo: Ultra Duración</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">$150.00</span>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary btn-decrease" type="button">-</button>
                                            <input type="number" class="form-control text-center quantity-input" value="4" min="1" data-product-id="102" style="max-width: 60px;">
                                            <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-warning fw-bold">$600.00</span> 
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger btn-remove" data-product-id="102">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="/" class="btn btn-outline-dark">
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
                        <span class="fw-semibold" id="subtotal-val">$2380.00</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span>Costo de Envío:</span>
                        <span class="text-success fw-semibold" id="shipping-val">Gratis</span>
                    </div>

                    <div class="mb-3">
                        <label for="couponCode" class="form-label small">Código de Descuento</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="couponCode" placeholder="Ingresa tu código">
                            <button class="btn btn-outline-success" type="button" id="applyCoupon">Aplicar</button>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-3">
                        <span class="fs-4 fw-bold">Total a Pagar:</span>
                        <span class="fs-4 text-danger fw-bolder" id="total-val">$2380.00</span>
                    </div>

                    <div class="d-grid mt-4">
                        <a href="/checkout" class="btn btn-warning btn-lg fw-bold">
                            <i class="bi bi-credit-card-2-front me-2"></i> Ir a Pagar
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-3 text-center small text-muted">
                Pago seguro garantizado por Mercado Pago / PayPal / Tu Medio
            </div>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/javaScript.js"> </script>
    
</div>
    </main>
    <?php
        include_once('estructura/footer.php');
    ?>