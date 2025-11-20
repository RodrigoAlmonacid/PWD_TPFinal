    <?php
        include_once(__DIR__.'/estructura/encabezado.php');
    ?>
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
<body>
    <h2>Gestion de usuarios</h2>
    <p>Seleccione la acción que desea realizar</p>
    
    <table id="dg" title="Mis Usuarios" class="easyui-datagrid" style="width:700px;height:250px"
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
                        <option value="1">Habilitado</option>
                        <option value="0">Deshabilitado</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>
    <script type="text/javascript">
        var url;
        function newUser(){
            const selectDivId='#div-select';
            const inputDivId='#div-input';
            //Ocultar (Visibilidad):
            $(selectDivId).hide(); 
            //Deshabilitar (Funcionalidad):
            $('#select-edit').prop('disabled', true);
            $('#select-edit').textbox('options').required = false;
            //Mostrar (Visibilidad):
            $(inputDivId).show();   
            $('#input-edit').prop('disabled', false);
            $('#input-edit').textbox('options').required = true; 
            // 2. Deshabilitar el componente (lo excluye del envío y la validación)
            $('#select-edit').textbox('disable'); 
            //Habilitar (Funcionalidad):
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo usuario');
            $('#fm').form('clear');
            url = 'accion/accionUsuario.php?operacion=guardar';
        }
        function editUser(){
            const selectDivId='#div-select';
            const inputDivId='#div-input';
            //Ocultar (Visibilidad):
            $(inputDivId).hide();
            //Deshabilitar (Funcionalidad):
            $('#input-edit').prop('disabled', true);
            $('#input-edit').textbox('options') .required = false;
            //Mostrar (Visibilidad):
            $(selectDivId).show();   
            //Habilitar (Funcionalidad):
            $('#select-edit').textbox('enable');
            $('#select-edit').prop('disabled', false);
            var row = $('#dg').datagrid('getSelected');
            console.log(row)
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar usuario');
                $('#fm').form('load',row);
                url = 'accion/accionUsuario.php?operacion=actualizar&id='+row.idusuario;
            }
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
                    if (r){
                        $.post('destroy_user.php',{id:row.id},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
    </script>
</body>
</html>