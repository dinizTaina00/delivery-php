<?php  	
	include('config.php');

	if (isset($_SESSION['permissao'])) {
		if ($_SESSION['permissao'] == 1) {
			header("Location: ".INCLUDE_PATH_PAINEL."home");
			die();
		}else if($_SESSION['permissao'] == 0){
			header("Location: ".INCLUDE_PATH_USER."home");
			die();
		}
	}else{
		include 'pages/main.php';
	}

	// if (Painel::logado() == true) {
	// 	if ($_SESSION['permissao'] == 1) {
	// 		echo '<script> location.replace("'.INCLUDE_PATH_PAINEL.'"); </script>';
	// 		die();
	// 	}else if($_SESSION['permissao'] == 0){
	// 		echo '<script> location.replace("'.INCLUDE_PATH_USER.'"); </script>';
	// 		die();
	// 	}
	// }else{
	// 	include('pages/main.php');
	// }

?>