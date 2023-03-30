<?php  
	if (isset($_GET['cancelar'])) {
		$id = $_GET['cancelar'];
		$deletaPedido = MySql::conectar()->prepare("DELETE FROM `tb_site.pedidos` WHERE id = '$id'");
		$deletaPedido->execute();

		$deletaItensPedido = MySql::conectar()->prepare("DELETE FROM `tb_site.produtos_pedido` WHERE id_pedido = '$id'");
		$deletaItensPedido->execute();
		echo "<script>window.location='".INCLUDE_PATH_USER."pedidos'</script>";
	}
?>

<hr style="background: transparent;">
<hr style="background: transparent;">


<div class="container p-4 t-4" style="">
	<h5><i class="fa fa-folder-open"></i> Seus Pedidos Realizados, que ainda não foram enviados</h5>
	<p class="p-2" style="color: red;">Você só poderá cancelar esses pedidos que ainda não foram processados</p>
</div>

<div class="container">
	<div class="table-responsive ">
	  <table class="table table-bordered table-hover">
	    <thead class="table-info">
	    	<th>Cliente</th>
	    	<th>Data</th>
	    	<th>Horário</th>
	    	<th>Tempo estimado</th>
	    	<th colspan="2" style="text-align: center;">Ações</th>
	    </thead>

	    <tbody>
	    	<?php  
	    	$pedidos = MySql::conectar()->prepare("SELECT * FROM `tb_site.pedidos` WHERE status = 'realizado' AND id_user = ? ORDER BY data DESC");
	    	$pedidos->execute(array($_SESSION['id']));
	    	$pedidos = $pedidos->fetchAll();

	    	foreach ($pedidos as $key => $pedido) {
	    	?>
	    		<tr>
	    			<td><?php echo $pedido['nome_cliente']; ?></td>
	    			<td><?php echo $pedido['data']; ?></td>
	    			<td><?php echo $pedido['hora']; ?></td>
	    			<td><?php echo $pedido['tempo_estimado']; ?></td>
	    			<td><a href="<?php echo INCLUDE_PATH_USER ?>pedido?id=<?php echo $pedido['id']; ?>">Ver</a></td>
	    			<td><a href="?cancelar=<?php echo $pedido['id']; ?>">Cancelar</a></td>
	    		</tr>
	    	<?php
	    	}
	    	?>
	    </tbody>
	  </table>
	</div>
</div>

<div class="clear"></div>

<div class="container p-4">
	<h5><i class="fa fa-folder-open"></i> Seus Pedidos Enviados</h5>
</div>

<div class="clear"></div>

<div class="container">
	<div class="table-responsive ">
	  <table class="table table-bordered table-hover">
	    <thead class="table-secondary">
	    	<th>Cliente</th>
	    	<th>Data</th>
	    	<th>Horário</th>
	    	<th>Ações</th>
	    </thead>

	    <tbody>
	    	<?php  
	    	$pedidos = MySql::conectar()->prepare("SELECT * FROM `tb_site.pedidos` WHERE status = 'enviado' AND id_user = ? ORDER BY data DESC");
	    	$pedidos->execute(array($_SESSION['id']));
	    	$pedidos = $pedidos->fetchAll();

	    	foreach ($pedidos as $key => $pedido) {
	    	?>
	    		<tr>
	    			<td><?php echo $pedido['nome_cliente']; ?></td>
	    			<td><?php echo $pedido['data']; ?></td>
	    			<td><?php echo $pedido['hora']; ?></td>
	    			<td><a href="<?php echo INCLUDE_PATH_USER ?>pedido?id=<?php echo $pedido['id']; ?>">Ver</a></td>
	    		</tr>
	    	<?php
	    	}
	    	?>
	    </tbody>
	  </table>
	</div>
</div>

<div class="clear"></div>

<div class="container p-4">
	<h5><i class="fa fa-folder-open"></i> Seus Pedidos Entregues</h5>
</div>

<div class="clear"></div>

<div class="container ">
	<div class="table-responsive ">
	  <table class="table table-bordered table-hover">
	    <thead class="table-secondary">
	    	<th>Cliente</th>
	    	<th>Data</th>
	    	<th>Horário</th>
	    	<th>Ações</th>
	    </thead>

	    <tbody>
	    	<?php  
	    	$pedidos = MySql::conectar()->prepare("SELECT * FROM `tb_site.pedidos` WHERE status = 'entregue' AND id_user = ?");
	    	$pedidos->execute(array($_SESSION['id']));
	    	$pedidos = $pedidos->fetchAll();

	    	foreach ($pedidos as $key => $pedido) {
	    	?>
	    		<tr>
	    			<td><?php echo $pedido['nome_cliente']; ?></td>
	    			<td><?php echo $pedido['data']; ?></td>
	    			<td><?php echo $pedido['hora']; ?></td>
	    			<td><a href="<?php echo INCLUDE_PATH_USER ?>pedido?id=<?php echo $pedido['id']; ?>">Ver</a></td>
	    		</tr>
	    	<?php
	    	}
	    	?>
	    </tbody>
	  </table>
	</div>
</div>

<hr style="background: transparent;">
<hr style="background: transparent;">
