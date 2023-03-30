<?php  
  if (isset($_GET['deleta'])) {
    $id = $_GET['deleta'];
    $table = "tb_site.produtos";
    $deleta = Painel::deletar($table,$id);
    echo "<script>window.location='".INCLUDE_PATH_PAINEL."lista-produtos'</script>";
  }
?>
<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH ?>css/album.css">
<div class="container">

  <div class="box-content">
      <!-- Busca -->
      <div class="busca">
        <h4><i class="fa fa-search"></i> Busque por um produto</h4>
        <form method="post">
          <input style="font-size: 15px;" placeholder="Procure pelo nome do produto" type="text" name="busca">
          <input type="submit" name="acao" value="Buscar">
        </form>
      </div><!--busca-->

  </div>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

      <?php  
        $query = "";
        if (isset($_POST['acao']) && $_POST['acao'] == "Buscar") {
          $nome = $_POST['busca'];
          $query = "AND (nome LIKE '%$nome%' OR ingredientes LIKE '%$nome%')";
        }

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` WHERE status = 1 $query");
        $sql->execute();
        $result_pesquisa = $sql->fetchAll();

        foreach ($result_pesquisa as $key => $produto) {
          $id = $produto['id'];
      ?>

        <div class="col">
          <div class="card shadow-sm">
            <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $produto['img']; ?>" class="bd-placeholder-img card-img-top" style="max-height: 462.5px; max-width: 422.5px;">

            <div class="card-body">
              <h3><?php echo $produto['nome']; ?></h3>
              <p class="card-text"><?php echo $produto['ingredientes']; ?>.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="<?php echo INCLUDE_PATH_PAINEL ?>edita-produto?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-secondary">Ver</a>
                  
                  <a href="<?php echo INCLUDE_PATH_PAINEL ?>lista-produtos?deleta=<?php echo $produto['id']; ?>" class="btn btn-sm btn-danger">Deletar<i class="fas fa-trash-alt" style="color: red;"></i></a>
                </div>
                <small class="text-muted"><?php echo $produto['tempo']; ?> mins</small>
              </div>
            </div>
          </div>
        </div>

      <?php } ?>
      </div>
</div>

<?php  
  if (isset($_GET['acao']) && $_GET['acao'] == 'ativo') {
    $id = $_GET['id'];
    $acao = $_GET['acao'];

    $sql = MySql::conectar()->prepare("UPDATE `tb_admin.produto` SET status = 'ativo' WHERE id = $id");
    $sql->execute();
    echo "<script>window.location='".INCLUDE_PATH_PAINEL."lista-produtos'</script>";

  }

  if (isset($_GET['acao']) && $_GET['acao'] == 'inativo') {
    $id = $_GET['id'];
    $acao = $_GET['acao'];

    $sql = MySql::conectar()->prepare("UPDATE `tb_admin.produto` SET status = 'inativo' WHERE id = $id");
    $sql->execute();
    echo "<script>window.location='".INCLUDE_PATH_PAINEL."lista-produtos'</script>";

  }
?>