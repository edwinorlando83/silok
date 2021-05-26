<?php
  
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/SMTP.php");
 

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

    //Recipients
    $mail->setFrom('contacto@midefensor.app', 'Mi Defensor');
    $mail->addAddress('edwin_orlando83@hotmail.com' );     
    $length =6;
    $randstring =  substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
 
    // Content
    $mail->isHTML(true);                              
    $mail->Subject = 'Saludos';
	 
    $mail->Body    = "Gracias por registrarte en MiDefensor.app <b> $randstring </b>";
 

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
