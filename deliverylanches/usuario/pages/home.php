	<?php  
		//include("modal-add-carrinho.php");
		$sql_imagens_banner = Mysql::conectar()->prepare("SELECT * FROM `tb_site.imagens_site`");
		$sql_imagens_banner->execute();
		
			if ($sql_imagens_banner->rowCount() > 0) {
				$sql_imagens_banner = $sql_imagens_banner->fetch();
				?>
					<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 20px;">
					  <div class="carousel-inner">
					    <div class="carousel-item active">
					      <img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $sql_imagens_banner['imagem_banner']; ?>" class="d-block w-100">
					    </div>
					  </div>
					</div>
				<?php
			}
		?>
         <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 20px;">
		<div class="carousel-inner">
		   <div class="carousel-item active">
			 <center><img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/metodos.png" style="width: 55%;"></center>
		   </div>
		</div>
	</div>
        
	<div class="container" style="margin-bottom: 100px;">
		<p class="container-title" style="text-align: center; padding: 20px 0 10px;">Produtos em destaque</p>
	  <!--Product Grid-->

	    <div id="div1">
	      <section class="section-grid">
	      <div class="grid-prod">

	       <?php  
	       	$sql_produtos = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` WHERE status = 1 ORDER BY RAND() LIMIT 4");
	       	$sql_produtos->execute();

	       	if ($sql_produtos->rowCount() > 0) {

		       	$sql_produtos = $sql_produtos->fetchAll();

		       	foreach ($sql_produtos as $key => $produto) {
		       		include("modal-add-carrinho.php");
		       ?>	
		       <div class="prod-grid">

		        <center><img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $produto['img']; ?>">
		        	 <p class="prod-name"><?php echo $produto['nome']; ?></p>    
		             <p class="prod-desc">R$<?php echo Painel::convertMoney($produto['preco']); ?></p>
		               <!-- Button trigger modal -->
	                  <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal<?php echo $produto['id']; ?>"> Add carrinho <i class="fa fa-shopping-cart" aria-hidden="true"></i></button></center>
		       </div>
		   	  <?php 
		   		} }else{
		   			echo "<p>Ainda não possui produtos disponíveis</p>";
		   		} 
		   	   ?>
	      </div>
	       </section> 
	    </div>
	  </div>  

	  <hr style="background: #737373; margin-bottom: 50px;">

	  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body position-relative">
        <div class="position-absolute top-0 start-50 translate-middle">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
