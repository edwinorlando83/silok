<h2>Configuración de usuarios [Gustavo] </h2>
    <p  style="color:blue" >  Obligatorio </p>
    
    <table id="dg" title="Datos" class="easyui-datagrid" style="width:100%;height:100%"
            url="./controladores/configuracionesControlador.php?op=select"
            toolbar="#toolbar" pagination="false"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="geoserver"       width="50">geoserver</th> 
                <th field="geoserver_user"  width="50">geoserver_user</th>
                <th field="geoserver_pass"  width="50">geoserver_pass</th>
                <th field="wms"             width="50">wms</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-add" plain="true" onclick="newUser()">Agregar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-edit" plain="true" onclick="editUser()">Modificar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-remove" plain="true" onclick="destroyUser()">Eliminar</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>usuarios Información</h3>
            <div style="margin-bottom:10px">
                <input name="geoserver" class="easyui-textbox"  required="true" label="geoserver:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="geoserver_user" class="easyui-textbox" required="true" label="geoserver_user:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="geoserver_pass" class="easyui-textbox"  required="true" label="geoserver_pass:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="wms" class="easyui-textbox"  required="true" label="wms:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Registro');
            $('#fm').form('clear');
            url = './controladores/configuracionesControlador.php?op=insert';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Registro');
                $('#fm').form('load',row);
                url = './controladores/configuracionesControlador.php?op=update&&id='+row.id;
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
                $.messager.confirm('Confirmar','¿Estás seguro de que desea eliminar este registro?',function(r){
                    if (r){
                        $.post('./controladores/configuracionesControlador.php?op=delete',{id:row.id},function(result){
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