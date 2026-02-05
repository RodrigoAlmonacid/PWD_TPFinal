<?php
    include_once('estructura/head.php');
?>
<script type="text/javascript" src="js/adminUser.js"></script>
<!--
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
-->
    <?php
        include_once('../control/ABMusuario.php');
        $objUsuario=new ABMUsuario();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date=date('Y-m-d H:i:s');
    ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include_once('estructura/menuPrincipal.php'); ?>
    <main class="container my-5 flex-grow-1">
        <?php if (in_array(1, $rolesUsuarioSimple)){ ?>
            <div class="card shadow-lg p-4">
                <h2>Gestion de usuarios</h2>
                <p>Seleccione la acción que desea realizar</p>

                <table id="dg" title="Mis Usuarios" class="easyui-datagrid" style="width:700px;height:250px alig"
                        url="accion/accionListaUsuarios.php"
                        toolbar="#toolbar" pagination="true"
                        rownumbers="true" fitColumns="true" singleSelect="true">
                    <thead>
                        <tr>
                            <th field="usnombre" width="50">Nombre y Apellido</th>
                            <th field="usmail" width="50">Email</th>
                            <th field="usdeshabilitado" width="50">Estado</th>
                        </tr>
                    </thead>
                </table>
                <div id="toolbar">
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-man" plain="true" onclick="manageRoles()">Gestionar Roles</a>
            </div>
            
            <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
                <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
                        <h3>Usuario</h3>
                        <div style="margin-bottom:10px">
                            <input id="usnombre" name="usnombre" class="easyui-textbox" required="true" label="Nombre y apellido:" style="width:100%">
                        </div>
                        <div style="margin-bottom:10px">
                            <input id="usmail" name="usmail" class="easyui-textbox" required="true" validType="email" label="Email:" style="width:100%">
                        </div>
                        <div style="margin-bottom:10px">
                            <div id="div-input" style="margin-bottom:10px;">
                                <input id="input-edit" name="uspass" class="easyui-textbox" required="true" label="Contraseña" style="width:100%">
                            </div>
                            <div id="div-select" style="margin-bottom:10px;">
                                <select id="select-edit" name="usdeshabilitado" class="easyui-combobox" label="Estado" labelPosition="top" required style="width:100%">
                                    <option value="Habilitado">Habilitado</option>
                                    <option value="Deshabilitado">Deshabilitado</option>
                                </select>
                            </div>
                        </div>
                    </form>
            </div>
            </div>
            <div id="dlg-roles" class="easyui-dialog" style="width:500px;height:400px;padding:10px"
                data-options="closed:true,modal:true,title:'Gestionar Roles del Usuario'">
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
                <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
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

    <script src="<?= $ruta ?>/vista/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/adminUser.js"></script>
    </main>
    <?php
        include_once('estructura/footer.php');
    ?>