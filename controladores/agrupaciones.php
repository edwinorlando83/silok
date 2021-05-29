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
include '../utils.php';
$db = new db();

switch ($op) {
 
 
    case 'select':

   //$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	//$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	//$offset = ($page-1)*$rows;
	$result = array();
        $result["total"] = 2;
        $sql = "select * from agrupacion ";
        $select = $db->query($sql)->fetchAll();
        $result["rows"] = $select;
        echo json_encode($result);
        break;

        case 'insert': 
            $nombre = $_POST['nombre'];
            $orden = $_POST['orden'];         
            $sql = "INSERT INTO  agrupacion (nombre, orden ) VALUES( ?,?)";    
            $insert = $db->query($sql, $nombre, $orden );
            if ($db->MensajeError) {
                $pos = strpos($db->MensajeError, "Duplicate entry");
                if ($pos === false) {
                    echo json_encode($db->MensajeError);
                } else {
                    echo json_encode('-999');
                }
    
            } else {   

                echo json_encode(array(
                    'id' =>  $insert->lastInsertID(),
                    'nombre' => $nombre,
                    'orden' => $orden                    
                ));

            }
 

        break;
 
        case 'update': 
            $nombre = $_POST['nombre'];
            $orden = $_POST['orden'];   
            $id = $_GET['id'];         
            $sql = "update agrupacion set  nombre=?, orden=? where id =? ";    
            $update = $db->query($sql, $nombre, $orden ,$id );
              echo json_encode(array(
                    'id' =>  $id,
                    'nombre' => $nombre,
                    'orden' => $orden                    
                ));
 
        break;

        case 'delete': 
    
            $id = $_REQUEST['id'];         
            $sql = "delete FROM agrupacion  where id =? ";    
            $delete = $db->query($sql, $id );
            if ($db->MensajeError) {
                echo json_encode($db->MensajeError);
            }
            else 
            echo json_encode(array('success'=>true));
 
        break;

    
        default:
        echo json_encode("Error no existe la opcion " . $op);

}





