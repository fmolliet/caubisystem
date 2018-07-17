<?php
include '../model/Model.php';

class ConteudoControl{
	function normal($obj){
		$conteudo = new content();
		//echo $obj->titulo;
		return $conteudo->nevent($obj);
		header('Location:index.php');
	}

	function validate($appkey)
	{
		$conteudo = new content();
		//echo $obj->titulo;
		return $conteudo->appkey($appkey);
	}
}
?>