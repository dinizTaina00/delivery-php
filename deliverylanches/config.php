<?php  
	
	session_start();

	error_reporting(-1);
	ini_set('display_errors', 1);

	date_default_timezone_set('America/Sao_Paulo');

	$autoload = function($class){
		if($class == 'Email'){
			require_once('classes/phpmailer/PHPMailerAutoLoad.php');
		}
		include('classes/'.$class.'.php');
	};

	spl_autoload_register($autoload);

	define('INCLUDE_PATH','http://localhost/deliverylanches/');
	define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');
	define('INCLUDE_PATH_USER',INCLUDE_PATH.'usuario/');

	define('BASE_DIR_PAINEL',__DIR__.'/painel');
	define('ROOT',__DIR__.'/');

	//Conectar com o banco de dados
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','delivery');
        define('PORT','3306');


	//Funções
	 function pegaCargo($indice){	
	  	return Painel::$permissao[$indice];
	 }

	// function selecionadoMenu($par){
	// 	$url = explode('/',@$_GET['url'])[0];
	// 	if ($url == $par) {
	// 		echo "class='menu-active'";
	// 	}
	// }

	// function verificaPermissaoMenu($permissao){
	// 	if ($_SESSION['permissao'] >= $permissao) {
	// 		return;
	// 	}else{
	// 		echo 'style="display:none"';
	// 	}
	// }

	// function verificaPermissaoPagina($permissao){
	// 	if ($_SESSION['permissao'] != Painel::$permissao[$indice]) {
	// 		return;
	// 	}else{
	// 		session_destroy();
	// 	}	
	// }

	/*function verificaPermissaoPagina(){
		if (!empty($_SESSION['permissao'])) {
			if ($_SESSION['permissao'] == 1){
				header("Location: ".INCLUDE_PATH_PAINEL."home");
			die();
			}else if($_SESSION['permissao'] == 0){
				header("Location: ".INCLUDE_PATH_USER."home");
			die();
			}
		}else{
			include 'pages/main.php';
		}
	} */
?>