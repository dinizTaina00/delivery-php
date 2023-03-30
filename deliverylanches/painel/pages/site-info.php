<?php 

	$info_site = MySql::conectar()->prepare("SELECT * FROM `tb_site.informacoes_site`");
	$info_site->execute();
	$info_site = $info_site->fetch();

	if (isset($_POST['acao'])) {
		$sql = "";
		if (empty($info_site['id_site'])) {

			if ($_POST['acao'] == "Atualizar Info") {
				if (empty($_POST['cnpj'])) {
					$cnpj = " ";
				}else{
                                        $cnpj = $_POST['cnpj'];
                                }
				$nome_negocio = $_POST['nome_negocio'];
				
				$sobre = $_POST['sobre'];
				$contato = $_POST['contato'];

				$sql = "nome_negocio='$nome_negocio', cnpj='$cnpj', sobre='$sobre', contato='$contato'";
			}

			if ($_POST['acao'] == "Atualizar Informações de envio") {
				$retirar_local = $_POST['retirar_local'];
				$valor_entrega = $_POST['valor_entrega'];
				$frete_gratis = $_POST['frete_gratis'];

				$sql = "retirar_local='$retirar_local', valor_entrega='$valor_entrega', fretegratis_apartir = '$frete_gratis'";
			}

			if ($_POST['acao'] == "Atualizar Endereço") {
				$rua = $_POST['rua'];
				$numero = $_POST['numero'];
				$bairro = $_POST['bairro'];
				$cidade = $_POST['cidade'];
				$cep = $_POST['cep'];

				$sql = "rua='$rua', numero='$numero', bairro='$bairro', cidade='$cidade', cep='$cep'";
			}

			if ($_POST['acao'] == "Atualizar horários") {
				$horaInicio = $_POST['horaInicio'];
				$horaTermino = $_POST['horaTermino'];

				$sql = "horaInicio='$horaInicio', horaTermino='$horaTermino'";
			}
			
			$update = MySql::conectar()->prepare("UPDATE `tb_site.informacoes_site` SET ".$sql." WHERE id = '".$info_site['id']."'");
			$update->execute();
	
			echo "<script>window.location='".INCLUDE_PATH_PAINEL."site-info'</script>";
			Painel::alert('sucesso','Informações Atualizadas com sucesso');
		}	
	}	

?>
<div class="box-content">
	<h2><i class="fa fa-cogs"></i> Informações do site</h2>
</div>

<div class="box-content">
	<form method="post">
		<div class="form-group">
			<label>Nome do seu negócio (Não utilizar ´ ` ' '' )</label>
			<input type="text" name="nome_negocio" value="<?php echo $info_site['nome_negocio']; ?>" required>
		</div>

		<div class="form-group">
			<label>CNPJ (opcional)</label>
			<input type="text" name="cnpj" value="<?php echo $info_site['cnpj']; ?>">
		</div>

		<div class="form-group">
			<label>Sobre</label>
			<textarea name="sobre"><?php echo $info_site['sobre']; ?></textarea>
		</div>
		
		<div class="form-group">
			<label>Contato</label>
			<input type="text" name="contato" value="<?php echo $info_site['contato']; ?>">
		</div>

		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar Info">
		</div>
	</form>
</div>

<div class="box-content">
	<form method="post">
		<div class="form-group">
			<label>Seu negócio oferece retirada de produtos no local?</label>
			Sim <input type="radio" name="retirar_local" required value="sim" onclick="sim()" <?php if ($info_site['retirar_local'] == 'sim') echo "checked"; ?>>
			Não <input type="radio" name="retirar_local" required value="nao" onclick="nao()" <?php if ($info_site['retirar_local'] == 'nao') echo "checked"; ?>>
		</div>

		<div class="form-group">
			<label>Qual valor de entrega?</label>
			<input type="text" name="valor_entrega" value="<?php echo $info_site['valor_entrega']; ?>">
		</div>
		<div class="form-group">
			<label>Você oferece frete grátis em pedidos apartir de ? (caso não oferece frete grátis deixe como 0 ou vazio)</label>
			<input type="text" name="frete_gratis" value="<?php echo $info_site['fretegratis_apartir']; ?>">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar Informações de envio">
		</div>
	</form>
</div>

<div class="box-content">
	<form method="post">
		<div class="form-group" id="endereco">
			<h2>Endereço</h2>
			<label>Rua</label>
			<input type="text" name="rua" value="<?php echo $info_site['rua']; ?>">

			<label>Número</label>
			<input type="text" name="numero" value="<?php echo $info_site['numero']; ?>">

			<label>Bairro</label>
			<input type="text" name="bairro" value="<?php echo $info_site['bairro']; ?>">

			<label>Cidade</label>
			<input type="text" name="cidade" value="<?php echo $info_site['cidade']; ?>">

			<label>CEP</label>
			<input type="text" name="cep" value="<?php echo $info_site['cep']; ?>">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar Endereço">
		</div>
	</form>
</div>

<div class="box-content">
	<form method="post">
		<div class="form-group">
			<h2>Horários de funcionamento</h2>
			<label>Horário de início</label>
			<input type="time" name="horaInicio" value="<?php echo $info_site['horaInicio']; ?>" >

			<label>Horário de término</label>
			<input type="time" name="horaTermino" value="<?php echo $info_site['horaTermino']; ?>" >
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar horários">
		</div>
	</form>
</div>
		
</div>