<?php
include_once('estructura/head.php');
?>
<script type="text/javascript" src="js/adminMenu.js"></script>
</head>
<body>
    <?php include_once('estructura/menuPrincipal.php'); ?>

    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>

    <div class="container my-5">
        <?php if (in_array(1, $rolesUsuarioSimple)){ ?>
        <div class="table-responsive">
            <table id="tg" class="easyui-treegrid" title="Administración de Menús" style="width:100%;height:600px"
                data-options="
                    url: 'accion/accionListarMenu.php',
                    method: 'get',
                    toolbar: '#toolbar',
                    rownumbers: true,
                    pagination: false,
                    idField: 'idmenu',
                    treeField: 'menombre',
                    fitColumns: true
                ">
                <thead>
                    <tr>
                        <th field="menombre" width="50">Nombre</th>
                        <th field="medescripcion" width="50">Ruta/redirección</th>
                        <th field="iconoBootstrap" width="50">Icono Bootstrap</th>
                        <th field="idmenu" width="20">ID</th>
                        <th field="idpadre" width="20">ID Padre</th>
                        <th field="medeshabilitado" width="30">Estado</th>
                    </tr>
                </thead>
            </table>

            <div id="toolbar">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMenu()">Nuevo Menú</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">Editar Menú</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyMenu()">Eliminar Menú</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-man" plain="true" onclick="manageRoles()">Gestionar Roles</a>
            </div>

            <div id="dlg" class="easyui-dialog" style="width:500px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
                <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
                    <h3>Información del Menú</h3>
                    
                    <div style="margin-bottom:10px">
                        <input name="menombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
                    </div>
                    
                    <div style="margin-bottom:10px">
                        <input name="medescripcion" class="easyui-textbox" required="true" label="Ruta/Desc:" style="width:100%">
                    </div>

                    <div id="divIcono" style="margin-bottom:10px">
                        <input id="icono" name="iconoBootstrap" class="easyui-textbox" required="true" label="Icono:" style="width:100%">
                    </div>

                    <div style="margin-bottom:10px">
                        <input class="easyui-combobox" 
                            name="idpadre"
                            label="Menú Padre:" 
                            style="width:100%"
                            data-options="
                                url:'accion/accionListarMenu.php',
                                method:'get',
                                valueField:'idmenu',
                                textField:'menombre',
                                panelHeight:'auto',
                                labelPosition:'top'
                            ">
                    </div>

                    <div id="div-estado" style="margin-bottom:10px">
                        <select id="select-estado" name="medeshabilitado" class="easyui-combobox" label="Estado" labelPosition="top" style="width:100%"
                            data-options="panelHeight:'auto', editable:false">
                            <option value="Habilitado">Habilitado</option>
                            <option value="Deshabilitado">Deshabilitado</option>
                        </select>
                    </div>

                </form>
            </div>
            <div id="dlg-roles" class="easyui-dialog" style="width:500px;height:400px;padding:10px"
                data-options="closed:true,modal:true,title:'Gestionar Roles'">
            <div style="margin-bottom:10px; display:flex; gap:5px;">
                <select id="combo-roles" class="easyui-combobox" name="idrol" style="width:70%" 
                    data-options="
                        url:'accion/accionListarRoles.php', 
                        method:'get',
                        valueField:'idrol',
                        textField:'rodescripcion',
                        panelHeight:'auto',
                        label:'Asignar Rol:',
                        labelWidth:80
                    ">
                </select>
                <a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="addRole()">Agregar</a>
            </div>
            <table id="dg-roles" class="easyui-datagrid" style="width:100%;height:280px"
                data-options="singleSelect:true, rownumbers:true">
                <thead>
                    <tr>
                        <th field="rodescripcion" width="70%">Rol</th>
                        <th field="action" width="30%" formatter="formatDeleteRole">Acción</th>
                    </tr>
                </thead>
            </table>
            </div>
            <div id="dlg-buttons">
                <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Guardar</a>
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
                            No posee los permisos necesarios para acceder al módulo de <strong>Administración de Usuarios</strong>.
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
           <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        --> 
           <script src="js/adminMenu.js" type="text/javascript"></script>
        </div>
    </div>
<?php include_once('estructura/footer.php'); ?>