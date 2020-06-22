<?php

	session_start();

	require_once($_SERVER["DOCUMENT_ROOT"]."/sistema/config.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/sistema/auth.php");


// ===================  sistemas ==============================================================================


    function urlAmigavel($url = null){

        if(!$url){ $url =  $_SERVER['REQUEST_URI']; }
        $url = explode('/', parse_url($url, PHP_URL_PATH));
        $caminho = array();		//importante setar pois preciso mesmo vazio

        foreach($url as $path){
            if($path != '') {
                $caminho[] = $path;
            }
        }

        // organizo os caminhos do sistema
        if(isset($caminho[1])){
            $sistema['controlador'] = $caminho[1];
        }else{
            $sistema['controlador'] = 'buscacep';
        }
        if(isset($caminho[2])){
            $sistema['acao'] = 'admin_'.$caminho[2];
        }else{
            $sistema['acao'] = 'admin_listacep';
        }
        for($i=3, $o=0; $i<count($caminho); $i++, $o++){
            $sistema['params'][$o] = $caminho[$i];
        }
        return($sistema);
    }

    $sistema = urlAmigavel();



    //funcoes essenciais ao sistema
    function lerTemplate($opcao1= null, $opcao2=null)
    {
        global $sistema;

        if(empty($opcao1))
            $opcao1 = $sistema['controlador'];
        if(empty($opcao2))
            $opcao2 = $sistema['acao'];

        $opcao2 = str_replace('admin_', '', $opcao2);
        $ferramenta = ADMINROOT.'/'.$opcao1.'/'.$opcao2.'.php';
        return($ferramenta);
    }
			
//================================================
		
				
    //carrego o controlador mestre e modelo mestre
    include_once($_SERVER["DOCUMENT_ROOT"].'/sistema/_modelo_mestre.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/sistema/_controlador_mestre.php');

		
//================================================

    require_once($rootdir.'sistema/'.$sistema['controlador'].'/controlador.php');

    if(!method_exists($sistema['controlador'], $sistema['acao']))
    {
        echo 'Error controller / action';
    }else{
        $controlador = $sistema['controlador'];
        $dados_template = new $controlador;
    }


    //define o conteudo atraves dos comandos do controlador
    $conteudo = $dados_template->{$sistema['acao']}($sistema['params'], $_GET, $_POST, $_FILES);


    //lança pro ambiente as variaveis da classe controlador
    $vars = get_class_vars(get_class($dados_template));
     foreach($vars as $nome => $valor){
         $$nome = $valor;
     }
     foreach($dados_template->variaveis as $nome => $valor){
         $$nome = $valor;
     }




//====== mensagens ==========================================
			 

    function mostraAviso($msg, $nomediv='msg_sucesso'){
            return '<div class="'.$nomediv.'" style="display:none; position: relative; top: 20px; margin-bottom: 30px;">'.$msg.'<a class="close" href="javascript:fechaMensagens(\''.$nomediv.'\')"></a></div>';
    }


    if($_GET['carrega_template'] == 'nao')
        exit;

?><!DOCTYPE html>
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

