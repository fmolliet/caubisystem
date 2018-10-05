<?php
    //require_once('class/server.php');
    include dirname(dirname(__FILE__))."/rest/control/Control.php";
    
    ini_set('display_errors', 1);
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    ini_set('max_execution_time','0');
    ignore_user_abort(true);
    
  

    if(!empty($_GET['logout']) && $_GET['logout']== 'true')
    {
        unset($_COOKIE);
        unset($login_cookie);
    }
    $login_cookie = $_COOKIE['login'];

    if(!empty($_POST))
    {
        
        $Control = new control();
        switch($_POST['cmd'])
        {
            
            case 'insert':
                //var_dump($_POST);
                $Control->siteClient_reg($_POST);
                break;
        }
    }
      ?> 
      <html>
          <head>
            <title>Clients Manager</title>
            <link rel="stylesheet" type="text/css" href="css/forms.css">
            <link rel="stylesheet" type="text/css" href="css/style.css">
            <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Montserrat">
            <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Roboto">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <script src="js/emptycheck.js"></script>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <!--<script src="js/jquery.menu.js"></script>-->
          </head>
          <body background="img/bg.jpg" styles="filter:blur(5px);">
            
                <ul>
                    <li><spam>Bem-Vindo, <?=ucfirst($login_cookie)?></spam></li>
                    <li><a href="index.php?cmd=cadastro">Cadastrar Cliente</a></li>
                    <li><a href="index.php?cmd=search">Buscar Cliente</a></li>
                    <li><a href="index.php?cmd=list">Ver Clientes</a></li>
                    <li><a href="index.php?cmd=admin">Administração</a></li>
                    <li style="float:right"><a class="sair" href="index.php?logout=true" >Sair</a></li>
                </ul>
                <br /><br />

                <div class="menu" styles="filter:opacity(50%);">
                    <?php
                if(isset($login_cookie)){
                    if(isset($_GET['cmd']))
                    {
                        switch($_GET['cmd']){
                            case 'cadastro':
                                include('form/cadastro.php');
                                break;
                            case 'list':
                                include('form/list.php');
                                break;
                            case 'search':
                                include('form/search.php');
                                break;
                            case 'admin':
                                include('form/admin.php');
                                break;
                        }
                    }
                    ?>
                </div>
          </body>
      </html>
    
<?php
    }
    else
        header("Location:login.html");
?>


<!--
    <p>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </p> 

                <script language='javascript' type='text/javascript'>
                        alert('Usuário cadastrado');
                    </script>