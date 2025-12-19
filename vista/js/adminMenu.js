var url;

function newMenu(){
    const selectDivId=document.getElementById('divIcono');
    //Ocultar/mostrar
    $(selectDivId).hide();
    //Deshabilitar/habilitar 
    $('#icono').combobox('disable');
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Menú');
    $('#fm').form('clear');
    
    // Por defecto deshabilitado al crear
    $('#select-estado').combobox('setValue', 'Deshabilitado');
    
    url = 'accion/accionMenu.php?operacion=alta';
}

function editMenu(){
    const selectDivId=document.getElementById('divIcono');
    //Ocultar/mostrar
    $(selectDivId).show(); 
    //Deshabilitar/habilitar
    $('#icono').combobox('enable');
    //
    var row = $('#tg').treegrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Menú');
        $('#fm').form('load',row);
        // Lógica para el cambio de estado (igual que en usuarios)
        if(row.medeshabilitado == null || row.medeshabilitado == "0000-00-00 00:00:00"){
             $('#select-estado').combobox('setValue', 'Habilitado');
        } else {
             $('#select-estado').combobox('setValue', 'Deshabilitado');
        }

        url = 'accion/accionMenu.php?operacion=modificacion&idmenu='+row.idmenu;
    } else {
        $.messager.alert('Atención', 'Por favor selecciona un menú para editar.', 'warning');
    }
}

function saveMenu(){
    $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        
        success: function(result){
            if (result === "") {
        $.messager.show({ title: 'Error', msg: 'El servidor no respondió nada. Revisa el PHP.' });
        return;
        }
        var result = JSON.parse(result);
            if (result.errorMsg){
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {
                $('#dlg').dialog('close');      
                $('#tg').treegrid('reload');    // Recargamos el árbol
            }
        }
    });
}

function destroyMenu(){
    var row = $('#tg').treegrid('getSelected');
    if (row){
        $.messager.confirm('Confirmar','¿Estás seguro de eliminar este menú?',function(r){
            if (r){
                $.post('accion/accionMenu.php?operacion=baja',{idmenu:row.idmenu},function(result){
                    if (result.success){
                        $('#tg').treegrid('reload');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                },'json');
            }
        });
    } else {
        $.messager.alert('Atención', 'Por favor selecciona un menú para eliminar.', 'warning');
    }
}

//sección de roles (corregir, está copiado de roles de usuarios)
function manageRoles() {
    var row = $('#dg').datagrid('getSelected');
    console.log(row);
    if (row) {
        idMenuSeleccionado = row.idmenu;
        $('#dlg-roles').dialog('open');
        // Cargamos la grilla de roles de este menu
        $('#dg-roles').datagrid({
            url: 'accion/accionMenuRol.php?operacion=listar&idmenu=' + idMenuSeleccionado
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
                            console.log(result);
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