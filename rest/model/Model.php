<?php
include dirname(dirname(__FILE__)) .'/conexao/Conexao.php';
//include dirname(dirname(__FILE__)) .'/class/toolkit.php';

class content extends Conexao{
    
    public function nevent($obj){
    	$sql = "INSERT INTO events( appkey, machine_id ,dtemp, humidity, stemp, energy) VALUES (:appkey,:mac,:dtemp,:hum,:stemp,:energy)";
    	$consulta = Conexao::prepare($sql);
		$consulta->bindValue('appkey',  $obj['appkey']);
		$consulta->bindValue('mac',  $obj['mac_id']);
        $consulta->bindValue('dtemp', $obj['dtemp']);
        $consulta->bindValue('hum' , $obj['hum']);
		$consulta->bindValue('stemp' , $obj['stemp']);
		$consulta->bindValue('energy' , $obj['eng']);
    	return $consulta->execute();
	}

	public function cevent($obj){
    	$sql = "INSERT INTO critical_events( machine_id, appkey, msg, status) VALUES (:mac, :appkey, :msg, 1)";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('mac',  $obj['mac_id']);
        $consulta->bindValue('appkey',  $obj['appkey']);
        $consulta->bindValue('msg', $obj['msg']);
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
    	$sql = "INSERT INTO locations (machine_id, appkey, lon, lat) VALUES (:mac,:appkey, :lon,:lat)";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('mac',  $obj['mac_id']);
        $consulta->bindValue('appkey',  $obj['appkey']);
		$consulta->bindValue('lon' , $obj['lon']);
		$consulta->bindValue('lat' , $obj['lat']);
    	return $consulta->execute();
	}


	public function login($login, $senha){
		$sql = "SELECT * FROM users WHERE username = :user AND pwd = :pwd ;";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('user',  $login);
		$consulta->bindValue('pwd',  $senha);
		$consulta->execute();
		return $consulta->fetchAll();
	}

	public function insert_client($data){
    	$sql = "INSERT INTO `client_detail` (cnpj, first_name, last_name, email, business, address, city, state, country) VALUES (:cpf, :fname, :sname, :email, :business, :endereco, :city, :estado, :pais)";
		$consulta = Conexao::prepare($sql);
        $consulta->bindValue('cpf',  $data['cpf']);
        $consulta->bindValue('fname', $data['fname']);
		$consulta->bindValue('sname' , $data['sname']);
		$consulta->bindValue('email' , $data['email']);
		$consulta->bindValue('business' , $data['business']);
		$consulta->bindValue('endereco' , $data['end']." ".$data['complement']);
		$consulta->bindValue('city' , $data['city']);
		$consulta->bindValue('estado' , $data['state']);
		$consulta->bindValue('pais' , $data['country']);
    	return $consulta->execute();
	}

	public function bring_all_client(){
		$sql = "SELECT p.client_id, c.appkey, p.cnpj, p.first_name, p.last_name, p.email, p.business, p.address 
			FROM client_detail as p 
			LEFT JOIN clients AS c 
			ON p.client_id = c.id";
		$consulta = Conexao::prepare($sql);
		$consulta->execute();
		return $consulta->fetchAll();
	}

	public function apiMachinesByAppKey($data){
		$sql = "SELECT * FROM machines WHERE client_appkey = :apk";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('apk',  $data['appkey']);
		$consulta->execute();
		return $consulta->fetchAll();
	}

	public function apiSearchById($data){
		$sql = "SELECT * FROM clients WHERE appkey = :appkey";
		$consulta = Conexao::prepare($sql);
		$consulta->bindValue('appkey',  $data['appkey']);
		$consulta->execute();
		return $consulta->fetchAll();
	}

	public function apiBringAllClients(){
		$sql = "SELECT p.client_id, c.appkey, p.cnpj, p.email, p.business, p.address 
			FROM client_detail as p 
			LEFT JOIN clients AS c 
			ON p.client_id = c.client_id";
		$consulta = Conexao::prepare($sql);
		$consulta->execute();
		return $consulta->fetchAll();
	}

	/*
	public function apiBringAllClients(){
		$sql = "SELECT p.client_id, c.appkey, p.cnpj, p.email, p.business, p.address 
			FROM client_detail as p 
			LEFT JOIN clients AS c 
			ON p.client_id = c.client_id";
		$consulta = Conexao::prepare($sql);
		$consulta->execute();
		return $consulta->fetchAll();
	}
	*/
}
?>