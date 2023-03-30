	<?php  
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
        
        
	<div class="container p-1" style="margin-bottom: 100px;">
		<p class="container-title" style="text-align: center; padding: 20px 0 10px;">Produtos em destaque</p>
	  <!--Product Grid-->

	    <div id="div1">
	      <section class="section-grid">
	      <div class="grid-prod">

	       <?php  
	       	$sql_produtos = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` ORDER BY RAND() LIMIT 4");
	       	$sql_produtos->execute();
                
                if($sql_produtos->rowCount() > 0){
                          $sql_produtos = $sql_produtos->fetchAll();
                          foreach ($sql_produtos as $key => $produto) {
	       ?>	
                       <div class="prod-grid">
        
                        <center><img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $produto['img']; ?>">
                                 <p class="prod-name"><?php echo $produto['nome']; ?></p>    
                             <p class="prod-desc">R$<?php echo Painel::convertMoney($produto['preco']); ?></p>
                                <a href="login" class="btn btn-outline-info"> Acesse para ver <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></center>
                       </div>
	   	  
                <?php }
                     } else{
                     ?>
                     
                     <div class="prod-grid ">
                        <p>Ainda não há produtos disponíveis.</p>
                     </div>
                     
                 <?php    
                     }
                 ?>
                  
        
	       	
	      </div>
	       </section> 
	    </div>
	  </div>  

	  <hr style="background: #737373; margin-bottom: 50px;">


