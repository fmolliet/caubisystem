<?php 
ini_set('display_errors', 1);
include dirname(dirname(__FILE__))."/rest/control/Control.php";

header('Content-Type: application/json');

//$data = file_get_contents('php://input');


//return var_dump($_POST);
//$obj =  json_decode($data);
//return var_dump($data);
return var_dump(json_encode($_POST));
//$uid = $obj->uid;

if(!empty($_POST)){	
    
}
?>