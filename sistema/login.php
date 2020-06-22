<?php

session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/sistema/config.php");
$_SESSION['adminUser'] = array();

?><!DOCTYPE html>
<html lang="pt">
	<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/dist/css/index.min.css">
    <link rel="stylesheet" href="/dist/css/sistema.min.css">

    <script type="text/javascript" src="/dist/js/viacep_search.js"></script>

    <script language="javascript" type="text/javascript">

        function fechaMensagens(div)
        {
            document.getElementById(div).style.display = 'none';
        }

        function abreMensagens(div){
            document.getElementById(div).style.display = 'block';
        }

    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>


    <div id="login-content">

        <?php

            if(!empty($error))
            {
                echo '<div class="login-error">
                        <div class="login-error-close">X</div>';
                echo implode('<br>',$error);
                echo '</div>';

            }


        ?>

            <div id="login-card">


                <div id="face2">

                    <div style="clear:both"></div>

                    <div id="login-form">

                        <form name="loginform" action="/sistema/" method="POST" >

                            <?php

                                require_once('recaptchalib.php');
                                $publickey = $recaptcha_public_key;

                            ?>
                            <input type="text" name="usuario" placeholder="login" class="login-form-input" value="usuario">
                            <input type="password" name="senha" placeholder="******"  class="login-form-input" value="senha">

                            <!-- <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_public_key; ?>" ></div> -->

                            <input type="submit"  name="access" id="access" class="botao1" value="acessar" style="width: 100%; margin: 20px 0; padding: 10px;"/>
                        </form>

                    </div>

                </div>

            </div>


    </div>


</html>
