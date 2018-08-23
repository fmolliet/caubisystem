<?php
    include dirname(dirname(__FILE__))."/rest/control/Control.php";
    // Alert Checker
    $Control = new control();
    $result = $Control->checkTemperature();
    if(!empty($result)){
        // gera um alerta para dashboard
        foreach($result as $x)
        {
            // faz algo
            print_r($x['appkey']);
            echo " deu alerta de alteração de temperatura no dia";
            print_r($x['datetime']);
        }
    }
    // Trigger Warning

?>