</head>
<body id="body" class="sistema-ui"
    <?php

        if($_SESSION['adminUser']['msg_alert']){

            echo 'onload="javascript:alert(\''.$_SESSION['adminUser']['msg_alert'].'\');" ';
            $_SESSION['adminUser']['msg_alert'] = null;
        }
    ?>
    >

    <div id="box_usuario">
        <div style="max-width:1000px; width: 100%; margin: 0 auto; text-align: center;">
            <div id="box_usuario_txt">
                <div class="box_foto" <?php
                    if(is_file(ROOTDIR.'uploads/img/usuario/'.$_SESSION['userid'].'.jpg')){
                        echo ' style="background-image: url(\'/uploads/img/usuario/'.$_SESSION['adminUser']['userid'].'.jpg\'); background-repeat: no-repeat;"';
                    }
                ?>>
                </div>
                <div class="box_usario_nome">
                    <?php echo $_SESSION['adminUser']['usernome']; ?>
                </div>
                <table border=0 cellpadding=2 cellspacing=5">
                    <tr>
                        <td>
                            <div class="box_usuario_detalhes">
                                <a href="<?php echo ADMINURL; ?>/login.php" style="color: #ffffff;">
                                    <img src="/dist/img/_sair.png" border=0 align=absmiddle>
                                    sair
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div id="Content">


        <div id="admin-menu">

            
        </div>

        <div id="admin-interface">

            <div class="sistema_conteudos"  >
                <?php


                    if($controlador_icone == ''){$controlador_icone = 'info';}
                    if($acao_icone == ''){$acao_icone = 'configuracoes';}

                    echo '<div class="titulo_controlador_acao">

                                <table  width=100% cellpadding=0 cellspacing=0>
                                    <tr>
                                        <td bgcolor=#cccccc nowrap >
                                            <span class="titulo_controlador">
                                                <img src="/dist/img/ico/24/'.$controlador_icone.'.png" border=0 style="position:relative; top:0px;"> '.$controlador_nome.'
                                            </span>
                                        </td>
                                        <td bgcolor=#cccccc width=0%>
                                            <img src="/dist/img/titulo_sep.png" height=100%  align=right>
                                        </td>
                                        <td bgcolor=#E6E6E6 nowrap >
                                            <span class="titulo_acao">
                                                <img src="/dist/img/ico/24/'.$acao_icone.'.png" border=0 style="position:relative; top:4px;"> '.$conteudo['acao_nome'].'
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>';



                    if($_SESSION['config_avisos_vis']==2 || $_SESSION['adminUser']['config_dicas_vis'] == 2)
                    {
                            if($_SESSION['msg_erro']){echo '<div class="msg_erro">'.$_SESSION['msg_erro'].'<a class="close" href="javascript:fechaMensagens(\'msg_erro\')"></a> </div>';}
                            if($_SESSION['msg_sucesso']){echo '<div class="msg_sucesso">'.$_SESSION['msg_sucesso'].'<a class="close" href="javascript:fechaMensagens(\'msg_sucesso\')"></a> </div>';}
                            if($_SESSION['msg_aviso']){echo '<div class="msg_aviso">'.$_SESSION['msg_aviso'].'<a class="close" href="javascript:fechaMensagens(\'msg_aviso\')"></a></div>';}

                    }elseif($_SESSION['config_avisos_vis']==3 || $_SESSION['adminUser']['config_dicas_vis'] == 3){

                            if( ($_SESSION['msg_erro']) || ($_SESSION['msg_sucesso']) || ($_SESSION['msg_aviso']) )
                            {
                                echo '<div class="avisos">';
                                if($_SESSION['msg_erro']){		echo '<a href="javascript://" onClick="abreMensagens(\'msg_erro\');" class="tooltip" style="text-decoration: none;"><img src="/sistema/img/ico/erro.png"><span>'.$_SESSION['msg_erro'].'</span></a>';}
                                if($_SESSION['msg_sucesso']){echo '<a href="javascript://" onClick="abreMensagens(\'msg_sucesso\');" class="tooltip" " style="text-decoration: none;"><img src="/sistema/img/ico/sucesso.png"><span>'.$_SESSION['msg_sucesso'].'</span></a>';}
                                if($_SESSION['msg_aviso']){	echo '<a href="javascript://" onClick="abreMensagens(\'msg_aviso\');" class="tooltip" style="text-decoration: none;"><img src="/sistema/img/ico/aviso.png"><span>'.$_SESSION['msg_aviso'].'</span></a>';}
                                if($_SESSION['config_dicas_vis']==2){
                                    if($_SESSION['msg_dica']){	echo '<a href="javascript://" onClick="abreMensagens(\'msg_dica\');" class="tooltip" style="text-decoration: none;"><img src="/sistema/img/ico/dica.png"><span>'.$_SESSION['msg_dica'].'</span></a>';}
                                }
                                echo '</div>';
                                if($_SESSION['msg_erro']){echo mostraAviso($_SESSION['msg_erro'],'msg_erro');}
                                if($_SESSION['msg_sucesso']){echo mostraAviso($_SESSION['msg_sucesso'],'msg_sucesso');}
                                if($_SESSION['msg_aviso']){echo mostraAviso($_SESSION['msg_aviso'],'msg_aviso');}
                                if($_SESSION['config_dicas_vis']==2){
                                    if($_SESSION['msg_dica']){echo mostraAviso($_SESSION['msg_dica'],'msg_dica');}
                                }
                            }
                    }


                    if($_SESSION['config_dicas_vis']==1 || $_SESSION['adminUser']['config_dicas_vis'] == 1){

                        if($_SESSION['msg_dica']){echo '<div class="msg_dica">'.$_SESSION['msg_dica'].'<a class="close" href="javascript:fechaMensagens(\'msg_dica\')"></a></div>';}
                    }
                    if( ($_SESSION['config_dicas_vis']==2) && ($_SESSION['config_avisos_vis'] != 3) ){
                        if($_SESSION['msg_dica']){
                            echo '<div class="avisos">
                                    <a href="javascript://" onClick="abreMensagens(\'msg_dica\');" class="tooltip" style="text-decoration: none;"><img src="/sistema/img/ico/dica.png"><span>'.$_SESSION['msg_dica'].'</span></a>
                                    </div>';
                            echo mostraAviso($_SESSION['msg_dica'],'msg_dica');
                        }
                    }





                    //caso seja enviado algum conteudo fora de template, carrega
                    if($conteudo['miolo']){echo $conteudo['miolo'];}


                    // caso o controlador solicite um template, carrega.
                    if(is_array($conteudo['template'])){
                        include_once(lerTemplate($conteudo['template'][0],$conteudo['template'][1]));
                    }

                    //apos o uso removo as mensagens da sessao;
                    $dados_template->removeMensagensNaSessao();





            ?>
            </div>

        </div>

    </div>

</body>
</html>
