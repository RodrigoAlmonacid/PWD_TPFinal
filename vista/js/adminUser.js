
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
    