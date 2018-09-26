<?php 
ini_set('display_errors', 1);
ini_set('max_execution_time','0');
include dirname(dirname(__FILE__))."/rest/control/Control.php";

//header('Content-Type: application/json');

$data = file_get_contents('php://input');

$obj =  json_decode($data,true);

if(!empty($_POST)){	
    header('HTTP/1.1 500 Internal Server Booboo');
    header('Content-Type: application/json; charset=UTF-8');
        /////////////////////////////
        /////       LOGIN       /////
        /////////////////////////////

        if($obj['type'] == "login"){
            $senha = $obj["pwd"];
            $senha = md5($senha);    
            $Control = new control();
            if (empty($Control->siteLogin($obj["user"], $senha)))
            {
                die(json_encode(array('message' => 'login', 'value' => 'false')));
            }
            else{
                die( json_encode(array('message' => 'login', 'value' => 'true'))); 
            }
        } 

        /////////////////////////////
        /////   SearchByAppId   /////
        /////////////////////////////

        if($obj["type"] =="SearchByAppKey"){
            $Control = new control();
            die(json_encode($Control->apiSearchById($obj)));
        }
            

        /////////////////////////////
        /////     ERRO 404      /////
        /////////////////////////////        

        if($obj["type"]== ""){
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
            //include(dirname(dirname(__FILE__)).'/rest/view/404.php');
            
            //return print_r("ERRO");
}  
else{
    header('Content-Type: text/html; charset=utf-8');
    include(dirname(dirname(__FILE__)).'/rest/view/404.php');
    echo '<h2><b>Nada está sendo enviado!</b></h2>';
    die();
}




?>