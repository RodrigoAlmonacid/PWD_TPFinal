function resumenCompra(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        // Abrimos el diálogo
        $('#dlg').dialog('open').dialog('setTitle', 'Resumen de Compra ID: ' + row.idcompra);
        
        // Cargamos los items de esa compra en el datagrid interno
        // Nota: Asegúrate que este PHP devuelva el JSON de los items
        $('#dg-detalle').datagrid({
            url: 'accion/listarItemsCompra.php?idcompra=' + row.idcompra
        });
    } else {
        $.messager.alert('Atención', 'Por favor, seleccione una compra de la lista.', 'warning');
    }
}

function cambiarEstado(nuevoEstado) {
    if(nuevoEstado=='Aprobada'){
        nuevoEstado=3;
    }
    else if(nuevoEstado=='Cancelada'){
        nuevoEstado=4;
    }
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.post('accion/cambiarEstado.php', {
            idcompra: row.idcompra,
            idcompraestadotipo: nuevoEstado // Ejemplo: 'aceptada' o 2
        }, function(resultado) {
            // Esta función se ejecuta cuando el servidor responde
            if (resultado.respuesta) {
                $.messager.show({ title: 'Éxito', msg: 'Estado actualizado' });
                $('#dg').datagrid('reload'); // Recargamos la tabla principal
                $('#dlg').dialog('close');    // Cerramos el detalle
            } else {
                $.messager.alert('Error', resultado.errorMsg);
            }
        }, 'json');
    }
}