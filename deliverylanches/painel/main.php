<?php      

	if (isset($_GET['loggout'])) {
		Painel::loggout();
	}

	$info_site = Site::sqlInfoSite();
	$imagens_site = Site::sqlImagensSite();
	
	$idsite = $info_site['id'];
    
    if(isset($_GET['disponivel'])){
        $update = MySql::conectar()->prepare("UPDATE `tb_site.informacoes_site` SET disponivel = 1 WHERE id = $idsite");
        $update->execute();
        echo "<script>window.location='".INCLUDE_PATH_PAINEL."home'</script>";
    }
    
    if(isset($_GET['indisponivel'])){
        $update = MySql::conectar()->prepare("UPDATE `tb_site.informacoes_site` SET disponivel = 0 WHERE id = $idsite");
        $update->execute();
        echo "<script>window.location='".INCLUDE_PATH_PAINEL."home'</script>";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Painel de controle - <?php echo $info_site['nome_negocio']; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH ?>css/style.css">

	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

	<!-- Bootstrap css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	
	
	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

	<script type="text/javascript" src="<?php echo INCLUDE_PATH ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH ?>js/jquery.mask.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH ?>js/main.js"></script> 
	
	

</head>
<body> 

	<div class="menu">

		<div class="menu-wrapper">

		<div class="box-usuario">
			<?php  
				if ($imagens_site['imagem_logo'] == '') {
			?>
			<div class="avatar-usuario">
				<i class="fa fa-user-tag"></i>
			</div><!--avatar-usuario-->
			<?php }else{ ?>

				 <div class="imagem-usuario">
					<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagens_site['imagem_logo']; ?>">
				</div>

			<?php } ?>
			<div class="nome-usuario">
				<p><?php echo $_SESSION['nome']; ?></p>
				<p><?php echo pegaCargo($_SESSION['permissao']); ?></p>
                                
			</div><!--nome-usuario-->
		</div><!--box-usuario -->

		<div class="items-menu">

			<div class="dropdown">
			     <h2><a href="<?php echo INCLUDE_PATH_PAINEL ?>home" class="dropdown-btn" style="font-size: 18px;"><i class="fa fa-dashboard" style="color: black;"></i> Painel de Controle</a></h2>
		
				 <a class="dropdown-btn"><i class="fa fa-list-ul " style="color: blue;"></i> Produtos 
				    <i class="fa fa-caret-down"></i>
				 </a>
				  <div class="dropdown-container">
				    <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-produto"><i class="fa fa-edit"></i> Cadastrar Produto</a>
					<a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>lista-produtos"><i class="fa fa-list-ul"></i> Lista de Produtos</a>
				  </div>

				 <a class="dropdown-btn"><i class="fa fa-bars"  style="color: blue;"></i> Categorias  
				 	<i class="fa fa-caret-down"></i>
				 </a>
				  <div class="dropdown-container">
				    <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>categorias"><i class="fa fa-list-ul"></i> Lista de categorias</a>
				  </div>

				  <a class="dropdown-btn"> <i class="fa fa-user"  style="color: blue;"></i> Usuários 
				  	<i class="fa fa-caret-down"></i>
				  </a>
				   <div class="dropdown-container">
				    <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-usuario"><i class="fa fa-edit"></i> Editar Seu Usuário</a>
					<a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>adicionar-usuario"><i class="	fa fa-user-plus"></i> Adicionar Usuário</a>
					<a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>lista-usuarios"><i class="	fa fa-user"></i> Lista de Usuários</a>
				   </div>

				 <a class="dropdown-btn"><i class="fa fa-bell"  style="color: blue;"></i> Pedidos 
				 	<i class="fa fa-caret-down"></i>
				 </a>
				  <div class="dropdown-container">
				    <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>novos-pedidos"><i class="fa fa-bell"></i> Novos Pedidos</a>
				    <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>pedidos-enviados"><i class="fa fa-bell"></i> Pedidos Enviados</a>
					<a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>pedidos-finalizados"><i class="	fa fa-bell"></i> Histórico de Pedidos</a>
				  </div>
				  
				  <a href="<?php echo INCLUDE_PATH_PAINEL ?>estoque" class="dropdown-btn"><i class="fa fa-list-ul " style="color: blue;"></i> Estoque 
				    <i class="fa fa-caret-down"></i>
				 </a>

				 <a href="<?php echo INCLUDE_PATH_PAINEL; ?>pagamento"><i class="fa fa-money"  style="color: blue; position-relative: relative; margin-bottom: 12px;"></i> Pagamento
				 	<i class="fa fa-caret-down"></i>
				 </a>


				 <a class="dropdown-btn"><i class="fa fa-bar-chart"  style="color: blue;"></i> Financeiro
				 	<i class="fa fa-caret-down"></i>
				 </a>
				  <div class="dropdown-container">
				    <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>financeiro"><i class="fa fa-chart-line"></i> Seus Faturamentos</a>
					<a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>despesas"><i class="fa fa-chart-line"></i> Suas Despesas</a>
				  </div>

			     <a class="dropdown-btn"><i class="fa fa-cogs" style="color: blue;"></i> Configurações Gerais  
			     	<i class="fa fa-caret-down"></i>
				 </a>
				  <div class="dropdown-container">
				    <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>site-info"><i class="fa fa-edit"></i> Informações do site</a>
			        <a class="dropdown-container-a" href="<?php echo INCLUDE_PATH_PAINEL ?>info-index"><i class="fa fa-edit"></i> Informações da Página Inicial</a>
				  </div>

			</div>
			
		</div> <!-- items-menu -->

		</div> <!-- menu-wrapper -->
	</div><!-- menu -->
	


	<header>
		<div class="center">
			<div class="menu-btn">
				<i class="fa fa-bars" style="color: black;"></i>
			</div>


			<div class="loggout">
			    <?php 
			    $hora = date("H:i:s");
				//$horarios = array("00:00:00","01:00:00","02:00:00","03:00:00","04:00:00","05:00:00","06:00:00","07:00:00","08:00:00","09:00:00","10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00","18:00:00","19:00:00","20:00:00","21:00:00","22:00:00","22:00:00","23:00:00","24:00:00");
				// if($info_site['disponivel'] == "1"){
				// 	echo '<a href="?indisponivel" class="btn btn-success">Pedidos disponíveis</a>'; 
				// }elseif($info_site['disponivel'] == "0"){
				// 	echo '<a href="?disponivel" class="btn btn-danger">Pedidos indisponíveis</a>';
				// }
				if ($info_site['horaInicio'] > $hora && $hora < $info_site['horaTermino']) {
    			    echo '<a class="btn btn-danger">Pedidos indisponíveis</a>';
    		    }else{
    		        echo '<a class="btn btn-success">Pedidos disponíveis</a>'; 
    		    }
			    ?>
				<a style="color: black;" <?php //selecionadoMenu('home'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>home"><i class="fa fa-home"></i> Página inicial</a>
				<a href="<?php echo INCLUDE_PATH_PAINEL ?>?loggout"> Sair <i class="fa fa-window-close"></i></a>
			</div>

			<div class="clear"></div>
		</div>
	</header>

	<div class="content">

		<?php Painel::carregarPagina(); ?>

	</div> <!-- content -->
       


	<div class="clear"></div>


</body>
</html>



<script>
/* Loop through all dropdown as to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}
</script>

<?php

?>