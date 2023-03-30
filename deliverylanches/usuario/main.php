<?php  

$info_site = Site::sqlInfoSite();

if(isset($_GET['loggout'])){
	Painel::loggout();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $info_site['nome_negocio']; ?></title>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH ?>css/style-user.css">

	<!-- Bootstrap css -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<!-- Bootstrap js -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        
        

</head>
<style type="text/css">
	a{
		text-decoration: none;
	}
</style>
<body style="height: 100%;">
	<header class="px-3 py-2 bg-light text-light">
	  <div class="container">
	    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
	    	<?php  
	    	$sql_imagens_banner = Mysql::conectar()->prepare("SELECT * FROM `tb_site.imagens_site`");
			$sql_imagens_banner->execute();
		
				if ($sql_imagens_banner->rowCount() > 0) {
					$sql_imagens_banner = $sql_imagens_banner->fetch();
					?>
						<a href="<?php echo INCLUDE_PATH_USER ?>home" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-dark text-decoration-none">
					      <img style="border-radius: 50%; width:100px ;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $sql_imagens_banner['imagem_logo']; ?>">
					    </a>
					<?php
				}
	    	?>

	      <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
	        <li>
	          <a href="<?php echo INCLUDE_PATH_USER ?>home" class="nav-link text-secondary">
	            Home
	          </a>
	        </li>
            <li>
	          <a href="<?php echo INCLUDE_PATH_USER ?>produtos" class="nav-link text-dark">
	            Produtos
	          </a>
	        </li>
	        <li>
	        	<a href="<?php echo INCLUDE_PATH_USER ?>cart" class="nav-link text-dark">
	        		Carrinho
	        	</a>
	        </li>
	        <li>
	          <a href="<?php echo INCLUDE_PATH_USER ?>sobre" class="nav-link text-dark">
	            Sobre nós
	          </a>
	        </li>
	        <li>
	        	<a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #496154; font-weight: 500;">
		            <?php echo $_SESSION['nome']; ?>
		          </a>
		          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
		            <li><a class="dropdown-item" href="<?php echo INCLUDE_PATH_USER ?>perfil">Meus dados</a></li>
		            <li><a class="dropdown-item" href="<?php echo INCLUDE_PATH_USER ?>pedidos">Meus pedidos</a></li>
		            <li><a class="dropdown-item" href="?loggout">Sair</a></li>
		          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</header>
        
		<?php  
		if ($info_site['fretegratis_apartir'] != 0 || !empty($info_site['fretegratis_apartir'])) {
			echo '<div class="frete-gratis">
					<p style="padding: 20px;">Frete Grátis em pedidos acima de R$'.Painel::convertMoney($info_site['fretegratis_apartir']).'</p>
				  </div>';
		}
		?>

		<?php 
			    $hora = date("H:i:s");
				//$horarios = array("00:00:00","01:00:00","02:00:00","03:00:00","04:00:00","05:00:00","06:00:00","07:00:00","08:00:00","09:00:00","10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00","18:00:00","19:00:00","20:00:00","21:00:00","22:00:00","22:00:00","23:00:00","24:00:00");
				if($info_site['disponivel'] == "0"){
					echo '<div class="frete-gratis" style="background-color: red;">
    					<p style="padding: 20px;">Estamos fechados no momento!</p>
    				  </div>';
				}
		?>
		

	<div class="content" style="min-height: calc(100vh - 270px);">
		
		<?php Painel::carregarPagina(); ?>

	</div> <!-- content -->

		<!-- Footer -->
		  <!-- Site footer -->
		    <footer class="site-footer">
		      <div class="container">
		        <div class="row">
		          <div class="col-sm-12 col-md-6">
		            <h6>Sobre nós</h6>
		            <p class="text-justify"><?php echo $info_site['sobre']; ?>.</p>
		          </div>

		          <!-- <div class="col-xs-6 col-md-3">
		            <h6>Categories</h6>
		            <ul class="footer-links">
		              <li><a href="">Camisetas</a></li>
		              <li><a href="">Moletons</a></li>
		              <li><a href="">Bonés</a></li>
		              <li><a href="">Jaquetas</a></li>
		            </ul>
		          </div> -->

		          <div class="col-xs-6 col-md-3">
		            <h6>Páginas</h6>
		            <ul class="footer-links">
		              <li><a href="">Voltar ao topo</a></li>
		              <li><a href="">Produtos</a></li>
		              <li><a href="">Sobre</a></li>
		            </ul>
		          </div>
		        </div>
		        <hr>
		      </div>
		      <div class="container">
		        <div class="row">
		          <div class="col-md-8 col-sm-6 col-xs-12">
		            <p class="copyright-text">Copyright &copy; 2021 Todos direitos reservados por 
		         <a href="#">Notorius Dev</a>.
		            </p>
		          </div>

		          <div class="col-md-4 col-sm-6 col-xs-12">
		            <ul class="social-icons">
		              <?php if(!empty($info_site['facebook'])) 
		              	echo '<li><a target="_blank" class="facebook" href="https://www.facebook.com/'.$info_site['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
		              ?>
		              <?php if(!empty($info_site['instagram'])) 
		               echo '<li><a target="_blank" class="twitter" href="https://www.instagram.com/'.$info_site['instagram'].'"><i class="fa fa-instagram"></i></a></li>';
		              ?>
		               
		            </ul>
		          </div>
		        </div>
		      </div>
		</footer>
	<!-- End Footer -->

</body>
</html>

<?php
        
?>