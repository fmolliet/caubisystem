<?php
include dirname(dirname(__FILE__)) .'/model/Model.php';

class control{
	function normal($obj){
		$conteudo = new content();
		return $conteudo->nevent($obj);
	}

	function validate($appkey)
	{
		$conteudo = new content();
		return $conteudo->appkey($appkey);
	}

	function checkTemperature()
	{
		$conteudo = new content();
		return $conteudo->tempSchedule();
	}

	function critic($obj)
	{
		$conteudo = new content();
		return $conteudo->cevent($obj);
	}

	function creategeo($obj)
	{
		$conteudo = new content();
		return $conteudo->insertgeo($obj);
	}

	function checkgeo($appkey)
	{
		$conteudo = new content();
		return $conteudo->selectgeo($appkey);
	}

	function getToObj($array)
	{
		$arr = [];
		foreach($array as $k)
		{
			$arr[] = $k;
		}
		return $arr;
	}

	function compareGeo($new, $old)
	{
		if($new['lat'] >= $old['lat']-0.001188   && $new['lat'] <= $old['lat']+0.001188   )
        {
            if($new['lon'] >= $old['lon']-0.001188   && $new['lon'] <= $old['lon']+0.001188   )
            {
                   return true;         
            }
		}
		return false;
	}

	function markGeo($appkey)
	{
		$conteudo = new content();
		return $conteudo->markgeo($appkey);
	}


	//////////////////////////
	////  SITE Functions  //// 
	//////////////////////////


	function siteLogin($login, $senha){
		$conteudo = new content();
		return $conteudo->login($login, $senha);
	}

	function siteClient_reg($client_data)
	{
		$conteudo = new content();
		return $conteudo->insert_client($client_data);
	}

	function siteClient_show_all(){
		$conteudo = new content();
		return $conteudo->bring_all_client();
	}


	//////////////////////////
	/////  API Returns  //////
	//////////////////////////

	
	function apiValidate($obj){
		$conteudo = new content();
		return $conteudo->apiValidate($obj);
	}

	function apiSearchById($obj){
		$conteudo = new content();
		return $conteudo->apiSearchByAppKey($obj);
	}




}
?>