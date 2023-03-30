<?php
     	if (isset($_SESSION['permissao'])) {
    header("Location: ".INCLUDE_PATH."index");
    }
     $query = "";
        if (isset($_POST['acao']) && $_POST['acao'] == "Buscar") {
          $nome = $_POST['busca'];
          $query = "AND (nome LIKE '%$nome%' OR ingredientes LIKE '%$nome%')";
        }

        if (isset($_GET['categoria'])) {
          if($_GET['categoria'] == "todas"){
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` WHERE status = '1'");
          }else{
            $categoria = $_GET['categoria'];
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` WHERE categoria = '$categoria' AND status = '1' $query");
          }
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
              <div class="dropdown show">
              <a class="btn btn-outline-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Produtos
              </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="produtos?categoria=todas">Todas</a>
                  <?php  
                    $sql_categorias = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias`");
                    $sql_categorias->execute();
                    $sql_categorias = $sql_categorias->fetchAll();
                    foreach ($sql_categorias as $categoria) {
                  ?>
                  <a class="dropdown-item" href="produtos?categoria=<?php echo $categoria['nome']; ?>"><?php echo $categoria['nome']; ?></a>
                  <?php } ?>
                </div>
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
         foreach ($produtos as $key => $produto) {

          if ($sql->rowCount() == 0) {
            echo "Produto não encontrado";
          }

        ?>
         <div class="prod-grid">

          <center><img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $produto['img']; ?>">
             <p class="prod-name"><?php echo $produto['nome']; ?></p>    
               <p class="prod-desc">R$<?php echo Painel::convertMoney($produto['preco']); ?></p>
                  <a href="login" class="btn btn-outline-info"> Acesse para ver <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></center>
         </div> 

         <?php } ?>

        </div>
         </section> 
      </div>
    </div>  
    <!-- Fim produtos grid -->