<?php


class buscacep extends controlador_mestre
{

    var $controlador_nome = "BuscaCEP";
    var $api_url = 'https://viacep.com.br/';


// =====================================================================================================================================


    function __construct()
    {

    }


// =====================================================================================================================================


    function admin_listacep($params, $get, $post, $file)
    {

        $conteudo['acao_nome'] = 'Lista de CEPs Cadastrados';
        $userId = intVal($_SESSION['adminUser']['userid']);
        if($userId <= 0)
            header('Location: /sistema/login.php?erro=2');

        //lista ceps no front
        $query = "select * from ceps order by cepId desc";        
        $listacep = $this->consulta_array($query);
        $this->set('listacep',$listacep);

        $conteudo['template'] = array('buscacep', 'listacep');
        $this->mensagensNaSessao($conteudo);
        return $conteudo;

    }



// =====================================================================================================================================

    function admin_consultar($params, $get, $post, $file)
    {
        $cep = intval($params[0]);

        if($cep)
        {
            $query = "select cepId from ceps where cep=".$cep;
            $data = $this->consulta_array($query);

            if(empty($data))  //registra o novo cep e retorna json para prepend na listagem
            {
                $xmlContent = file_get_contents('https://viacep.com.br/ws/'.$cep.'/xml/');
                $xml = simplexml_load_string($xmlContent);
                $arrayData = $this->xmlToArray($xml);

                if($arrayData['erro'])
                {
                    $response_array['status'] = 'error';
                    $arrayData = json_encode(array('400'), JSON_FORCE_OBJECT);
                    $this->debuga($arrayData,1,0);
                }

                $arrayData = $arrayData['xmlcep'];

                if(is_array($arrayData['logradouro']))
                $arrayData['logradouro'] = "";

                if(is_array($arrayData['bairro']))
                $arrayData['bairro'] = "";

                $query = "insert into ceps (cep,logradouro,bairro,localidade,uf,xml) values (
                            '".$cep."',
                            '".$arrayData['logradouro']."',
                            '".$arrayData['bairro']."',
                            '".$arrayData['localidade']."',
                            '".$arrayData['uf']."',
                            '".$xmlContent."'           
                            )";

                if(false === $cepId = $this->consulta_id($query))
                {

                    $response_array['status'] = 'error';
                    $arrayData = json_encode(array('Erro ao Cadastrar o CEP'), JSON_FORCE_OBJECT);
                    $this->debuga($arrayData,1,0);

                }else{
                    $arrayData['cepId'] = $cepId;
                    $response_array['status'] = 'success';
                    $arrayData = json_encode($arrayData, JSON_FORCE_OBJECT);
                    $this->debuga($arrayData,1,0);
                }

            }else{  // cep ja esta cadastrado retorna id

                
                $response_array['status'] = 'success';
                $arrayData = array();
                $arrayData['existe'] = $data[0]['cepId'];
                $arrayData = json_encode($arrayData, JSON_FORCE_OBJECT);
                $this->debuga($arrayData,1,0);

            }

            $response_array['status'] = 'error';
            $response_array['statusText'] = json_encode(array('Formato inválido de CEP'), JSON_FORCE_OBJECT);
            $this->debuga($arrayData,1,0);

        }else{
            
            $response_array['status'] = 'error';
            $response_array['statusText'] = json_encode(array('CEP Não Informado'), JSON_FORCE_OBJECT);
            $this->debuga($arrayData,1,0);

        }

        exit;
    }


// =====================================================================================================================================


    function busca_cep($cep)
    {  
        $resultado = @file_get_contents('https://viacep.com.br/ws/'.$cep.'/xml/');   
        return $resultado;  
    }  
    


// =====================================================================================================================================


    function admin_baixa_xml($params)
    {  
        $cepId = intVal($params[0]);

        if($cepId <= 0)
        {
            $response_array['status'] = 'error';
            $this->debuga(json_encode(array('error' => 'CEP Inválido para Download do XML'), JSON_FORCE_OBJECT),1,0);
        }

        $query = "select cep, xml from ceps where cepId=".$cepId;
        $data = $this->consulta_array($query);
        $data = $data[0];

        header('Content-disposition: attachment; filename='.$data['cep'].'.xml');
        header ("Content-Type:text/xml"); 
        echo  $data['xml'];
        header("Expires: 0");

    }  


// =====================================================================================================================================


    function xmlToArray($xml, $options = array()) {
        $defaults = array(
            'namespaceSeparator' => ':', // você pode querer que isso seja algo diferente de um cólon
            'attributePrefix' => '@',    // para distinguir entre os nós e os atributos com o mesmo nome
            'alwaysArray' => array(),    // array de tags que devem sempre ser array
            'autoArray' => true,         // só criar arrays para as tags que aparecem mais de uma vez
            'textContent' => '$',        // chave utilizada para o conteúdo do texto de elementos
            'autoText' => true,          // pular chave "textContent" se o nó não tem atributos ou nós filho
            'keySearch' => false,        // pesquisa opcional e substituir na tag e nomes de atributos
            'keyReplace' => false        // substituir valores por valores acima de busca
        );
        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces[''] = null; // adiciona namespace base(vazio) 

        // Obtém os atributos de todos os namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                // Substituir caracteres no nome do atributo
                if ($options['keySearch']) $attributeName =
                        str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix']
                        . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                        . $attributeName;
                $attributesArray[$attributeKey] = (string)$attribute;
            }
        }

        // Obtém nós filhos de todos os namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                // Recursividade em nós filho
                $childArray = $this->xmlToArray($childXml, $options);
                // list($childTagName, $childProperties) = each($childArray);
                list($childTagName, $childProperties) = [key($childArray), current($childArray)];

                // Substituir caracteres no nome da tag
                if ($options['keySearch']) $childTagName =
                        str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                // Adiciona um prefixo namespace, se houver
                if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;

                if (!isset($tagsArray[$childTagName])) {
                    // Só entra com esta chave
                    // Testa se as tags deste tipo deve ser sempre matrizes, não importa a contagem de elementos
                    $tagsArray[$childTagName] =
                            in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                            ? array($childProperties) : $childProperties;
                } elseif (
                    is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                    === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }

        // Obtém o texto do nó
        $textContentArray = array();
        $plainText = trim((string)$xml);
        if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;

        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
                ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

        // Retorna o nó como array
        return array(
            $xml->getName() => $propertiesArray
        );
    }




// =====================================================================================================================================

}

?>
