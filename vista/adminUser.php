<?php
    include_once('estructura/head.php');
?>
<script type="text/javascript" src="js/adminUser.js"></script>
</head>
<body>
<?php include_once('estructura/menuPrincipal.php'); ?>
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <?php
        include_once('../control/ABMusuario.php');
        $objUsuario=new ABMUsuario();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date=date('Y-m-d H:i:s');
    ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="container my-5 flex-grow-1">
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
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>
    <script type="text/javascript" src="js/adminUser.js"></script>
    </main>
   <?php
        include_once('estructura/footer.php');
    ?>