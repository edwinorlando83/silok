<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$obj = json_decode(file_get_contents('php://input'));
$op = $_POST['op'];
if (!isset($op)) {
    echo json_encode("No se definió  la variable op");
    exit;
}
include 'db/db.php';
require 'utils/auth.php';
include 'utils.php';
$db = new db();

switch ($op) {
    case 'registromail':
        $usuario = $_POST['usuario'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
     
        $sql = "INSERT INTO  usuario (correo, nombre, password ) VALUES( ?,?,?)";

        $insert = $db->query($sql, $correo, $usuario, $password);
        if ($db->MensajeError) {
            $pos = strpos($db->MensajeError, "Duplicate entry");
            if ($pos === false) {
                echo json_encode($db->MensajeError);
            } else {
                echo json_encode('-999');
            }

        } else {
            $insert->affectedRows();
            echo json_encode($insert->query_count);
        }

        break;

 
    case 'login':
        $correo = $_POST['correo'];
        $password = $_POST['password'];

        $sql = "select count(*) as existe, nombre, foto from usuario where correo = ? and password=? and activo=1 ";
        $select = $db->query($sql, $correo, $password)->fetchArray();
        echo json_encode($select);

        break;

    case 'login-abogado':
        $correo = $_POST['cedula'];
        $password = $_POST['password'];
        $passwordmd5 = md5($password);
        $sql = "select  count(*) as existe, activo, codigo,ruc, nombre_amostar , foto from abogado  where activo ='1' and ruc = ?   and  password = ? ";
        $select = $db->query($sql, $correo, $passwordmd5)->fetchArray();
        echo json_encode($select);
        break;

     case 'recuperar-password-abogado':
     $cedula = $_POST['cedula'];

     $sqlConsulta="select count(*) as contar from abogado where ruc=?";
     $row = $db->query($sqlConsulta, $cedula)->fetchArray();
     $codigo_abogadoe =   $row['contar'];    
     if( $codigo_abogadoe == 0 )
     {
         echo json_encode('La cédula ingresada no existe.'); 
         exit();
     }   

     $sqlConsulta2="select  correo , nombre_amostar from abogado where ruc=?";     
     $abogadoobj= $db->query($sqlConsulta2,  $cedula  )->fetchArray(); 
     $correo =  $abogadoobj['correo'] ;
     $randstring = gettextoAleatorio();
     $passwordmd5 = md5($randstring); 
     $sql = "update abogado set password=? where ruc=?";
     $insert3 = $db->query($sql, $passwordmd5,  $cedula ); 
     echo json_encode('Se envío una nueva contraseña, a tu correo electrónico');  
     $body = getInfoCambioPassword($abogadoobj['nombre_amostar'] ,$cedula,$randstring); 

     enviarcorreo(  $correo,'Cambio de Contraseña en Mi Defensor ', $body );      
    break; 


    case 'cambiar-password-abogado':
        $cedula = $_POST['cedula'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $passwordmd5 = md5($password);
        $sql = "select  count(*) as existe , nombre_amostar ,  correo from abogado  where activo ='1' and ruc = ?   and  password = ? ";
        $select = $db->query($sql, $cedula, $passwordmd5)->fetchArray();
    
        if(   $select['existe'] == 0 )
        {
            echo json_encode('La contraseña anterior no es correcta'); 
            exit();
        }   

        $passwordmd5 = md5($password2); 
        $sql = "update abogado set password=? where ruc=?";
        $insert3 = $db->query($sql, $passwordmd5,  $cedula ); 
        echo json_encode('Contraseña modificada correctamente'); 
        $body = getInfoCambioPassword( $select['nombre_amostar'] ,$cedula,$password2);     
        enviarcorreo(  $select['correo'],'Cambio de Contraseña en Mi Defensor ', $body );
       break; 

    case 'nombreusuario':
        $correo = $_POST['correo'];
        $sql = " select  nombre,foto, password , d.dpa_descan , d.dpa_despro , u.cod_canton , u.cod_prov from usuario u 
        left join dpa d  on (  u.cod_canton = d.dpa_canton  )
        left join dpa d2 on ( u.cod_prov  = d.dpa_provin  )  where u.correo = ?  ";
        $select = $db->query($sql, $correo)->fetchArray();
        echo json_encode($select);

        break;
    case 'editarusuario':
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $cordenadax = $_POST['cordenadax'];
        $cordenaday = $_POST['cordenaday'];
        $cod_prov = $_POST['cod_prov'];
        $cod_canton = $_POST['cod_canton'];
        if( $cod_prov=='undefined' )
        $cod_prov='';
        if( $cod_canton=='undefined' )
        $cod_canton='';

        $sql = "UPDATE  usuario SET nombre=?, password=?,   cordenadax=?, cordenaday=?, updated=current_timestamp() , cod_prov=?, cod_canton=? WHERE correo=? ";
        $update = $db->query($sql, $nombre, $password, $cordenadax, $cordenaday,$cod_prov,$cod_canton, $correo);
        if ($db->MensajeError) {
            echo json_encode($db->MensajeError);

        } else {

            echo json_encode($update->affectedRows());
        }

        break;

    case 'eliminarusuario':
        $correo = $_POST['correo'];
        $comentario = '';
        if (isset($_POST['comentario'])) {
            $comentario = $_POST['comentario'];
        }

        $sql = "UPDATE  usuario SET activo='0' , deleted=current_timestamp() , comentario =?  WHERE correo=? ";
        $update = $db->query($sql, $comentario, $correo);
        if ($db->MensajeError) {
            echo json_encode($db->MensajeError);

        } else {

            echo json_encode($update->affectedRows());
        }

        break;

    case 'upload-fotousuario':
        $correo = $_POST['correo'];
        $mensaje = "";
        $data = $obj->file;
        echo json_encode($data);
        define('UPLOAD_DIR', 'fotos/');
        $img = $data;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $nombre = UPLOAD_DIR . uniqid() . '.jpeg';
        $success = file_put_contents($nombre, $data);
        $sql = " UPDATE  usuario SET foto=?  WHERE correo=?;";
        $ruta = 'https://midefensor.app/apirest/' . $nombre;
        $insert = $db->query($sql, $ruta, $correo);
        if ($db->MensajeError) {
            echo json_encode($db->MensajeError);

        } else {
            echo json_encode($update->affectedRows());
        }
        break;

    default:
        echo json_encode("Error no existe la opcion " . $op);

}





