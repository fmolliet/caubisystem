<?php
include "../control/Control.php";

echo '<br /><br />';

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
                // caso precise converter
                //$_GET['lat'] = str_replace('.',',',$_GET['lat']);
                //$_GET['lon'] = str_replace('.',',',$_GET['lon']);
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