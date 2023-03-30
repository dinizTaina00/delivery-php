

<?php  
	$info_site = Site::sqlInfoSite();
?>
<div class="box-content">
	<h3 class="p-3 fw-bold">Finalizando pedido</h3>
</div>

<hr>

<div class="container">
	<form method="post" enctype="multipart/form-data">
	<div class="row align-items-md-stretch">
      <div class="col-md-6">
        <div class="h-100 p-5 bg-light rounded-3">
          <h2>Endereço de destino</h2>
          
          	<div class="row">

          		<div class="col-md-12 p-2">
          			<div class="col-md-12">
          				<label class="form-label">Número para contato</label>
          				<input class="form-control" type="text" name="contato" value="<?php echo $_SESSION['contato']; ?>" disabled>
          			</div>
          		</div>

          		<div class="col-md-12 p-2">
          			<div class="col-md-12">
          				<label class="form-check-label">Deseja que o pedido seja entregue?</label><br><br>
          				<label clasa="form-check-label p-3" style="color: green;">Valor de entrega = R$<?php echo Painel::convertMoney($info_site['valor_entrega']); ?></label><br><br>
	          			Sim, quero <input class="form-check-input" type="radio" name="entregar" value="sim" class="form-control" required>  	
	          			Não, irei buscar <input class="form-check-input" type="radio" name="entregar" value="nao" class="form-control" required>
          			</div>
          		</div>

          		<div class="col-md-6 p-2">
          			<label class="form-label">Rua</label>
          			<input type="text" name="rua" value="<?php echo $_SESSION['rua_cliente']; ?>" class="form-control">
          		</div>

          		<div class="col-md-6 p-2">
          			<label class="form-label">Número</label>
          			<input type="text" name="numero" value="<?php echo $_SESSION['numero_casa_cliente']; ?>" class="form-control">
          		</div>

          		<div class="col-md-6 p-2">
          			<label class="form-label">Bairro</label>
          			<input type="text" name="bairro" value="<?php echo $_SESSION['bairro_cliente']; ?>" class="form-control">
          		</div>

          		<div class="col-md-6 p-2">
          			<label class="form-label">Complemento</label>
          			<input type="text" name="complemento" value="<?php echo $_SESSION['complemento_cliente']; ?>" class="form-control">
          		</div>

          		<div class="col-md-9 p2">
          			<label class="form-check-label">Deseja salvar esse endereço para os próximos pedidos?</label>
          			Sim <input type="radio" name="salvar_endereco" value="sim" class="form-check-input">
          			Não <input type="radio" name="salvar_endereco" value="nao" class="form-check-input">
          		</div>
          	</div>

        </div>
      </div>
      <div class="col-md-6">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2>Método de pagamento</h2>
          <div class="row">
          	<div class="col-md-12 p-3">
          		<blockquote class="blockquote">
          			<p style>Total à pagar: R$<?php echo Painel::convertMoney($_SESSION['total_pagar']); ?></p>
          		</blockquote>
          	</div>

          	<div class="accordion accordion-flush" id="accordionFlushExample">

          	<?php  
          	$sql_metodos = MySql::conectar()->prepare("SELECT * FROM  `tb_admin.metodos_pagamento` WHERE status = 1");
          	$sql_metodos->execute();
          	$sql_metodos = $sql_metodos->fetchAll();

          	foreach ($sql_metodos as $key => $metodo) {
          	?>

          	<div class="accordion-item">
          		<div class="form-check">
          			<label class="" for="default<?php echo $metodo['id']; ?>" id="flush-heading<?php echo $metodo['id']; ?>">
				    <?php echo $metodo['metodo_pagamento']; ?>
						<input class="p-2 m-2 accordion collapsed" name="metodo_pagamento" id="default<?php echo $metodo['id']; ?>" type="radio" data-bs-toggle="collapse" data-bs-target="#flush-<?php echo $metodo['id']; ?>" aria-expanded="false" value="<?php echo $metodo['metodo_pagamento']; ?>" aria-controls="flush-<?php echo $metodo['id']; ?>">
				  
				  </label>
				</div>

			    <div id="flush-<?php echo $metodo['id']; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $metodo['id']; ?>" data-bs-parent="#accordionFlushExample">

				<?php if($metodo['metodo_pagamento'] == "pix"){ ?>
	          			<div class="accordion-body">
					      	<p><?php echo strtoupper($metodo['banco']); ?></p>
		          			<div class="col-md-12 p-2">
			          			<label class="form-label">Beneficiário</label>
			          			<input type="text" class="form-control" value="<?php echo $metodo['beneficiario']; ?>" disabled="">
			          		</div>

			          		<div class="col-md-12 p-2">
			          			<label class="form-label">Chave Pix</label>
			          			<input type="text" class="form-control" value="<?php echo $metodo['chave_pix']; ?>" disabled="">
			          		</div>

			          		<div class="col-md-12 p2">
			          			<p class="p-2 m-2" style="color: red;">O pedido será enviado após a confirmação de pagamento</p>
			          			<label class="form-label">Envie o comprovante de pagamento</label>
			          			<input type="file" name="comprovante" class="form-control">
			          		</div>
			          		<p class="p-2 m-2" style="color: red;">Caso não consiga enviar o comprovante agora, após confirmar o pedido, vá em Meus Pedidos, clique no pedido e va em enviar comprovante.</p>
							<p class="p-2 m-2" style="color: red;">Ou nos envie o comprovante via Whatsapp junto com o seu Nome e Número do seu Pedido após finalizar o pedido.</p>
			          	</div>
			    <?php }elseif ($metodo['metodo_pagamento'] == "dinheiro") { ?>
			    		
			    		<div class="accordion-body">
		          			<p>Dinheiro</p>
		          			<div class="col-md-12 p-2">
		          				<label class="form-label">Troco para quanto? <span class="text-muted">(Deixe vazio caso não preciso de troco)</span></label>
		          				<div class="input-group mb-3">
				          			<span class="input-group-text">R$</span>
				          			<input type="text" name="troco" class="form-control" value="<?php echo $metodo['beneficiario']; ?>">
				          		</div>
			          		</div>
			          	</div>
			    <?php } elseif ($metodo['metodo_pagamento'] == "cartao de credito" || $metodo['metodo_pagamento'] == "cartao de debito") { ?>
			    		
			    		<div class="accordion-body">
		          			<p><?php echo strtoupper($metodo['metodo_pagamento']); ?></p>
	          				<p>O pagamento com cartão será efetuado na entrega do pedido.</p>
	      				</div>
			    <?php } ?>

		
				    </div>
				</div>

			<?php } ?>   	
		  </div>
        </div>
      </div>
    </div>
    <p class="p-2 m-3"><input type="submit" name="finaliza" value="Finalizar Pedido" class="btn btn-warning" style="width: 50%;"></p>
	</form>
