<?php  

	if (isset($_GET['deleta'])) {
	    $id = $_GET['deleta'];
	    $table = "tb_admin.faturamento";
	    $deleta = Painel::deletar($table,$id);
	    echo "<script>window.location='".INCLUDE_PATH_PAINEL."financeiro'</script>";
	  }
?>
<div class="box-content">
	<h2><i class="fas fa-chart-line"></i> Seu Histórico de Faturamentos</h2>
</div>
<div class="clear"></div>

<div class="box-content">
	<h2>Faturamento dos ultimos 30 dias</h2>
	<?php  
		$total_trintadias = 0;
		foreach (Painel::getFaturamentoTrintaDias() as $key => $trintadias) {
			$total_trintadias += $trintadias['total_pedido'];
		}
		echo "<p style='font-size: 25px; margin-top: 10px;'>R$".Painel::convertMoney($total_trintadias)."</p>";
	?>
</div>

<div class="clear"></div>
<div class="box-content">
	<h2>Cadastrar faturamento do mês</h2>
	<form method="post">
		<div class="form-group">
			<label>Mês</label>
			<select name="mes">
				<option value="01">Janeiro</option>
				<option value="02">Fevereiro</option>
				<option value="03">Março</option>
				<option value="04">Abril</option>
				<option value="05">Maio</option>
				<option value="06">Junho</option>
				<option value="07">Julho</option>
				<option value="08">Agosto</option>
				<option value="09">Setembro</option>
				<option value="10">Outubro</option>
				<option value="11">Novembro</option>
				<option value="12">Dezembro</option>
			</select>
		</div>

		<div class="ano">
			<label>Ano</label>
			<input type="text" name="ano">
		</div>

		<div class="form-group">
			<input type="submit" name="enviar" value="Ver faturamento" style="width: 100%">
		</div>
	</form>

	<?php  

	if (isset($_POST['enviar'])) {

			$mes = $_POST['mes'];
			$ano = $_POST['ano'];

			$total_despesas = 0;
			// $total = 0;
			// $total_dinheiro = 0;
			// $faturamento_debito = 0;
			// $faturamento_credito = 0;
			
			$despesas = MySql::conectar()->prepare("SELECT SUM(valor) FROM `tb_site.compras_estoque` WHERE MONTH(data) = $mes AND YEAR(data) = $ano");
			$despesas->execute();
			$despesas = $despesas->fetch();
			
			$total_despesas = $despesas['SUM(valor)'];
			

			$total_faturado = MySql::conectar()->prepare("SELECT SUM(total_pedido) FROM `tb_site.pedidos` WHERE status = 'entregue' AND MONTH(data) = $mes AND YEAR(data) = $ano");
			$total_faturado->execute();
			$total_faturado = $total_faturado->fetch();

			$faturamento_dinheiro = MySql::conectar()->prepare("SELECT SUM(total_pedido) FROM `tb_site.pedidos` WHERE status = 'entregue' AND MONTH(data) = $mes AND YEAR(data) = $ano AND pagamento = 'dinheiro' OR pagamento = 'pix'");
			$faturamento_dinheiro->execute();
			$faturamento_dinheiro = $faturamento_dinheiro->fetch();

			$faturamento_debito = MySql::conectar()->prepare("SELECT SUM(total_pedido) FROM `tb_site.pedidos` WHERE status = 'entregue' AND pagamento = 'cartao de debito' AND MONTH(data) = $mes AND YEAR(data) = $ano");
			$faturamento_debito->execute();
			$faturamento_debito = $faturamento_debito->fetch();

			$faturamento_credito = MySql::conectar()->prepare("SELECT SUM(total_pedido) FROM `tb_site.pedidos` WHERE status = 'entregue' AND pagamento = 'cartao de credito' AND MONTH(data) = $mes AND YEAR(data) = $ano");
			$faturamento_credito->execute();
			$faturamento_credito = $faturamento_credito->fetch();

			// $total = $total_faturado['SUM(total_pedido)'];
			// $total_dinheiro = $faturamento_dinheiro['SUM(total_pedido)'];
			// $total_debito = $faturamento_debito['SUM(total_pedido)'];
			// $total_credito = $faturamento_credito['SUM(total_pedido)'];
			
			 $faturamentoIgual = MySql::conectar()->prepare("SELECT * FROM `tb_admin.faturamento` WHERE mes = $mes AND ano = $ano");
			 $faturamentoIgual->execute();
			 $faturamentoIgual = $faturamentoIgual->rowCount();
			 

			 if ($faturamentoIgual > 0) {
			 	$update = MySql::conectar()->prepare("UPDATE `tb_admin.faturamento` SET valor_faturado = ?, total_dinheiro = ?, 
				 total_debito = ?, total_credito = ?, despesas = ? WHERE mes = $mes AND ano = $ano");
			 	if($update->execute(array($total_faturado['SUM(total_pedido)'],$faturamento_dinheiro['SUM(total_pedido)'],$faturamento_debito['SUM(total_pedido)'],$faturamento_credito['SUM(total_pedido)'],$total_despesas))){
					
				 }
			
			 }else{
			 	$insert = MySql::conectar()->prepare("INSERT INTO `tb_admin.faturamento` VALUES (null,?,?,?,?,?,?,?)");
				if($insert->execute(array($mes,$ano,$total_faturado['SUM(total_pedido)'],$faturamento_dinheiro['SUM(total_pedido)'],$faturamento_debito['SUM(total_pedido)'],$faturamento_credito['SUM(total_pedido)'],$total_despesas))){	
					
				}
			}

	}
?>

</div>

<div class="clear"></div>

<div class="box-content">
	<h2>Faturamentos</h2>

	<div class="table-responsive">
		<table class="table w50 table-hover">
			<thead>
			<tr>
			    <td></td>
				<td style="width: 100px;">ANO</td>
				<td style="width: 100px;">MÊS</td>
				<td style="width: 100px;">Total faturado</td>
				<td style="width: 100px;">Vendas no dinheiro</td>
				<td style="width: 100px;">Vendas no cartão de débito</td>
				<td style="width: 100px;">Vendas no cartão de crédito</td>
				<td style="width: 100px;">Despesas de estoque</td>
                <td style="width: 100px;">Total pago de frete</td>
				<td style="width: 100px;">Lucro Líquido</td>
				<td style="width: 80px;"></td>
			</tr>
			</thead>
			<tbody>
			<?php 
                         
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.faturamento`");
				$sql->execute();
				$sql = $sql->fetchAll();
                                $ano = "";
                                $num_mes = "";
				foreach ($sql as $key => $faturamento) {
				    
				    $ano = $faturamento['ano'];
				    $num_mes = $faturamento['mes'];
				    
				    	switch ($faturamento['mes']) {
								case '01':
									$mes = "Janeiro";
									break;
								
								case '02':
									$mes = "Fevereiro";
									break;

								case '03':
									$mes = "Março";
									break;

								case '04':
									$mes = "Abril";
									break;

								case '05':
									$mes = "Maio";
									break;

								case '06':
									$mes = "Junho";
									break;

								case '07':
									$mes = "Julho";
									break;

								case '08':
									$mes = "Agosto";
									break;

								case '09':
									$mes = "Setembro";
									break;

								case '10':
									$mes = "Outubro";
									break;

								case '11':
									$mes = "Novembro";
									break;

								case '12':
									$mes = "Dezembro";
									break;
							}
					?>

					<tr>
					    <td>
						   <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $mes.$ano; ?>">
                              Ver
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="<?php echo $mes.$ano; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Faturamento do mês de <span style="color: blue;"><?php echo $mes; ?></span> do ano de <span style="color: blue;"><?php echo $ano; ?></span></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <h2 class=""><i class="	fa fa-edit"></i> Histórico de compras </h2>
                                    <div class="container">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table">
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Data</th>
                                                        <th>Valor pago</th>
                                                        <th>Quantidade comprada</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php 
                                                    
                                                    $compras_estoque = MySql::conectar()->prepare("SELECT * FROM `tb_site.compras_estoque` WHERE MONTH(data) = $num_mes AND YEAR(data) = $ano");
                                        			$compras_estoque->execute();
                                        			$compras_estoque = $compras_estoque->fetchAll();
                                                    foreach($compras_estoque as $key => $compra_estoque){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $compra_estoque['produto']; ?></td>
                                                            <td><?php echo $compra_estoque['data']; ?></td>
                                                            <td>R$ <?php echo Painel::convertMoney($compra_estoque['valor']); ?></td>
                                                            <td><?php echo $compra_estoque['quantidade']; ?> unidades</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="clear"></div>
                                    
                                    <h2 class=""><i class="	fa fa-edit"></i> Histórico de pedidos </h2>
                                    <div class="container">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table">
                                                    <tr>
                                                        <th>Pedido</th>
                                                        <th>Cliente</th>
                                                        <th>Data - Hora</th>
                                                        <th>Valor do pedido</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php 
                                                    $hist_pedidos = MySql::conectar()->prepare("SELECT * FROM `tb_site.pedidos` WHERE MONTH(data) = $num_mes AND YEAR(data) = $ano");
                                                    $hist_pedidos->execute();
                                                    $hist_pedidos = $hist_pedidos->fetchAll();
                                                    foreach($hist_pedidos as $key => $pedido){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $pedido['id']; ?></td>
                                                            <td><?php echo $pedido['nome_cliente']; ?></td>
                                                            <td><?php echo $pedido['data']." - ".$pedido['hora']; ?></td>
                                                            <td>R$<?php echo Painel::convertMoney($pedido['total_pedido']); ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="clear"></div>
                                    
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
						</td>
						<td><?php echo $ano; ?></td>
						<?php  
                        $totalfrete = MySql::conectar()->prepare("SELECT SUM(valor_entrega) FROM `tb_site.pedidos` WHERE status = 'entregue' AND entrega = 'sim' AND MONTH(data) = $num_mes AND YEAR(data) = $ano");
                        $totalfrete->execute();
                        $totalfrete = $totalfrete->fetch();
						
                        $lucro_liquido = 0;
						$lucro_liquido = $faturamento['valor_faturado'] - $faturamento['despesas'] - $totalfrete['SUM(valor_entrega)'];
						?>
						<td><?php echo $mes; ?></td>
						<td>R$<?php echo Painel::convertMoney($faturamento['valor_faturado']); ?></td>
						<td>R$<?php echo Painel::convertMoney($faturamento['total_dinheiro']); ?></td>
						<td>R$<?php echo Painel::convertMoney($faturamento['total_debito']); ?></td>
						<td>R$<?php echo Painel::convertMoney($faturamento['total_credito']); ?></td>
						<td>R$<?php echo Painel::convertMoney($faturamento['despesas']); ?></td>
                        <td>R$<?php echo Painel::convertMoney($totalfrete['SUM(valor_entrega)']); ?></td>
						<td>R$<?php echo Painel::convertMoney($lucro_liquido); ?></td>
						<td>
							<a href="?deleta=<?php echo $faturamento['id']; ?>" style="color:red;">Deletar</a>
						</td>
					</tr>

					<?php
				}

			?>
			</tbody>
		</table>	
	</div>
</div>