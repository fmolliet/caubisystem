<?php
include "../control/Control.php";

function getToObj($array)
{
    $arr = [];
    foreach($array as $k)
    {
        $arr[] = $k;
    }
    return $arr;
}
echo '<br /><br />';


if(isset($_GET['appkey']) && isset($_GET['type']))
{
    $conteudoControl = new ConteudoControl();
    if(!empty($conteudoControl->validate($_GET['appkey'])))
    {
        switch($_GET['type']){
            case 'normal' :
                $conteudoControl->normal($_GET);
            break;
            case 'geo':
                $conteudoControl->critic($_GET);
            break;
        }
    }
    else
        echo '<h2><b>AppKey Invalida</b></h2>';
}
else
    echo '<h2><b>Está faltando chave de aplicação ou tipo de solicitação</b></h2>';
?>
