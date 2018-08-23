<?php 
ini_set('display_errors', 1);
include dirname(dirname(__FILE__))."/rest/control/Control.php";


$login = $_POST['login'];
$entrar = $_POST['entrar'];
$senha = $_POST['senha'];
$senha = md5($senha);

if (isset($entrar)) {      
  $Control = new control();
    if (empty($Control->siteLogin($login, $senha))){
    ?>
      <script language='javascript' type='text/javascript'>
        alert('Login e/ou senha inválidos');
        window.location.href='login.html';
      </script>
      <?php
      die();
    }
    else{
      setcookie("login",$login);
      header("Location:index.php");
    }
}
?>
<!--
<html>
<head>
    <title>Server Manager</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
<body>
  <?php

var_dump();
  ?>
</body>
</html>