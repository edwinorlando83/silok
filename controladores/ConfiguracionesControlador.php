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
    
        case 'select_plus1':

            //$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            //$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
            //$offset = ($page-1)*$rows;
            $result = array();
            
            $result["totales"] = 2;
            $sql        = "select * from configuraciones";
            $select     = $db->query($sql)->fetchAll();
           
            $result["rows"] = $select;    
             /* cargar datos 
                    var row = { 
                    nombre : 'AddName' ,
                    valor : '' ,
                    grupo : 'Configuración de marketing' ,
                    editor : 'texto'
                    };
                    $ ( '#pg' ). propertygrid ( 'appendRow' , fila );             
             */
                    
            echo json_encode($result);
        break;


        case 'select':

            //$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	        //$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	        //$offset = ($page-1)*$rows;
	        $result = array();
            $result["total"] = 2;
            $sql        = "select * from configuraciones22 ";
            $select     = $db->query($sql)->fetchAll();
            $result["rows"] = $select;
            echo json_encode($result);
        break;

        case 'insert': 
            $geoserver      = $_POST['geoserver'];
            $geoserver_user = $_POST['geoserver_user'];         
            $geoserver_pass = $_POST['geoserver_pass'];         
            $wms            = $_POST['wms'];         
            $sql = "INSERT INTO  configuraciones (geoserver, geoserver_user,geoserver_pass, wms ) VALUES( ?,?,?,?)";    
            $insert = $db->query($sql, $geoserver, $geoserver_user, $geoserver_pass, $wms );
            if ($db->MensajeError) {
                $pos = strpos($db->MensajeError, "Duplicate entry");
                if ($pos === false) {
                    echo json_encode($db->MensajeError);
                } else {
                    echo json_encode('-999');
                }
    
            } else {   

                echo json_encode(array(
                    'id'            =>  $insert->lastInsertID(),
                    'geoserver'     => $geoserver,
                    'geoserver_user'=> $geoserver_user,                    
                    'geoserver_pass'=> $geoserver_pass,
                    'wms'           => $wms 
                ));

            }
 

        break;
 // controlador
case 'update_plus': 
    $datos = $_POST['datos'];
    
    //echo($datos); 
    //echo(" ----> ");
    $array = explode(",", $datos);
    
    for ($i = 0; $i < count($array); $i++) {
        //echo $i;

       
        $cadena = $array[$i];
        $dato = explode(":",$cadena);
         
        //echo($array[0]);


        $nombre = $dato[0];
        $valor  = $dato[1];  

        /* 
        echo("\n");
        echo ("nombre   :".$nombre.", ");          
        echo ("valor    :".$valor);
       */

        if (isset($nombre) && isset($valor)){
            //echo ("ok");
            //$sql = "update configuraciones set  geoserver=?, geoserver_user=?, geoserver_pass=?, wms=? where id =? ";    
            $sql = "update configuraciones set  valor=? where nombre=? ";    
            $update = $db->query($sql, $valor, $nombre);
            echo json_encode(array(
                    'nombre'    => $nombre,
                    'valor'     => $valor
                ));
        } else {
            //echo ("error");
        }
    }
     
    break;  

        case 'update': 
            $geoserver      = $_POST['geoserver'];
            $geoserver_user = $_POST['geoserver_user'];   
            $geoserver_pass = $_POST['geoserver_pass'];   
            $wms            = $_POST['wms'];   
            $id = $_GET['id'];         
            $sql = "update configuraciones set  geoserver=?, geoserver_user=?, geoserver_pass=?, wms = ?   where id =? ";    
            $update = $db->query($sql, $geoserver, $geoserver_user, $geoserver_pass, $wms ,$id );
              echo json_encode(array(
                    'id'             =>  $id,
                    'geoserver'      => $geoserver,
                    'geoserver_user' => $geoserver_user,
                    'geoserver_pass' => $geoserver_pass,
                    'wms'            => $wms 
                ));
 
        break;

        case 'delete': 
    
            $id = $_REQUEST['id'];         
            $sql = "delete FROM configuraciones  where id =? ";    
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





