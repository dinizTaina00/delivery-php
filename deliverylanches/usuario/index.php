<?php  
	include('../config.php');

	if ($_SESSION['permissao'] == 0) {
		include('main.php');
	}else{
		header("Location: ".INCLUDE_PATH);
	}
?>