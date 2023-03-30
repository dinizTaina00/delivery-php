<?php  
	include('../config.php');

	if ($_SESSION['permissao'] == 1) {
		include('main.php');
	}else{
		header("Location: ".INCLUDE_PATH);
	}
?>