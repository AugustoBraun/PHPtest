<?php

    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."/sistema/config.php");


    if((isset($_POST["usuario"]))&&(isset($_POST["senha"])))
    {

        $query = "select * from login where login='".strip_tags($_POST['usuario'])."' and senha='".md5($_POST['senha'])."'";
        //optei por um sistema simples de criptografia para agilizar a producao, mas em abiente normal usaria password_hash e verify

        $sql = $db->query($query);

        if($sql->num_rows == 0)
            header('Location: /sistema/login.php?erro=2');

        $log = $sql->fetch_assoc();

       $_SESSION['adminUser']['userid'] = $log['id_login'];
       $_SESSION['adminUser']['usernome'] = $log['nome'];
       $_SESSION['adminUser']['userlogin'] = $log['login'];
       $_SESSION['adminUser']['userpass'] = $log['senha'];
       $_SESSION['adminUser']['useremail'] = $log['email'];
       $_SESSION['adminUser']['usrnivel'] = $log['nivel'];


    }else{

        if($_SESSION['adminUser']['userid'] > 0){

            $query = "select * from login where login='".$_SESSION['adminUser']['userlogin']."' and senha = '".$_SESSION['adminUser']['userpass']."'";

            $sql = $db->query($query);

            if($sql->num_rows == 0)
                header('Location: /sistema/login.php?erro=2');

            $log = $sql->fetch_assoc();

        }else{

            header("Location: /sistema/login.php?erro=2");

        }
    }

?>