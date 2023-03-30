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
		              	echo '<li><a class="facebook" href="https://www.facebook.com/'.$info_site['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
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