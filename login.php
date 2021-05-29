<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>GEOVISOR</title>
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.9.14/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.9.14/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<script type="text/javascript" src="jquery-easyui-1.9.14/jquery.min.js"></script>
    <script type="text/javascript" src="jquery-easyui-1.9.14/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="jquery-easyui-1.9.14/locale/easyui-lang-es.js"></script>
    
</head>
<body class="easyui-layout">
<div class="titulo"> 
	   Sistema Integrado para Administración 
 </div>
 <p> </p>
<p></p>

	<center> 
<div  class="easyui-panel"   title="Ingreso al Sistema " style="width:100%;max-width:400px;padding:30px 60px;">
        <form id="ff" method="post"
          onsubmit="return submitForm();" >
            <div style="margin-bottom:20px">
                <input class="easyui-textbox" value='gustavo@gmail.com' name="txtcorreo" style="width:100%" data-options="label:'Correo:',required:true">
            </div>
            <div style="margin-bottom:20px">
                <input  class="easyui-passwordbox"  value='gustavo'  iconWidth="28"  name="txtpassword" style="width:100%" data-options="label:'Password:',required:true,validType:'password'">
            </div>
          
        </form>
        <div style="text-align:center;padding:5px 0">
         <button class="easyui-linkbutton"  type="submit" form="ff" value="Continue" style="width:80px" >Login</button>
        </div>
	</div> 

    <?php 
     session_start();
     unset(  $_SESSION['usuario'] );
     require('db/db.php');
     $db = new db();
     $mensaje=" ";
       if( isset($_POST["txtcorreo"]) &&  isset($_POST["txtpassword"])   )
        {
            $txtcorreo =   $_POST['txtcorreo'];
            $txtpassword =  $_POST['txtpassword'];

            $row = $db->query('SELECT * FROM usuario WHERE correo = ? AND password = ?', $txtcorreo, $txtpassword)->fetchArray();
            //echo  $row['nombre'];
            $resultado = $row['nombre'] ?? '';
            if ($resultado=='')   {
                $mensaje ="Correo y Password Incorrecto";
            } 
            else {
                $_SESSION['usuario'] = $row['nombre'];
                echo $row['nombre'];
                header("location: admin.php") ;
            }

            $db->close();   
        }


    ?>
    <div> <?php  echo  $mensaje;?>   </div>
    </center>
    <script>
        function submitForm(){            
            var isvalid = $( "#ff" ).form('validate'); 
            return isvalid;
        }
       
    </script>

 
</body>
</html>