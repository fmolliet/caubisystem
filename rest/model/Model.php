<?php
include '../conexao/Conexao.php';

class content extends Conexao{
    
    public function nevent($obj){
    	$sql = "INSERT INTO events( appkey, dtemp, humidity, stemp) VALUES (:appkey,:dtemp,:hum,:stemp)";
    	$consulta = Conexao::prepare($sql);
        $consulta->bindValue('appkey',  $obj['appkey']);
        $consulta->bindValue('dtemp', $obj['dtemp']);
        $consulta->bindValue('hum' , $obj['hum']);
        $consulta->bindValue('stemp' , $obj['stemp']);
    	return $consulta->execute();

	}


	public function appkey($appkey){
		$sql = "SELECT * FROM clients WHERE appkey = :appkey ";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('appkey', $appkey);
		$consulta->execute();
		return $consulta->fetchAll();
	}

    
}
?>