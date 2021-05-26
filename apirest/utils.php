<?php
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/SMTP.php");

function enviarcorreo($destino,$subject, $body){
    try {
	
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        //Server settings
                        
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.zoho.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'contacto@midefensor.app';                    
        $mail->Password   = 'Wg9QeXei^FG*^X@ebC';                               
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;         
        $mail->Port       = 465;                                    
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom('contacto@midefensor.app', 'Mi Defensor ');
        $mail->addAddress( $destino );     
    
        // Content
        $mail->isHTML(true);                              
        $mail->Subject = $subject; ;
         
        $mail->Body    = $body;
    
        $mail->send();
      
    } catch (Exception $e) {
       
    }
    
}
function getInfoImportante(){
return "  <hr/>  <p> <b> IMPORTANTE   </b></p>
<ul>
<li> Este correo es generado automáticamente, por favor no responder al mismo </li>
<li> Mi Defensor, no se hace responsable del uso inadecuado de las credenciales y de la información ingresada. </li>
<li> El usuario autoriza a Mi Defensor para que la información suministrada sea verificada. </li>

</u>";

}

function getInfoIngresoAbogado( $nombreAbogado,$cedula,$password){
    return   "  <img src='https://midefensor.app/logo.png'>   
    <p> Estimado/a </p>
  <p> ".$nombreAbogado." </p>
  <p> Mi Defensor le da las gracias por registrarte en nuestra aplicación </p>
  <p> Usuario: <b>  $cedula </b> </p>
  <p> Clave:   <b>  $password </b> </p>        
  ".getInfoImportante();
    
    }

function getInfoCambioPassword( $nombreAbogado,$cedula,$password){
    return   "  <img src='https://midefensor.app/logo.png'>   
    <p> Estimado/a </p>
  <p> ".$nombreAbogado." </p>
  <p> Su contraseña fue cambiada exitosamente. </p>
  <p> Usuario: <b>  $cedula </b> </p>
  <p> Clave:   <b>  $password </b> </p>        
  ".getInfoImportante();
    
    }

    function gettextoAleatorio(){
        $length =6;
      return  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyz', ceil($length/strlen($x)) )),1,$length);
    }