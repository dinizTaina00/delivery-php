<?php  
	if (isset($_POST['atualizar_pix'])) {
			$metodo_pagamento = $_POST['metodo_pagamento'];
			$beneficiario = $_POST['beneficiario'];
			$banco = $_POST['banco'];
			$chave_pix = $_POST['chave_pix'];
		 	$cpf = $_POST['cpf'];
		 	$conta = $_POST['conta'];
			$agencia = $_POST['agencia'];
			$tipo_conta = $_POST['tipo_conta'];
                        $id_dado = $_POST['id_dado'];

			$id = $_POST['id'];
			$update = MySql::conectar()->prepare("UPDATE `tb_admin.dados_pagamento` SET metodo_pagamento=?,beneficiario=?,cpf_beneficiario=?,banco=?,conta=?,agencia=?,tipo_conta=?,chave_pix=? WHERE id = ?");
			$update->execute(array($metodo_pagamento,$beneficiario,$cpf,$banco,$conta,$agencia,$tipo_conta,$chave_pix,$id_dado));
			echo "<script>window.location='".INCLUDE_PATH_PAINEL."metodo-pagamento?id=$id'</script>";
	}

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$metodo_pagamento = Painel::select('tb_admin.metodos_pagamento','id = ?',array($id));
	}else{
				
		Painel::alert('erro', 'Método de Pagamento não encontrado.');
		die();
	}
	
?>
<div class="box-content">
	<h2>Método de Pagamento - <?php echo $metodo_pagamento['metodo_pagamento']; ?></h2>
</div>

<div class=""></div>

<div class="box-content">


	<?php if ($metodo_pagamento['metodo_pagamento'] == "pix"){ ?>
	<div class="box-content">
			<h3>Chaves <?php echo $metodo_pagamento['metodo_pagamento']; ?></h3>

				<?php 
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.dados_pagamento` WHERE metodo_pagamento = '".$metodo_pagamento['metodo_pagamento']."'");
				$sql->execute();
				$sql = $sql->fetchAll(); 
				foreach ($sql as $key => $dados_pagamento) { ?>
					<div class="box-content">
						<form method="post">
							<div class="form-group">
								<label>Beneficiário</label>
								<input type="text" name="beneficiario" value="<?php echo $dados_pagamento['beneficiario']; ?>">
							</div>

							<div class="form-group">
								<label>Banco</label>
								<input type="text" name="banco" value="<?php echo $dados_pagamento['banco']; ?>">
							</div>

							<div class="form-group">
								<label>Chave Pix</label>
								<input type="text" name="chave_pix" value="<?php echo $dados_pagamento['chave_pix']; ?>">
							</div>

							<div class="form-group">
								<label>Tipo de conta</label>
								<input type="text" name="tipo_conta" value="<?php echo $dados_pagamento['tipo_conta']; ?>">
							</div>

							<div class="form-group">
								<input type="submit" name="atualizar_pix" value="Atualizar Dados">
							</div>
                                                        <input type="hidden" name="id_dado" value="<?php echo $dados_pagamento['id']; ?>">
						</form>
					</div>

					<hr>
				<?php } ?>
	</div>
	<?php } ?>

</div>
