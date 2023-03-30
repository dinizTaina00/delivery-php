<?php  
if (isset($_SESSION['permissao'])) {
		header("Location: ".INCLUDE_PATH."index");
		}
$info_site = Site::sqlInfoSite();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $info_site['nome_negocio']; ?></title>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH ?>css/style-user.css">

	<!-- Bootstrap css -->
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">-->
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<!-- Bootstrap js -->
	<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>-->

	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


</head>
<body style="height: 100%;">
	<header class="px-3 py-2 bg-light text-dark">
	  <div class="container">
	    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
	      <?php  
	    	$sql_imagens_banner = Mysql::conectar()->prepare("SELECT * FROM `tb_site.imagens_site`");
			$sql_imagens_banner->execute();
		
				if ($sql_imagens_banner->rowCount() > 0) {
					$sql_imagens_banner = $sql_imagens_banner->fetch();
					?>
						<a href="" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-dark text-decoration-none">
					      <img style="border-radius: 50%; width:100px ;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $sql_imagens_banner['imagem_logo']; ?>">
					    </a>
					<?php
				}else{
                                  ?>
                                          <a class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-dark text-decoration-none">Sem Logo</a>
                                  <?php
                                }
	    	?>

	      <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
	        <li>
	          <a href="home" class="nav-link text-secondary">
	            Home
	          </a>
	        </li>
	        <li>
	          <a href="produtos" class="nav-link text-dark">
	            Produtos
	          </a>
	        </li>
	        <li>
	          <a href="sobre" class="nav-link text-dark">
	            Sobre nós
	          </a>
	        </li>

	        <li>
	        	<a href="login" class="btn btn-outline-info">Acessar</a>
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
		            </ul>
		          </div> -->

		          <div class="col-md-4 ms-5 col-sm-4 col-xs-8">
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
		            <p class="copyright-text">Copyright &copy; 2017 All Rights Reserved by 
		         <a href="#">Notorius Dev</a>.
		            </p>
		          </div>

		          <div class="col-md-2 col-sm-2 col-xs-8">
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
