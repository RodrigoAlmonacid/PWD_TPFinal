var url;
function newProduct(){
    const selectDivId=document.getElementById('div-select');
    //Ocultar/mostrar
    $(selectDivId).hide();
    //Deshabilitar/habilitar 
    $('#select-edit').combobox('disable');
    //
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo producto');
    $('#fm').form('clear');
    url = 'accion/accionProducto.php?operacion=guardar';
}
function editProduct(){
    const selectDivId=document.getElementById('div-select');
    //Ocultar/mostrar
    $(selectDivId).show(); 
    //Deshabilitar/habilitar
    $('#select-edit').combobox('enable');
    //
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar producto');
        $('#fm').form('load',row);
        url = 'accion/accionProducto.php?operacion=actualizar&idproducto='+row.idproducto;
    }
}
function saveProduct(){
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
                $('#dlg').dialog('close');        //cierro el diálogo
                $('#dg').datagrid('reload');    //recargo el datagrid
            }
        }
    });
}
function destroyProduct(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirmación','¿Está seguro de eliminar al producto? Acción irrebersible.',function(r){
            if (r){
                $.post('accion/accionProducto.php?operacion=eliminar',{id:row.idproducto},function(result){
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