var url;

function newMenu(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Menú');
    $('#fm').form('clear');
    
    // Por defecto habilitado al crear
    $('#select-estado').combobox('setValue', 'Habilitado');
    
    url = 'accion/accionMenu.php?operacion=alta';
}

function editMenu(){
    var row = $('#tg').treegrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Menú');
        $('#fm').form('load',row);
        console.log(row);
        // Lógica para el combo de estado (igual que en usuarios)
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