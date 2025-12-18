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
        url = 'accion/accionProducto.php?operacion=actualizar&id='+row.idproducto;
    }
}
function saveProduct(){
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