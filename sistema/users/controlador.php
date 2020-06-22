<?php


class users extends controlador_mestre
{

    var $controlador_nome = "Usuários";
    var $api_url = 'https://jsonplaceholder.typicode.com/users';


// =====================================================================================================================================


    function __construct()
    {

    }


// =====================================================================================================================================


    function admin_list($params, $get, $post, $file)
    {
        $conteudo['acao_nome'] = 'Lista de Usuários';
        $userId = intVal($_SESSION['adminUser']['userid']);

        if($userId <= 0)
            header('Location: /sistema/login.php?erro=2');

        $users = json_decode(file_get_contents($this->api_url), true);
        if($params)
        {
            try
            {
                $users = $this->newOrder($users,$params);
            }
            catch(Exception $e){
                $conteudo['msg_erro'][] = $e->getMessage();
            }
        }

        $this->set('users',$users);

        $conteudo['template'] = array('users', 'list');
        $this->mensagensNaSessao($conteudo);
        return $conteudo;
    }



// =====================================================================================================================================


    private function newOrder($users=null,$params=null)
    {
        if(!$users || !$params)
            throw new Exception("Sem dados para ordenar");

        $nusers = $ousers = array();
        foreach($users as $k=>$v)
        {
            $nusers[$v[$params[0]]] = $k;
        }

        if($params[1] == 'asc')
            ksort($nusers);
        else
            krsort($nusers);
        foreach($nusers as $k=>$v)
        {
            $ousers[] = $users[$v];
        }

        return $ousers;
    }


// =====================================================================================================================================


    function admin_order($params, $get, $post, $file)
    {
        $params[0] = $post['filter-by'];
        $params[1] = $post['vector'];

        return $this->admin_list($params, $get, $post, $file);
    }


}

?>
