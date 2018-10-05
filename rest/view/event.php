<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time','0');
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
ignore_user_abort(true);
error_reporting(E_ALL);

header('Content-Type: text/html');

include "../control/Control.php";

//echo '<br /><br />';
//echo $_GET['appkey'];
//print_r(" é a chave de aplicação");

//echo $_GET['type'];

if(isset($_GET['appkey']) && isset($_GET['type']))
{
    $Control = new control();
    if(!empty($Control->validate($_GET['appkey'])) ||  !empty(preg_match('(normal|critic|geo)', $_GET['type'])) )
    {
        switch($_GET['type']){
            case 'normal' :
                $Control->normal($_GET);
            break;
            case 'critic':
                $Control->critic($_GET);
            break;
            case 'geo':
                $result = $Control->checkgeo($_GET['appkey']);
                if(empty($result))
                    $Control->creategeo($_GET);
                else
                {
                    if(!$Control->compareGeo($_GET, $result))
                       $Control->markGeo($_GET['appkey']);
                }
                
            break;
        }
    }
    else
    {
        include('404.php');
        echo '<h2><b>Appkey ou tipo de solicitação Inválida</b></h2>';
        die();
    }    
}
else
{
    include('404.php');
    echo '<h2><b>Está faltando chave de aplicação ou tipo de solicitação</b></h2>';
    die();
}
?>