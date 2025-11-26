
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
    