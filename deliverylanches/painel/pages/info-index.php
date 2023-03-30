<?php  
	$busca_imagens = MySql::conectar()->prepare("SELECT * FROM `tb_site.imagens_site`");
	$busca_imagens->execute();
	$existe_imagem = false;
	if ($busca_imagens->rowCount() > 0) {
		$existe_imagem = true;
		$imagens_site = $busca_imagens->fetch();
	}

		if (isset($_POST['acao'])) {
			$info = new Site();
			$sucesso = true;

			$imagemAtual = ['type'=>$_FILES['imagem']['type'],
					'size'=>$_FILES['imagem']['size']];
					if ($_POST['acao'] == "Atualizar banner" || $_POST['acao'] == "Cadastrar banner") {
    					if(Painel::imagemValida($imagemAtual) == false){
    						$sucesso = false;
    						Painel::alert("erro","Uma ou mais imagens não são válidas");
    						die();
    				}
			}
		
		if ($sucesso) {
			$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'],
					'name'=>$_FILES['imagem']['name']]	;
			$imagem = Painel::uploadFile($imagemAtual);

			if ($_POST['acao'] == "Atualizar imagem da marca") {
				$sql = MySql::conectar()->prepare("UPDATE `tb_site.imagens_site` SET imagem_logo = '$imagem'");
				$sql->execute();

			}elseif ($_POST['acao'] == "Atualizar banner") {
				$sql = MySql::conectar()->prepare("UPDATE `tb_site.imagens_site` SET imagem_banner = '$imagem'");
				$sql->execute();
			
			}elseif ($_POST['acao'] == "Cadastrar imagem da marca") {
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_site.imagens_site` VALUES (NULL,'$imagem','vazio')");
				$sql->execute();
			
			}elseif ($_POST['acao'] == "Cadastrar banner") {
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_site.imagens_site` VALUES (NULL,'vazio','$imagem')");
				$sql->execute();
			}
		}

		echo "<script>window.location='".INCLUDE_PATH_PAINEL."info-index'</script>";

	}

?>
<div class="box-content">
	<h2><i class="fa fa-cogs"></i> Informações da Página inicial</h2>
</div>

<div class="box-content">
				<?php 
				if ($existe_imagem){

				?>
				<form method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Imagem da sua marca</label><br>
						<?php if ($imagens_site['imagem_logo'] != "vazio" || $imagens_site['imagem_logo'] == ""): ?>
							<img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $imagens_site['imagem_logo']; ?>" width="300px" height="200px" style="border-radius: 50px;">
						<?php endif ?>

					<input type="file" name="imagem">
				</div>
				<div class="form-group">
					<input type="submit" name="acao" value="Atualizar imagem da marca">
				</div>
				</form>

				<form method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Imagem do banner inicial</label><br>
						<?php if ($imagens_site['imagem_banner'] != "vazio" || $imagens_site['imagem_banner'] == ""): ?>
							<img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $imagens_site['imagem_banner']; ?>" width="300px" height="200px" style="border-radius: 50px;">
						<?php endif ?>

						<input type="file" name="imagem">
				</div>
				<div class="form-group">

					<input type="submit" name="acao" value="Atualizar banner">
				</div>
				</form>
				<?php		
					}else{
						?>
							<form method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label>Imagem da sua marca</label><br>
									<input type="file" name="imagem">
								</div>

								<div class="form-group">
									<input type="submit" name="acao" value="Cadastrar imagem da marca">
								</div>
							</form>

							<form method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label>Imagem do banner inicial</label><br>
									<input type="file" name="imagem">
								</div>
								<div class="form-group">
									<input type="submit" name="acao" value="Cadastrar banner">
								</div>
							</form>
						<?php
					}
				?>
</div>