<?php

session_start();

if(!class_exists('controlador_mestre')) {

    class controlador_mestre extends modelo_mestre
    {


// ====== funcoes vitais ========================================================================================================


        var $variaveis = array();


        function set($string, $valor = null)
        {
            $dados = array();

            if (is_array($string)) {
                if (is_array($valor)) {
                    $dados = array_combine($string, $valor);
                } else {
                    $dados = $string;
                }
            } else {
                $dados = array($string => $valor);
            }
            $this->variaveis = $dados + $this->variaveis;
        }


// ====== mensagens  ========================================================================================================


        function mensagensNaSessao($conteudo)
        {
            if ($conteudo['msg_erro']) {
                $_SESSION['msg_erro'] = $conteudo['msg_erro'];
            }
            if ($conteudo['msg_sucesso']) {
                $_SESSION['msg_sucesso'] = $conteudo['msg_sucesso'];
            }
            if ($conteudo['msg_saida']) {
                $_SESSION['msg_saida'] = $conteudo['msg_saida'];
            }
            if ($conteudo['msg_entrada']) {
                $_SESSION['msg_entrada'] = $conteudo['msg_entrada'];
            }
            if ($conteudo['msg_alert']) {
                $_SESSION['msg_alert'] = $conteudo['msg_alert'];
            }
            if ($conteudo['msg_aviso']) {
                $_SESSION['msg_aviso'] = $conteudo['msg_aviso'];
            }
            if ($conteudo['msg_dica']) {
                $_SESSION['msg_dica'] = $conteudo['msg_dica'];
            }
            if ($conteudo['template']) {
                $_SESSION['template'] = $conteudo['template'];
            }
            if ($conteudo['redireciona']) {
                $_SESSION['redireciona'] = $conteudo['redireciona'];
            }
        }


// -------------------------------------------------------------------------------------------------------------------


        function removeMensagensNaSessao()
        {
            unset($_SESSION['msg_erro']);
            unset($_SESSION['msg_sucesso']);
            unset($_SESSION['msg_saida']);
            unset($_SESSION['msg_entrada']);
            unset($_SESSION['msg_alert']);
            unset($_SESSION['msg_aviso']);
            unset($_SESSION['msg_dica']);
            unset($_SESSION['msg_tipo']);
            unset($_SESSION['template']);
            unset($_SESSION['redireciona']);
        }


// -------------------------------------------------------------------------------------------------------------------


        function mostraAviso($msg, $nomediv = 'msg_sucesso')
        {
            return '<div class="' . $nomediv . '" style="display:none; position: relative; top: 20px; margin-bottom: 30px;">' . $msg . '<a class="close" href="javascript:fechaMensagens(\'' . $nomediv . '\')"></a></div>';
        }


// -------------------------------------------------------------------------------------------------------------------


        function mostraMensagem($conteudo = null, $tipo = 1)
        {

            global $_SESSION;

            $_SESSION['msg_tipo'] = $tipo;

            $this->mensagensNaSessao($conteudo);
            if (is_array($_SESSION['msg_erro'])) {
                $_SESSION['msg_erro'] = implode('<br>', $_SESSION['msg_erro']);
            }
            if (is_array($_SESSION['msg_sucesso'])) {
                $_SESSION['msg_sucesso'] = implode('<br>', $_SESSION['msg_sucesso']);
            }
            if (is_array($_SESSION['msg_saida'])) {
                $_SESSION['msg_saida'] = implode('<br>', $_SESSION['msg_saida']);
            }
            if (is_array($_SESSION['msg_entrada'])) {
                $_SESSION['msg_entrada'] = implode('<br>', $_SESSION['msg_entrada']);
            }
            if (is_array($_SESSION['msg_alert'])) {
                $_SESSION['msg_alert'] = implode('<br>', $_SESSION['msg_alert']);
            }
            if (is_array($_SESSION['msg_aviso'])) {
                $_SESSION['msg_aviso'] = implode('<br>', $_SESSION['msg_aviso']);
            }
            if (is_array($_SESSION['msg_dica'])) {
                $_SESSION['msg_dica'] = implode('<br>', $_SESSION['msg_dica']);
            }

            if ($tipo == 1) {
                if ($_SESSION['msg_erro']) {
                    $msg .= '<div class="msg_erro">' . $_SESSION['msg_erro'] . '<a class="close" href="javascript:fechaMensagens(\'msg_erro\')"></a> </div>';
                }
                if ($_SESSION['msg_sucesso']) {
                    $msg .= '<div class="msg_sucesso">' . $_SESSION['msg_sucesso'] . '<a class="close" href="javascript:fechaMensagens(\'msg_sucesso\')"></a> </div>';
                }
                if ($_SESSION['msg_saida']) {
                    $msg .= '<div class="msg_saida">' . $_SESSION['msg_saida'] . '<a class="close" href="javascript:fechaMensagens(\'msg_saidao\')"></a> </div>';
                }
                if ($_SESSION['msg_entrada']) {
                    $msg .= '<div class="msg_entrada">' . $_SESSION['msg_entrada'] . '<a class="close" href="javascript:fechaMensagens(\'msg_entrada\')"></a> </div>';
                }
                if ($_SESSION['msg_aviso']) {
                    $msg .= '<div class="msg_aviso">' . $_SESSION['msg_aviso'] . '<a class="close" href="javascript:fechaMensagens(\'msg_aviso\')"></a></div>';
                }
            } elseif ($tipo == 2) {
                echo '<div class="avisos">';
                if ($_SESSION['msg_erro']) {
                    $msg .= '<a href="javascript://" onClick="abreMensagens(\'msg_erro\');" class="tooltip" style="text-decoration: none;"><img src="/sistema/img/ico/erro.png"><span>' . $_SESSION['msg_erro'] . '</span></a>';
                }
                if ($_SESSION['msg_sucesso']) {
                    $msg .= '<a href="javascript://" onClick="abreMensagens(\'msg_sucesso\');" class="tooltip" " style="text-decoration: none;"><img src="/sistema/img/ico/sucesso.png"><span>' . $_SESSION['msg_sucesso'] . '</span></a>';
                }
                if ($_SESSION['msg_saida']) {
                    $msg .= '<a href="javascript://" onClick="abreMensagens(\'msg_saida\');" class="tooltip" " style="text-decoration: none;"><img src="/sistema/img/ico/saida.png"><span>' . $_SESSION['msg_saida'] . '</span></a>';
                }
                if ($_SESSION['msg_entrada']) {
                    $msg .= '<a href="javascript://" onClick="abreMensagens(\'msg_entrada\');" class="tooltip" " style="text-decoration: none;"><img src="/sistema/img/ico/entrada.png"><span>' . $_SESSION['msg_entrada'] . '</span></a>';
                }
                if ($_SESSION['msg_aviso']) {
                    $msg .= '<a href="javascript://" onClick="abreMensagens(\'msg_aviso\');" class="tooltip" style="text-decoration: none;"><img src="/sistema/img/ico/aviso.png"><span>' . $_SESSION['msg_aviso'] . '</span></a>';
                }
                echo '</div>';
            } else {
                if ($_SESSION['msg_erro']) {
                    $msg .= $this->mostraAviso($_SESSION['msg_erro'], 'msg_erro');
                }
                if ($_SESSION['msg_sucesso']) {
                    $msg .= $this->mostraAviso($_SESSION['msg_sucesso'], 'msg_sucesso');
                }
                if ($_SESSION['msg_saida']) {
                    $msg .= $this->mostraAviso($_SESSION['msg_saida'], 'msg_saida');
                }
                if ($_SESSION['msg_entrada']) {
                    $msg .= $this->mostraAviso($_SESSION['msg_entrada'], 'msg_entrada');
                }
                if ($_SESSION['msg_aviso']) {
                    $msg .= $this->mostraAviso($_SESSION['msg_aviso'], 'msg_aviso');
                }
            }
            if ($_SESSION['msg_alert']) {
                $msg .= $_SESSION['msg_alert'];
            }

            return ($msg);
        }


// ====== admin ========================================================================================================			


        function redireciona($controlador, $acao, $params = array(), $conteudo = null)
        {
            global $sistema;

            if ($conteudo != null) {
                $this->mostraMensagem($conteudo, 1);
            }

            if (!is_array($params)) {
                $params = array();
            }

            @session_write_close();

            if (empty($controlador)) {
                $this->mensagensNaSessao($conteudo);
                header('Location: ' . ADMINURL . $sistema['controlador']);
                exit();
            } elseif (empty($acao)) {
                $this->mensagensNaSessao($conteudo);
                header('Location: ' . ADMINURL . $controlador);
                exit();
            } else {
                $this->mensagensNaSessao($conteudo);
                header('Location: ' . ADMINURL . $controlador . '/' . $acao . '/' . implode('/', $params));
                exit();
            }
        }


// -------------------------------------------------------------------------------------------------------------------


        function debuga($array = null, $stop = 1, $pre = 1)
        {

            if (!$array && $array !== 0) {
                echo 'vazio';
                if ($stop == 1) exit;
            }

            if ($pre == 1) {
                echo '<pre>';
            }
            print_r($array);
            if ($pre == 1) {
                echo '</pre>';
            }
            if ($stop == 1) exit;
        }


// -------------------------------------------------------------------------------------------------------------------


        function retorna($conteudo = null)
        {
            if (!$conteudo) return false;

            $this->mensagensNaSessao($conteudo);
            return $conteudo;
        }


// -------------------------------------------------------------------------------------------------------------------


        function DBFormat($post, $html = null)
        {
            if (is_array($post)) {
                foreach ($post as $k => $v) {
                    if (is_array($v)) {
                        $post[$k] = DBFormat($v);
                    } else {
                        if (!empty($v)) {
                            $post[$k] = trim(AddSlashes(str_replace('<![CDATA[', '', str_replace(']]>', '', $v))));
                            if (!$html) $post[$k] = strip_tags($post[$k]);
                        }
                    }
                }
            } elseif (!empty($post)) {
                $post = trim(AddSlashes(str_replace('<![CDATA[', '', str_replace(']]>', '', $post))));
                if (!$html) $post = strip_tags($post);
            } else {
                return false;
            }
            return ($post);
        }


// -------------------------------------------------------------------------------------------------------------------


    }//class


} //if class exists



?>