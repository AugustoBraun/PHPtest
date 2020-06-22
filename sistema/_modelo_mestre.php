<?php

if(!class_exists('modelo_mestre')) {

    class modelo_mestre
    {

        private $host = HOST; // Host (Servidor) que executa o banco de dados
        private $user = USER; // Usuário que se conecta ao servidor de banco de dados
        private $pass = PASS; // Senha do usuário para conexão ao banco de dados
        private $db = DB; // Nome do banco de dados a ser utilizado

        private $con;


        function __construct()
        {
            @header("Access-Control-Allow-Origin: *");
            $this->con = $this->conectar;
        }



        function conectar($host = null) //possiveis valores P1, P2
        {
            $con = new mysqli(HOST, USER, PASS, DB);

            $con->set_charset('utf8');
            if ($con->connect_errno > 0) {
                die('Impossivel conectar ao banco de dados [' . $con->connect_error . ']');
            }
            return $con;
        }


        function consulta($query, $host = null)
        {
            if (!$con) {
                $con = $this->conectar($host);
            }
            if (false !== $con->query($query)) {
                return $con->affected_rows;
            } else {
                return false;
            }

        }


        function consulta_id($query, $host = null, $fizzle = null)
        {
            if (!$con) {
                $con = $this->conectar($host);
            }
            if ($sql = $con->query($query)) {
                $id = mysqli_insert_id($con);
                return $id;
            } else {
                $_SESSION['mysql_error'] = $con->error;
                return false;
            }
        }


        function consulta_af($query, $host = null, $fizzle = null)
        {
            if (!$con) $con = $this->conectar($host);

            if ($sql = $con->query($query)) {
                $id = mysqli_affected_rows($con);
                return $id;
            } else {
                $_SESSION['mysql_error'] = $con->error;
                return false;
            }
        }


        function consulta_array($query, $campo = null, $fizzle = null)
        {
            if (empty($query)) return false;

            $res = array();

            if (!$con)
                $con = $this->conectar($host);

            if ($sql = $con->query($query)) {
                while ($resultado = $sql->fetch_assoc()) {
                    if ($campo) $res[] = $resultado[$campo]; else
                        $res[] = $resultado;
                }
                return ($res);
            } else {
                $_SESSION['mysql_error'] = $con->error;
                return false;
            }
        }


        function consulta_tabela($tabela, $host = null)
        {
            if (!$con)
                $con = $this->conectar($host);
            if ($con->query("DESCRIBE " . $tabela))
                return "sim";
             else
                return "nao";
        }

    }

}
?>
