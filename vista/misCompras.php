<?php
    include_once('estructura/head.php');
?>
<script type="text/javascript" src="js/adminProductos.js"></script>

    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
        <?php if (in_array(3, $rolesUsuarioSimple)){ ?>
            <div class="card shadow-lg p-4">
                <h2>Historial de compras</h2>

                <table id="dg" title="Compras" class="easyui-datagrid" style="width:900px;height:250px alig"
                        url="accion/accionListaCompras.php?usuario=cliente&&idusuario=<?= $idUsuario ?>"
                        toolbar="#toolbar" pagination="true"
                        rownumbers="true" fitColumns="true" singleSelect="true">
                    <thead>
                        <tr>
                            <th field="idcompra" width="20">ID Compra</th>
                            <th field="cefechaini" width="50">Fecha de envío</th>
                            <th field="estado" width="50">Estado</th>
                            <th field="cefechafin" width="50">Fecha de resolución</th>
                        </tr>
                    </thead>
                </table>
                <div id="toolbar">
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="resumenCompra()">Ver</a>
                </div>
            
            <div id="dlg" class="easyui-dialog" style="width:600px;height:400px;padding:10px 20px"
                closed="true" buttons="#dlg-buttons" modal="true">
                <h3>Detalle de la Compra</h3>
                <table id="dg-detalle" class="easyui-datagrid" style="width:100%;height:250px"
                    fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="producto" width="50">Producto</th>
                        <th field="cantidad" width="20">Cantidad</th>
                        <th field="stock" width="20">Stock</th>
                    </tr>
                </thead>
                </table>
            </div>
            <div id="dlg-buttons">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="irAPagar()">Ir a pagar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="cambiarEstado('Cancelada')">Cancelar Compra</a>
            </div>
    <?php } 
        else{ ?>
            <div class="container d-flex justify-content-center align-items-center vh-100">
                <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded text-center" style="max-width: 500px; width: 100%;">
                    <div class="card-body p-5">
                        <div class="mb-4 text-danger">
                            <i class="bi bi-shield-lock-fill" style="font-size: 4rem;"></i>
                        </div>

                        <h2 class="card-title fw-bold mb-3 text-secondary">Acceso Restringido</h2>

                        <p class="card-text text-muted mb-4 fs-5">
                            No posee los permisos necesarios para acceder al módulo de <strong>Historial de compras</strong>.
                        </p>

                        <hr class="my-4">

                        <p class="small text-secondary mb-3">Si cree que esto es un error, contacte al administrador.</p>

                        <a href="index.php" class="btn btn-outline-danger w-100 rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
    <?php  } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/adminCompras.js"></script>
    <script>
$(function(){
    // Buscamos si en la URL dice "pago=exito"
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('pago') === 'exito') {
        const id = urlParams.get('id');
        $.messager.show({
            title: '¡Excelente!',
            msg: 'La compra #' + id + ' se acreditó correctamente. ¡Gracias!',
            showType: 'fade',
            timeout: 5000, // Se cierra solo en 5 segundos
            style: {
                right: '',
                bottom: ''
            }
        });
        
        // Opcional: Limpiar la URL para que si refresca no vuelva a salir el cartel
        window.history.replaceState({}, document.title, "misCompras.php");
    }
});
</script>
    </main>
    <?php
        include_once('estructura/footer.php');
    ?>