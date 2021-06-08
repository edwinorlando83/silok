<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Basic PropertyGrid - jQuery EasyUI Demo</title>
    
</head>
<body>
    <h2>Basic PropertyGrid</h2>
    <p>Click on row to change each property value.</p>
    <div style="margin:20px 0;">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="getChanges()">Grabar Datos</a>
    </div>
    <table id="pg" class="easyui-propertygrid" style="width:300px" data-options="
                url:'./controladores/configuracionesControlador.php?op=select_plus',
                method:'get',
                showGroup:true,
                scrollbarSize:0
            ">
            
    </table>
 
    <script type="text/javascript">
        function showGroup(){
            $('#pg').propertygrid({
                showGroup:true
            });
        }
        function hideGroup(){
            $('#pg').propertygrid({
                showGroup:false
            });
        }
        function showHeader(){
            $('#pg').propertygrid({
                showHeader:true
            });
        }
        function hideHeader(){
            $('#pg').propertygrid({
                showHeader:false
            });
        }
//interfaz

        function getChanges(){
            var s = '';
            var rows = $('#pg').propertygrid('getChanges');
            for(var i=0; i<rows.length; i++){
                s += rows[i].name + ':' + rows[i].value ;
                if (i<rows.length-1) {
                    s += ','
                }
            }
            

            var parametros = {
                "datos" : s
            };

           // alert("enviando >> " + s)
            $.ajax({
                url: "./controladores/configuracionesControlador.php?op=update_plus",
                type: "POST",
                data: parametros,
                success: function (response) {
                    alert('Correcto l!');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert(textStatus + errorThrown);
                }
            });    
            
             
        }

    </script>
</body>
</html>