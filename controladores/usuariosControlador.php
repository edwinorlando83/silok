<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$obj = json_decode(file_get_contents('php://input'));
$op = $_GET['op'];
if (!isset($op)) {
    echo json_encode("No se definió  la variable op");
    exit;
}
include '../db/db.php';
require '../utils/auth.php';
//include '../utils.php';
$db = new db();

switch ($op) {
 
 
    case 'select':

   //$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	//$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	//$offset = ($page-1)*$rows;
	    $result = array();
        $result["total"] = 2;
        $sql = "select * from usuario ";
        $select = $db->query($sql)->fetchAll();
        $result["rows"] = $select;
        echo json_encode($result);
        break;

        case 'insert': 
            $correo = $_POST['correo'];
            $nombre = $_POST['nombre'];         
            $password = $_POST['password'];         
            $sql = "INSERT INTO  usuario (correo, nombre, password ) VALUES( ?,?,?)";    
            $insert = $db->query($sql, $correo, $nombre, $password);
            if ($db->MensajeError) {
                $pos = strpos($db->MensajeError, "Duplicate entry");
                if ($pos === false) {
                    echo json_encode($db->MensajeError);
                } else {
                    echo json_encode('-999');
                }
    
            } else {   

                echo json_encode(array(
                   // 'password' =>  $insert->lastInsertID(),
                    'correo' => $correo,
                    'nombre' => $nombre,
                    'password' => $password
                ));

            }
 

        break;
 
        case 'update': 
            $correo     = $_POST['correo'];
            $nombre     = $_POST['nombre'];   
            $password   = $_POST['password'];         
            $sql = "update usuario set  correo=?, nombre=? where password =? ";    
            $update = $db->query($sql, $correo, $nombre ,$password );
              echo json_encode(array(
                    'password'  =>  $password,
                    'correo'    => $correo,
                    'nombre'    => $nombre                    
                ));
 
        break;

        case 'delete': 
    
            $password = $_REQUEST['password'];         
            $sql = "delete FROM usuario  where password =? ";    
            $delete = $db->query($sql, $password );
            if ($db->MensajeError) {
                echo json_encode($db->MensajeError);
            }
            else 
            echo json_encode(array('success'=>true));
 
        break;

    
        default:
        echo json_encode("Error no existe la opcion " . $op);

}





