
        var url;
        function newUser(){
            const selectDivId=document.getElementById('div-select');
            const inputDivId=document.getElementById('div-input');
            //Ocultar/mostrar
            $(selectDivId).hide();
            $(inputDivId).show();  
            //Deshabilitar/habilitar
            $('#input-edit').textbox('enable'); 
            $('#select-edit').combobox('disable');
            //
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo usuario');
            $('#fm').form('clear');
            url = 'accion/accionUsuario.php?operacion=guardar';
        }
        function editUser(){
            const selectDivId=document.getElementById('div-select');
            const inputDivId=document.getElementById('div-input');
            //Ocultar/mostrar
            $(selectDivId).show();
            $(inputDivId).hide();  
            //Deshabilitar/habilitar
            $('#input-edit').textbox('disable'); 
            $('#select-edit').combobox('enable');
            //
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar usuario');
                $('#fm').form('load',row);
                url = 'accion/accionUsuario.php?operacion=actualizar&id='+row.idusuario;
            }
        }
        function saveUser(){
            console.log("entra al save");
            $('#fm').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    console.log("entra a validar");
                    if ($(this).form('validate')){
                        console.log("valida");
                    }
                    else {
                        console.log("no valida");
                    }
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
                $.messager.confirm('Confirmación','¿Está seguro de eliminar al usuario? Acción irrebersible.',function(r){
                    if (r){
                        $.post('accion/accionUsuario.php?operacion=eliminar',{id:row.idusuario},function(result){
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
        var idUsuarioSeleccionado;

function manageRoles() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        idUsuarioSeleccionado = row.idusuario;
        $('#dlg-roles').dialog('open');
        // Cargamos la grilla de roles de ESTE usuario
        $('#dg-roles').datagrid({
            url: 'accion/accionUsuarioRol.php?operacion=listar&idusuario=' + row.idusuario
        });
    } else {
        $.messager.alert('Atención', 'Selecciona un usuario primero.', 'warning');
    }
}

function addRole() {
    var idRol = $('#combo-roles').combobox('getValue');
    if (idRol) {
        $.post('accion/accionUsuarioRol.php?operacion=alta', 
            { idusuario: idUsuarioSeleccionado, idrol: idRol }, 
            function(result) {
                if (result.success) {
                    $('#dg-roles').datagrid('reload'); // Recargamos la lista
                    $.messager.show({title: 'Éxito', msg: 'Rol asignado correctamente'});
                } else {
                    $.messager.show({title: 'Error', msg: result.errorMsg});
                }
            }, 'json');
    } else {
        $.messager.alert('Error', 'Selecciona un rol de la lista.');
    }
}

// Formateador para poner el botón de eliminar en la grilla
function formatDeleteRole(val, row) {
    return '<a href="javascript:void(0)" onclick="deleteRole('+row.idrol+')">Quitar</a>';
}

function deleteRole(idRol) {
    $.messager.confirm('Confirmar', '¿Quitar este rol?', function(r) {
        if (r) {
            $.post('accion/accionUsuarioRol.php?operacion=baja', 
                { idusuario: idUsuarioSeleccionado, idrol: idRol }, 
                function(result) {
                    if (result.success) {
                        $('#dg-roles').datagrid('reload');
                    } else {
                        $.messager.show({title: 'Error', msg: result.errorMsg});
                    }
                }, 'json');
        }
    });
}
    