<?php  
	if (isset($_GET['deleta'])) {
		$id = $_GET['deleta'];
		$pedidos = "tb_site.pedidos";
		$itens_pedido = "tb_site.produtos_pedido";
		$deleta = Painel::deletar($pedidos,$id);
		$deleta_itens_pedido = MySql::conectar()->prepare("DELETE FROM `tb_site.produtos_pedido` WHERE id_pedido = $id");
		$deleta_itens_pedido->execute();
		echo "<script>window.location='".INCLUDE_PATH_PAINEL."novos-pedidos'</script>";
	}
?>
<div class="box-content">
	<h2><i class="fa fa-folder-open"></i> Novos Pedidos</h2>
</div>

<div class="clear"></div>

<div class="box-content">
	<div class="btn-group dropright">
	  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Pedidos
	  </button>
	  <div class="dropdown-menu" style="border:none;">
	    <a href="<?php echo INCLUDE_PATH_PAINEL ?>pedidos-enviados" class="dropdown-item">Ver pedidos que foram enviados</a>
	    <a href="<?php echo INCLUDE_PATH_PAINEL ?>pedidos-enviados" class="dropdown-item">Ver pedidos que foram entregues</a>
	  </div>
	</div>
</div>

<div class="clear"></div>

<div class="box-content">
	<div class="table-resposive">
		<table class="table table-hover">
			<thead>
			<tr>
				<th></th>
				<th>Pedido</th>
				<th>Cliente</th>
				<th>Data - Hora</th>
				<th>Status</th>
				<th></th>
				
			</tr>
			</thead>
			<tbody>
			<?php  
				$pedidos = MySql::conectar()->prepare("SELECT * FROM `tb_site.pedidos` WHERE status = 'realizado'");
				$pedidos->execute();
				$pedidos = $pedidos->fetchAll();
				foreach ($pedidos as $key => $pedido) {
				
			?>
			<tr style="text-align: center;">
			<td><a href="<?php echo INCLUDE_PATH_PAINEL ?>pedido-info?id=<?php echo $pedido['id']; ?>">Ver <i class="fa fa-caret-right"></i></a></td>
			<td><?php echo $pedido['id']; ?></td>
			<td><?php echo $pedido['nome_cliente']; ?></td>
			<td><?php echo $pedido['data']. " - ".$pedido['hora']; ?></td>
			<td style="color: green;"><?php echo $pedido['status']; ?></td>
			<td>
				<a style="color: red;" href="<?php echo INCLUDE_PATH_PAINEL ?>novos-pedidos?deleta=<?php echo $pedido['id']; ?>">Excluir pedido <i class="fas fa-trash-alt" style="color: red;"></i></a>
			</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>