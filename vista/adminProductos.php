<?php
    include_once('estructura/head.php');
?>
<script type="text/javascript" src="js/adminProductos.js"></script>

    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <?php
        include_once('../control/ABMProducto.php');
        $objProucto=new ABMProducto();
        $date=date('Y-m-d H:i:s');
    ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
        <?php if (in_array(2, $rolesUsuarioSimple)){ ?>
            <div class="card shadow-lg p-4">
                <h2>Gestion de Productos</h2>
                <p>Seleccione la acción que desea realizar</p>

                <table id="dg" title="Mis Usuarios" class="easyui-datagrid" style="width:900px;height:250px alig"
                        url="accion/accionListaProductos.php"
                        toolbar="#toolbar" pagination="true"
                        rownumbers="true" fitColumns="true" singleSelect="true">
                    <thead>
                        <tr>
                            <th field="idproducto" width="20">ID</th>
                            <th field="pronombre" width="50">Producto</th>
                            <th field="prodetalle" width="50">Detalle</th>
                            <th field="procantstock" width="20">Stock</th>
                            <th field="proprecio" width="50">Precio</th>
                            <th field="proimagen" width="70">Ruta imagen</th>
                            <th field="prodeshabilitado" width="50">Estado</th>
                        </tr>
                    </thead>
                </table>
                <div id="toolbar">
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProduct()">Nuevo</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProduct()">Editar</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyProduct()">Eliminar</a>
            </div>
            
            <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
                <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px" enctype="multipart/form-data">
                    <h3>Productos</h3>
                    <div style="margin-bottom:10px">
                        <input id="pronombre" name="pronombre" class="easyui-textbox" required="true" label="Nombre y apellido:" style="width:100%">
                    </div>
                    <div style="margin-bottom:10px">
                        <input id="prodetalle" name="prodetalle" class="easyui-textbox" required="true" label="Detalle:" style="width:100%">
                    </div>
                    <div style="margin-bottom:10px">
                        <input id="procantstock" name="procantstock" class="easyui-textbox" required="true" label="Stock:" style="width:100%">
                    </div>
                    <div style="margin-bottom:10px">
                        <input id="proprecio" name="proprecio" class="easyui-textbox" required="true" label="Precio:" style="width:100%">
                    </div>
                    <div style="margin-bottom:10px">
                        <input id="imgProducto" 
                                name="imgProducto" 
                                class="easyui-filebox" 
                                label="Imagen:" 
                                
                                style="width:100%" 
                                data-options="buttonText:'Elegir archivo', prompt:'Seleccione una imagen...'">
                    </div>
                    <div id="div-select" style="margin-bottom:10px;">
                        <select id="select-edit" name="prodeshabilitado" class="easyui-combobox" label="Estado" labelPosition="top" required style="width:100%">
                            <option value="Habilitado">Habilitado</option>
                            <option value="Deshabilitado">Deshabilitado</option>
                        </select>
                    </div>
                </form>
            </div>
            <div id="dlg-buttons">
                <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProduct()" style="width:90px">Guardar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
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
                            No posee los permisos necesarios para acceder al módulo de <strong>Administración de Productos</strong>.
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
    <script type="text/javascript" src="js/adminProductos.js"></script>
    </main>
    <?php
        include_once('estructura/footer.php');
    ?>