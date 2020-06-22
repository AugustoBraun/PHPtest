<?PHP

    date_default_timezone_set('America/Sao_Paulo');
	ini_set("display_errors", true);
    error_reporting(E_ALL ^ E_NOTICE);

	$rootdir = $_SERVER["DOCUMENT_ROOT"]."/";
    if(substr($rootdir,-2)=='//'){ $rootdir = substr($rootdir,0,-1);}
    define('ROOTDIR', $rootdir);

    $adminroot = $rootdir."sistema/";
    define('ADMINROOT', $adminroot);

    $siteurl = "http://".$_SERVER["HTTP_HOST"]."/";
    define('SITEURL', $siteurl);

    $adminurl = SITEURL."sistema/";
    define('ADMINURL', $adminurl);

    $recaptcha_public_key = '6LdIBbwUAAAAAIcR9qnLeLNJML1lknbeesHoaASq';
    $recaptcha_private_key = "6LdIBbwUAAAAAJH-8EiV7sn6rtoMUER_j_VDWfp0";

    $mysql_server = "localhost";
    $database = "cep";
    $user = "root";
    $password = "";


    define('HOST', $mysql_server);
    define('DB', $database);
    define('USER', $user);
    define('PASS', $password);

    $db = new mysqli($mysql_server,$user,$password,$database);
    $db->set_charset('utf8');
    if($db->connect_errno > 0)
        die('Impossivel conectar ao banco de dados [' . $db->connect_error . ']');

    define('CONTROLADOR', $sistema['controlador']);
    define('ACAO', str_replace('admin_','',$sistema['acao']));
    $_SESSION['sistema']['controlador'] = $sistema['controlador'];
    $_SESSION['sistema']['acao'] = str_replace('admin_','',$sistema['acao']);
	define('SERVER_NAME', $_SERVER['SERVER_NAME']);
	define('SERVER_URI', $_SERVER ['REQUEST_URI']);
	define('URL_ATUAL', 'http://'.SERVER_NAME.'/'.SERVER_URI);

?>