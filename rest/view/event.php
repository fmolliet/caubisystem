<?php
//http://serverconfig.hopto.org/rest/event.php?appkey=%s&type=%s&dtemp=%f&hum=%f&geo=%s&stemp=%f
include "../control/Control.php";

echo '<br /><br />';

if(isset($_GET['appkey']) && isset($_GET['type']))
{
    $Control = new control();
    if(!empty($Control->validate($_GET['appkey'])))
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
        echo '<h2><b>AppKey Invalida</b></h2>';
    //header('Location:listar.php');
}
else
    echo '<h2><b>Está faltando chave de aplicação ou tipo de solicitação</b></h2>';

?>