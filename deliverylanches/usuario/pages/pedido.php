<?php  

    if (isset($_GET['id'])) {
      $id = (int)$_GET['id'];
      $pedido = Painel::select('tb_site.pedidos','id = ?',array($id));
      $cliente = Painel::select('tb_admin.usuarios','id = ?',array($pedido['id_user']));
    }else{
      Painel::alert('erro', 'Pedido não encontrado.');
      die();
    }


    if (isset($_POST['enviar_comprovante'])) {
      $comprovante = $_FILES['comprovante'];
      $comprovante = Painel::uploadFileComprovante($comprovante);

      $insert_comprovante = MySql::conectar()->prepare("UPDATE `tb_site.pedidos` SET comprovante = ? WHERE id = ?");
      $insert_comprovante->execute(array($comprovante,$pedido['id']));

      echo "<script>window.location=".INCLUDE_PATH_USER."pedido?id=".$pedido['id']."</script>";
    }
?>

<div class="container p-3" style="text-align: center;">
  <h2>Pedido <?php echo $pedido['id']; ?> - Cliente <?php echo $cliente['nome']; ?></h2>
</div>

<div class="container">
  <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Lanche</span>
          <!-- <span class="badge bg-primary rounded-pill">3</span>
 -->        </h4>
        <ul class="list-group mb-3">
          <?php  
          $items_pedido = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos_pedido` WHERE id_pedido = ?");
          $items_pedido->execute(array($pedido['id']));
          $items_pedido = $items_pedido->fetchAll();

          $total = 0;

          foreach ($items_pedido as $key => $item) {
            $total += $item['produto_preco'];
          ?>
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0"><?php echo $item['produto_nome']; ?></h6>
                <small class="text-muted"><?php echo $item['ingredientes']; ?></small>
              </div>
              <span class="text-muted">R$<?php echo Painel::convertMoney($item['produto_preco']); ?></span>
            </li>
          <?php } ?>
        </ul>
      </div>

      <div class="col-md-7 col-lg-8" style="margin-bottom: 20px;">
        <form>
        <?php //if ($pedido['entrega'] == "sim") { ?>
        <h4 class="mb-3"><?php echo $pedido['data']." - ".$pedido['hora']; ?>
         <?php if ($pedido['status'] != "entregue"): ?>
           <span style="color: blue;">- Tempo Estimado : <?php echo $pedido['tempo_estimado']; ?> minutos</span></h4>
         <?php endif ?>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="rua" class="form-label">Rua</label>
              <input type="text" class="form-control" id="rua" value="<?php echo $pedido['rua']; ?>" disabled>
            </div>

            <div class="col-sm-6">
              <label for="numero" class="form-label">Número da casa</label>
              <input type="text" class="form-control" id="numero" value="<?php echo $pedido['numero_casa']; ?>" disabled>
            </div>

            <div class="col-sm-6">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" class="form-control" id="bairro" value="<?php echo $pedido['bairro']; ?>" disabled>
            </div>

            <div class="col-sm-6">
              <label for="complemento" class="form-label">Complemento</label>
              <input type="text" class="form-control" id="complemento" value="<?php echo $pedido['complemento']; ?>" disabled>
            </div>

            <div class="col-sm-4">
              <label for="metodo_pagamento" class="form-label">Metodo de pagamento</label>
              <input type="text" class="form-control" id="metodo_pagamento" value="<?php echo strtoupper($pedido['pagamento']) ?>" disabled>
            </div>

            <div class="col-sm-4">
              <label for="total_pedido" class="form-label">Valor total (R$)</label>
              <div class="input-group mb-3">
                <span class="input-group-text">R$</span>
                <input type="text" class="form-control" id="total_pedido" value="<?php echo $pedido['total_pedido']; ?>" disabled>
            </div>
            </div>

            <div class="col-sm-4">
              <label for="troco" class="form-label">Troco para... (R$)</label>
              <div class="input-group mb-3">
                <span class="input-group-text">R$</span>
                <input type="text" class="form-control" id="troco" value="<?php echo $pedido['troco']; ?>" disabled>
            </div>
            </div>

            <div class="col-sm-4">
              <label for="troco" class="form-label">Valor de entrega (R$)</label>
              <div class="input-group mb-3">
                <span class="input-group-text">R$</span>
                <input type="text" class="form-control" id="troco" value="<?php echo $pedido['total_pedido'] - $total; ?>" disabled>
            </div>
            </div>
          </div>

          <?php // } ?>

          <h4 class="mb-3">Status do pedido - <span style="color: green;"><?php echo $pedido['status']; ?></span></h4>

          <?php

          if (!empty($pedido['comprovante'])) {
            ?>
              <div class="row p-2">
                <div class="col-md-8">
                  <h4>Comprovante de pagamento</h4>
                  <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/comprovantes/<?php echo $pedido['comprovante']; ?>" style="width: 200px;">
                </div>
              </div>
            <?php
          }
          ?>

          <hr class="my-4">
      </div>
    </form>
    </div>

    <?php  
          if ($pedido['pagamento'] == "pix" && empty($pedido['comprovante'])) {
          ?> 
          <form method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-10">
                <p style="color: red;">O comprovante de pagamento ainda não foi enviado.</p>
                <label class="form-label">Envie-nos o comprovante para que seja realizado o envio do seu pedido. Obrigado</label>
                <input type="file" name="comprovante" class="form-control">
              </div>

              <div class="col-md-8 p-2">
                <input type="submit" name="enviar_comprovante" value="Enviar Comprovante" class="btn btn-success">
              </div>
            </div>
          </form>
          <?php
          }
          ?>
</div>