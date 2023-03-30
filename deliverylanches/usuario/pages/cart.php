<hr>
<?php  
$info_site = Site::sqlInfoSite();
  if (isset($_GET['remove'])) {
    if(!empty($_SESSION["carrinho"])) {
      foreach($_SESSION["carrinho"] as $k => $v) {
        if($_GET["remove"] == $v['id']){
         if($_SESSION['carrinho'][$k]['quantidade'] == 1){
            unset($_SESSION["carrinho"][$k]);
         }else{
            $_SESSION['carrinho'][$k]['quantidade'] = $_SESSION['carrinho'][$k]['quantidade'] - 1;
         }  
        }
        
        if(empty($_SESSION["carrinho"])){
          unset($_SESSION["carrinho"]);
        }
      }
    }
    echo '<script>window.location="'.INCLUDE_PATH_USER.'cart"</script>';
  }
  if (isset($_GET['removeAll'])) {
    if(!empty($_SESSION["carrinho"])) {
      foreach($_SESSION["carrinho"] as $k => $v) {
        if($_GET["removeAll"] == $v['id']){
          unset($_SESSION["carrinho"][$k]);        
        }
        if(empty($_SESSION["carrinho"])){
          unset($_SESSION["carrinho"]);
        }
      }
    }
    echo '<script>window.location="'.INCLUDE_PATH_USER.'cart"</script>';
  }
?>
<div class="box-content">
  <p style="font-size: 20px;">Carrinho de compras</p>
</div>
<div class="container">
 <div class="row" style="text-align: center;">
    <div class="col">Imagem</div>
    <div class="col">Lanche</div>
    <div class="col">Preço x Quantidade</div>
    <div class="col">Ações</div>
  </div>

<hr>
  <?php 
    $total_pagar = 0;
    $total_quantidade = 0;
    if (isset($_SESSION['carrinho'])) {
      foreach ($_SESSION['carrinho'] as $item) {

        ?>
      <div class="row" style="text-align: center; margin-bottom: 20px;">
        <div class="col" >
          <img style="border-radius: 50%;" width="50" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $item['img']; ?>">
        </div>
        <div class="col">
          <?php echo $item['nomeProduto']; ?>
        </div>
        <div class="col">
          <?php echo $item['ingredientes']; ?>
        </div>
        <div class="col">
          <?php echo $item['preco']. " x ".$item['quantidade']; ?>
        </div>
        <div class="col">
          <a href="?remove=<?php echo $item['id']; ?>">Excluir um<i class="fas fa-trash-alt" style="color: red;"></i></a><br>
          <a href="?removeAll=<?php echo $item['id']; ?>">Excluir do carrinho<i class="fas fa-trash-alt" style="color: red;"></i></a><br>
        </div>
      </div>
  <?php 
      $total_pagar += $item['quantidade']*$item['preco'];
      $total_quantidade += $item['quantidade'];
    }
      }else{
        echo "<p>Seu carrinho está vazio!</p>";
      } 
  ?>

  <hr>
  <div class="row g-0">
    <div class="col" style="text-align: right; margin-right: 10px;">
      <b>Total</b>
    </div>
    <div class="col col-lg-2" style="text-align: center;">
      <b><?php echo $total_quantidade; ?></b>
    </div>
    <div class="col col-lg-2" style="text-align: center;">
      <?php $_SESSION['total_pagar'] = $total_pagar; ?>
      <b>R$<?php echo Painel::convertMoney($total_pagar); ?></b>
    </div>
  </div>

  <div class="row p-5" style="text-align: right;">
    <div class="row">
      <div class="col-8"></div>
      <?php 
          $hora = date("H:i:s");  
          if($info_site['horaInicio'] > $hora && $hora < $info_site['horaTermino']){
          ?>
          <div class="col-4"><button type="button" class="btn btn-secondary" disabled>Seu pedido não pode ser finalizado por conta de que estamos fechados no momento</button></div>
          <?php }else{ ?>
          <div class="col-4"><a class="btn btn-warning" href="<?php echo INCLUDE_PATH_USER ?>finalizar">Informar dados de Pagamento e Envio</a></div>
            <?php } ?>
    </div>
  </div>
</div>
