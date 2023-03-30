<?php  
		
		if (isset($_GET['deleta'])) {
			$id = $_GET['deleta'];
			$table = "tb_site.pedidos";
			$deleta = Painel::deletar($table,$id);
			echo "<script>window.location='".INCLUDE_PATH_PAINEL."pedidos-finalizados'</script>";
		}

		if (isset($_GET['id'])) {
			$id = (int)$_GET['id'];
			if($pedido = Painel::select('tb_site.pedidos','id = ?',array($id))){
				$cliente = Painel::select('tb_admin.usuarios','id = ?',array($pedido['id_user']));
			}else{
				Painel::alert('erro', 'Pedido não encontrado.');
			die();
			}
			
		}else{
			Painel::alert('erro', 'Pedido não encontrado.');
			die();
		}

		if (isset($_GET['confirmar_enviado'])) {
			$status = $_GET['confirmar_enviado'];
			$confirmar = MySql::conectar()->prepare("UPDATE `tb_site.pedidos` SET status = ? WHERE id = ?");
			$confirmar->execute(array($status,$pedido['id']));
			echo '<script>window.location="'.INCLUDE_PATH_PAINEL.'pedido-info?id='.$pedido['id'].'"</script>';
		}

?>



<div class="container p-3" style="text-align: center;">
	<h2>Pedido <?php echo $pedido['id']; ?> - Cliente <?php echo $cliente['nome']; ?></h2>
</div>

<div class="container">
	<div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Lanches</span>
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
        <h4 class="mb-3"><?php echo $pedido['data']." - ".$pedido['hora']." - ";  if ($pedido['entrega'] == "sim") {echo "Entregar";}else{echo "O cliente irá buscar";} ?></h4>
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


          <hr class="my-4">

          <div class="container">
	  <?php  

	    if ($pedido['pagamento'] == "pix") {
	    	if (!empty($pedido['comprovante'])) {
		      echo "O cliente enviou o comprovante de pagamento.";
		      echo "<br>";
		      echo "<img src='".INCLUDE_PATH_PAINEL."uploads/".$pedido['comprovante']."' style='width: 300px; height: 300px;'>";
		    }else{
		      echo "O cliente ainda não enviou o comprovante de pagamento";
		    }
	    }
	  ?>
	</div>

	<div class="container p-3">
	  <?php if ($pedido['status'] == "entregue"){ ?>
	    <span style="color: green;">Pedido entregue</span>
	  <?php }else{ ?>
		<?php 
		if($pedido['entrega'] == "sim"){
	?>
	  <?php if ($pedido['status'] == "realizado"): ?>
	    <a class="btn btn-primary" href="<?php echo INCLUDE_PATH_PAINEL ?>pedido-info?id=<?php echo $pedido['id']; ?>&&confirmar_enviado=enviado">Marcar pedido como enviado</a>
	  <?php endif ?>

	  <?php if ($pedido['status'] == "enviado"): ?>
	    <a class="btn btn-primary" href="<?php echo INCLUDE_PATH_PAINEL ?>pedido-info?id=<?php echo $pedido['id']; ?>&&confirmar_enviado=entregue">Marcar pedido como entregue</a>
	  <?php endif ?>
	<?php }else if($pedido['entrega'] == "nao"){
		?>
		<a class="btn btn-primary" href="<?php echo INCLUDE_PATH_PAINEL ?>pedido-info?id=<?php echo $pedido['id']; ?>&&confirmar_enviado=entregue">Marcar pedido como entregue</a>
		<?php
	} } ?>
	  <br>
	  <a style="color: red;" href="<?php echo INCLUDE_PATH_PAINEL ?>pedido-info?deleta=<?php echo $pedido['id']; ?>">Excluir pedido <i class="fas fa-trash-alt" style="color: red;"></i></a>
	</div>

        </form>
      </div>
    </div>
</div>