<?php
include dirname(dirname(__FILE__)) .'/conexao/Conexao.php';

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

	public function cevent($obj){
    	$sql = "INSERT INTO events( appkey, `status`, lon, lat) VALUES (:appkey, :e_status,:lon,:lat)";
    	$consulta = Conexao::prepare($sql);
        $consulta->bindValue('appkey',  $obj['appkey']);
        $consulta->bindValue('e_status', $obj['dtemp']);
		$consulta->bindValue('lon' , $obj['lon']);
		$consulta->bindValue('lat' , $obj['lat']);
    	return $consulta->execute();
	}

	public function appkey($appkey){
		$sql = "SELECT * FROM clients WHERE appkey = :appkey ";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('appkey', $appkey);
		$consulta->execute();
		return $consulta->fetchAll();
	}

    public function tempSchedule(){
		$sql = "SELECT * FROM events WHERE alert = 1";
		$consulta = Conexao::prepare($sql);
		$consulta->execute();
		return $consulta->fetchAll();
	}

	public function checkgeo($appkey){
		$sql = "SELECT * FROM locations WHERE appkey = :appkey ";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('appkey', $appkey);
		$consulta->execute();
		return $consulta->fetchAll();
	}

	public function markgeo($appkey){
		$sql = "UPDATE locations SET alert = 1 WHERE appkey = :appkey ";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('appkey', $appkey);
		return $consulta->execute();
	}

	public function insertgeo($obj){
    	$sql = "INSERT INTO events( appkey, `status`, lon, lat) VALUES (:appkey, :e_status,:lon,:lat)";
    	$consulta = Conexao::prepare($sql);
        $consulta->bindValue('appkey',  $obj['appkey']);
        $consulta->bindValue('e_status', $obj['dtemp']);
		$consulta->bindValue('lon' , $obj['lon']);
		$consulta->bindValue('lat' , $obj['lat']);
    	return $consulta->execute();
	}
}
?>