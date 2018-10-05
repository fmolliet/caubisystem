<?php 
ini_set('display_errors', 1);
ini_set('max_execution_time','0');
include dirname(dirname(__FILE__))."/rest/control/Control.php";

define('AUTHKEY', '77A83BBD95D7D68272A804BA2C67C5130AE9737CB04EDC832C4B9FCB2E1DBA43');

header('HTTP/1.1 500 Internal Server Booboo');
header('Content-Type: application/json;charset=utf-8');
header('Accept: application/json');


//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('A requisicao precisa ser um POST!');
}
 
//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('O Content_type precisa ser: application/json');
}

//Receive the RAW post data.
$data = file_get_contents("php://input");

$obj =  json_decode($data,true);

//If json_decode failed, the JSON is invalid.
if(!is_array($obj)){
    throw new Exception('Recebido conteudo invalido de JSON!');
}

if($obj['Authkey']== AUTHKEY){	
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

        /////////////////////////////////
        /////  Queries Search's By  /////
        /////////////////////////////////

        if($obj["type"] =="SearchByAppKey"){
            $Control = new control();
            die(json_encode($Control->apiSearchById($obj)));
        }

        if($obj["type"] =="bringMachinesByAppKey"){
            $Control = new control();
            die(json_encode($Control->apiMachinesByAppKey($obj)));
        }

        if($obj["type"] =="bringClients"){
            $Control = new control();
            die(json_encode($Control->apiBringAllClients()));
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