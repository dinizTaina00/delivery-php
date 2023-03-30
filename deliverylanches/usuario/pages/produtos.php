<?php  
    include("addCarrinho.php");

     $query = "";
        if (isset($_POST['acao']) && $_POST['acao'] == "Buscar") {
          $nome = $_POST['busca'];
          $query = "AND (nome LIKE '%$nome%' OR ingredientes LIKE '%$nome%')";
        }

        if (isset($_GET['categoria'])) {
          $categoria = $_GET['categoria'];
           $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` WHERE categoria = '$categoria' AND status = '1' $query");
        }else{
           $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` WHERE status = '1' $query");
        }

      $sql->execute();
      $produtos = $sql->fetchAll();

?>
  <div class="container" style="margin-bottom: 50px;">

    <!-- busca -->
      <div class="row mt-1" style="padding: 20px;">
        <div class="btn-group">
          <div class="btn-group">
            <div class=" mt-3 mr-3">
              <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  Produtos
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <?php  
                    $sql_categorias = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias`");
                    $sql_categorias->execute();
                    $sql_categorias = $sql_categorias->fetchAll();
                    foreach ($sql_categorias as $key => $categoria) {
                  ?>
                  <li><a class="dropdown-item" href="<?php echo INCLUDE_PATH_USER ?>produtos?categoria=<?php echo $categoria['nome']; ?>"><?php echo $categoria['nome']; ?></a></li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>

          <div class=" mt-3 mr-3" style="margin-left: 15px;">
            <form method="post">
              <div class="input-group mb-3">
                <input type="text" name="busca" class="form-control me-2" placeholder="Busque por um produto...">
                <button class="btn btn-outline-success" type="submit" name="acao" value="Buscar">Buscar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <!--busca-->

    <!--Product Grid-->

      <div id="div1">
        <section class="section-grid">
        <div class="grid-prod">
            <?php  
              if ($sql->rowCount() == 0) {
                echo "<p>Produto(s) não disponível</p>";
              }
            ?>

        <?php  
         foreach ($produtos as $key => $produto) {

          include("modal-add-carrinho.php");

        ?>
         <div class="prod-grid">

          <center><img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $produto['img']; ?>">
             <p class="prod-name"><?php echo $produto['nome']; ?></p>    
               <p class="prod-desc">
                 <p><?php echo "R$".Painel::convertMoney($produto['preco']); ?></p>
               </p>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal<?php echo $produto['id']; ?>"> Add carrinho <i class="fa fa-shopping-cart" aria-hidden="true"></i></button></center>
         </div>

         <?php } ?>

        </div>
         </section> 
      </div>
    </div>  
    <!-- Fim produtos grid -->

