<?php
    include_once('estructura/head.php');
?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">

<div class="container my-5">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $ruta ?>/vista/index.php" class="text-decoration-none text-dark">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= $ruta ?>/vista/productoAAA.php" class="text-decoration-none text-dark">Pilas AAA</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pila Alcalina AAA</li>
        </ol>
    </nav>
    
    <div class="row">
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <img src="imagenes/pilaAAAx2.jpg" class="img-fluid p-4 rounded" alt="Pila Alcalina Ultra Power">
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                <img src="imagenes/pilaAAA.jpg" alt="Vista 1" class="img-thumbnail me-2" style="width: 80px; cursor: pointer;">
                <img src="imagenes/pilaAAA_2.jpg" alt="Vista 2" class="img-thumbnail me-2" style="width: 80px; cursor: pointer;">
            </div>
        </div>
        
        <div class="col-md-6">
            <h1 class="fw-bold">Pila Alcalina AAA</h1>
            <p class="text-muted fs-5">Marca: Energizer Pro</p>
            
            <h2 class="text-warning display-4 my-3 fw-bold border-bottom pb-2">
                $580.00 <small class="text-muted fs-5">(IVA incluido)</small>
            </h2>

            <p class="lead">
                Máximo rendimiento para tus dispositivos de alto consumo. Perfecta para cámaras, juguetes motorizados y flashes. ¡Dura hasta 10 veces más!
            </p>
            
            <hr>

            <form action="/carrito/agregar" method="POST">
                <input type="hidden" name="product_id" value="123">
                
                <div class="mb-3">
                    <label for="selectPack" class="form-label fw-bold">Selecciona el paquete:</label>
                    <select class="form-select" id="selectPack" name="pack_id" required>
                        <option value="4" selected>Pack x4 (Alcalina)</option>
                        <option value="8">Pack x8 (Alcalina)</option>
                        <option value="4R">Pack x4 (Recargable) - $890.00</option>
                    </select>
                </div>

                <div class="row align-items-center mb-4">
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
                            required
                        >
                    </div>
                    <div class="col-12 mt-2">
                        <span class="text-success small">Stock disponible: 98 unidades</span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark btn-lg">
                        <i class="bi bi-cart-plus-fill me-2"></i> Añadir al Carrito
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <a href="#" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-heart"></i> Añadir a Favoritos
                </a>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <div class="row">
        <div class="col-12">
            
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Descripción Completa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab" aria-controls="specs" aria-selected="false">Especificaciones Técnicas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="envio-tab" data-bs-toggle="tab" data-bs-target="#envio" type="button" role="tab" aria-controls="envio" aria-selected="false">Envío y Devoluciones</button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 p-4 bg-white shadow-sm" id="productTabsContent">
                
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="desc-tab">
                    <h4>Características Principales</h4>
                    <ul>
                        <li>Tecnología PowerBoost para un flujo constante de energía.</li>
                        <li>Diseño a prueba de fugas: protege tus dispositivos valiosos.</li>
                        <li>Ideal para usos críticos y de larga duración (mandos, linternas, juguetes).</li>
                    </ul>
                    <p>Las pilas Ultra Power ofrecen la combinación perfecta entre durabilidad y potencia, asegurando que tus equipos funcionen al máximo rendimiento sin interrupciones. Olvídate de cambiar pilas constantemente y disfruta de la tranquilidad que solo la calidad premium puede ofrecerte.</p>
                </div>
                
                <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                    <h4>Detalles del Producto</h4>
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 30%;">Tipo de Pila</th>
                                <td>Alcalina</td>
                            </tr>
                            <tr>
                                <th scope="row">Voltaje Nominal</th>
                                <td>1.5V</td>
                            </tr>
                            <tr>
                                <th scope="row">Formato</th>
                                <td>AAA (Triple A)</td>
                            </tr>
                            <tr>
                                <th scope="row">Recargable</th>
                                <td class="text-danger fw-bold">No</td>
                            </tr>
                            <tr>
                                <th scope="row">Capacidad (mAh)</th>
                                <td>2800 mAh (Estimado)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="envio" role="tabpanel" aria-labelledby="envio-tab">
                    <h4>Información Logística</h4>
                    <p><strong>Costo de Envío:</strong> Calculado al finalizar la compra. Envío gratis en compras superiores a $5000.</p>
                    <p><strong>Tiempo de Entrega:</strong> 3-5 días hábiles en CABA y GBA. 5-10 días hábiles al interior del país.</p>
                    <p><strong>Política de Devolución:</strong> Aceptamos devoluciones de productos sin abrir dentro de los 30 días de la compra. Las pilas tienen 6 meses de garantía por fallas de fábrica.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-5">
        <h3 class="mb-3">Productos que te pueden interesar</h3>
        <div class="row row-cols-2 row-cols-md-4 g-4">
            <div class="col">... Card de Producto ...</div>
            <div class="col">... Card de Producto ...</div>
        </div>
    </div>

    </div>
    </main>

<?php
        include_once('estructura/footer.php');
    ?>