</div>

<hr>

<div class="box-content">
	<?php  
	if (isset($_POST['finaliza'])) {
		if (isset($_SESSION['carrinho'])) {
			if (!empty($_SESSION['carrinho'])) {
				$entregar = $_POST['entregar'];
				$metodo_pagamento = $_POST['metodo_pagamento'];
				if ($entregar == "sim") {
					$rua = $_POST['rua'];
					$numero = $_POST['numero'];
					$bairro = $_POST['bairro'];
					if(empty($_POST['complemento'])){
						$complemento = "";
					}else{
						$complemento = $_POST['complemento'];
					}
					$valor_entrega = $info_site['valor_entrega'];
					
					$total_pagar = $_SESSION['total_pagar'] + $info_site['valor_entrega'];
				}
				if ($entregar == "nao") {
					$rua = "";
					$numero = "";
					$bairro = "";
					$complemento = "";
					$valor_entrega = 0;

					$total_pagar = $_SESSION['total_pagar'];
				}

				if (isset($_POST['salvar_endereco'])) {
				    if($_POST['salvar_endereco'] == "sim"){
					$_SESSION['rua_cliente'] = $rua;
					$_SESSION['numero_casa_cliente'] = $numero;
					$_SESSION['bairro_cliente'] = $bairro;
					$_SESSION['complemento_cliente'] = $complemento;
					
					$salva_endereco = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET rua = '$rua', numero = '$numero', bairro = '$bairro', complemento = '$complemento' WHERE id = ?");
					$salva_endereco->execute(array($_SESSION['id']));
					}
				}

				if (empty($_POST['troco'])) {
					$troco = 0;
				}else{
					if ($metodo_pagamento == "dinheiro") {
						if ($_POST['troco'] < $_SESSION['total_pagar']) {
							echo "<script>alert('O troco que você informou é menor que o valor total do pedido!');</script>";
							die();
						}else{
							$troco = $_POST['troco'];
						}
					}
				}

				$data = date("Y-m-d");
				$horario = date("H:i:s");
				$id_user = $_SESSION['id'];
				
				if ($_FILES['comprovante']['error'] == 4) {
					$comprovante = "";
				}else{
					$comprovante = $_FILES['comprovante'];
				}

				$countCarriho = count($_SESSION['carrinho']);
				$tempo_estimado = 0;
				foreach ($_SESSION['carrinho'] as $value) {
			            $tempo_estimado += $value['tempo'];
				}
                                
                                
                                if($countCarriho > 1){
                                  $tempo_estimado = ($tempo_estimado/$countCarriho) + 10;
                                  //echo $tempo_estimado;
                                }else{
                                  $tempo_estimado = $tempo_estimado + 10;
                                  //echo $tempo_estimado;
                                }
                
				$insert_pedido = MySql::conectar()->prepare("INSERT INTO `tb_site.pedidos` VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert_pedido->execute(array($data,$horario,$id_user,$_SESSION['nome'],$entregar,$valor_entrega,$rua,$numero,$bairro,$complemento,$metodo_pagamento,$total_pagar,$troco,"realizado",$comprovante,$tempo_estimado));

				$pedido_id = MySql::conectar()->lastInsertId();

				foreach ($_SESSION['carrinho'] as $key => $item) {
					$insert_items = MySql::conectar()->prepare("INSERT INTO `tb_site.produtos_pedido` VALUES (NULL,?,?,?,?,?,?,?)");
					$insert_items->execute(array($pedido_id,$item['id'],$item['nomeProduto'],$item['categoriaProduto'],$item['preco'],$item['ingredientes'],$item['quantidade']));
				}
                
                require_once('MobizonApi.php');
				$api = new Mobizon\MobizonApi('brfb05fba88fabe11eed643beca9089e641a340b663680cbd732c01d3227742bd925e8', 'api.mobizon.com.br');

				$alphaname = '';
				if ($api->call('message',
				    'sendSMSMessage',
				    array(
				        'recipient' => "55".$info_site['contato'],
				        'text' => $_SESSION['nome_negocio']. " - " . " Você possui um novo pedido. Cliente - ".$_SESSION['nome'],
				        'from' => $alphaname,
				        //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
				    ))
				) {
				    $messageId = $api->getData('messageId');
				    echo 'Message created with ID:' . $messageId . PHP_EOL;

				    if ($messageId) {
				        echo 'Get message info...' . PHP_EOL;
				        $messageStatuses = $api->call(
				            'message',
				            'getSMSStatus',
				            array(
				                'ids' => array($messageId, 'BR-17723')
				            ),
				            array(),
				            true
				        );

				        if ($api->hasData()) {
				            foreach ($api->getData() as $messageInfo) {
				                echo 'Message # ' . $messageInfo->id . " status:\t" . $messageInfo->status . PHP_EOL;
				            }
				        }
				    }
				} else {
				    //echo 'An error occurred while sending message: [' . $api->getCode() . '] ' . $api->getMessage() . 'See details below:' . PHP_EOL;
				    //var_dump(array($api->getCode(), $api->getData(), $api->getMessage()));
				}
                                
				unset($_SESSION['carrinho']);

				echo '<script>window.location="'.INCLUDE_PATH_USER.'pedido?id='.$pedido_id.'"</script>';

			}else{
				echo "<script>alert('Seu carrinho está vazio');</script>";
			}
		}else{
			echo "<script>alert('Seu carrinho está vazio');</script>";
		}
	}
?>
</div>