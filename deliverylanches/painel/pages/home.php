	<?php  

	
	
		$total_pedido_seteDias = 0;
		$total_pedido_TrintaDias = 0;
		$total_pedidos_naoProcessados = 0;

		$getUsuarios = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE permissao = 0");
		$getUsuarios->execute();
		$getUsuarios = $getUsuarios->rowCount();

		$novosPedidos = Pedido::listarNovosPedidos();
                
                if(isset($_POST['id'])){
                        echo $_POST['id'];
                }
		
	?>

<div class="w100">

		<div class="box-metricas" >
			<div class="box-metrica-single">
				<a style="text-decoration: none;" href="<?php echo INCLUDE_PATH_PAINEL ?>novos-pedidos">
					<div class="box-metrica-wraper">
						<h2><i class="fa fa-folder-open" style="color: green;"></i> Novos Pedidos</h2>
						<p style="margin-top: 40px;"><?php echo count($novosPedidos); ?></p>
					</div></a>
			</div>
			<div class="box-metrica-single">
				<a style="text-decoration: none;" href="<?php echo INCLUDE_PATH_PAINEL ?>lista-usuarios">
					<div class="box-metrica-wraper">
						<h2><i class="fa fa-group" style="color: green;"></i> Usuários Cadastrados</h2>
						<p><?php echo $getUsuarios; ?></p>
					</div><!--box-metrica-wraper-->
				</a>
			</div><!--box-metrica-single-->

			<div class="box-metrica-single">
				<a style="text-decoration: none;" href="<?php echo INCLUDE_PATH_PAINEL ?>faturamento"><div class="box-metrica-wraper">
					<h2><i class="fa fa-money" style="color: green;"></i> Total em pedidos para processar</h2>
					<?php  
						foreach (Painel::getFaturamentoPedidosNaoProcessados() as $key => $value) {
							$total_pedidos_naoProcessados += $value['total_pedido'];
						}
					?>
					<p>R$<?php echo Painel::convertMoney($total_pedidos_naoProcessados); ?></p>
				</div></a>
			</div>
		</div><!--box-metricas-->
		<div class="clear"></div>
                
                 
</div><!--box-content-->

<div class="clear"></div>

<div class="w100">
	<!-- FATURAMENTO 7 DIAS -->
	<div class="box-metricas">
			<div class="box-metrica-single">
				<a style="text-decoration: none;" href="<?php echo INCLUDE_PATH_PAINEL ?>faturamento"><div class="box-metrica-wraper">
					<h2><i class="fa fa-money" style="color: green;"></i> Faturamento dos últimos 7 dias</h2>
					<?php  
						foreach (Painel::getFaturamentoSeteDias() as $key => $value) {
							$total_pedido_seteDias += $value['total_pedido'];
						}
					?>
					<p>R$<?php echo Painel::convertMoney($total_pedido_seteDias); ?></p>
				</div></a>
			</div>

			<div class="box-metrica-single">
				<a style="text-decoration: none;" href="<?php echo INCLUDE_PATH_PAINEL ?>faturamento"><div class="box-metrica-wraper">
					<h2><i class="fa fa-money" style="color: green;"></i> Faturamento dos últimos 30 dias</h2>
					<?php  
						foreach (Painel::getFaturamentoTrintaDias() as $key => $value) {
							$total_pedido_TrintaDias += $value['total_pedido'];
						}
					?>
					<p>R$<?php echo Painel::convertMoney($total_pedido_TrintaDias); ?></p>
				</div></a>
			</div>
	</div>
</div>

<div class="clear"></div>

