<div class="box-content">
	<h2 class=""><i class="	fa fa-edit"></i> Adicionar produto</h2>

	<form method="post" enctype="multipart/form-data">	

		<?php  
		if (isset($_POST['acao'])) {

				$nome = $_POST['nome'];
				$preco = $_POST['preco'];
				$categoria = $_POST['categoria'];
				$tempo = $_POST['tempo'];

				$status = "1";

				$ingredientes = "";
                
                foreach($_POST['ingredientes'] as $key => $value){
                    $ingredientes = $ingredientes . $value . " ";
                }
                
				$imagem = $_FILES['imagem'];

				$sucesso = true;

				$imagemAtual = ['type'=>$_FILES['imagem']['type'],
					'size'=>$_FILES['imagem']['size']];
					if(Painel::imagemValida($imagemAtual) == false){
						$sucesso = false;
						Painel::alert("erro","Uma ou mais imagens não são válidas");
						die();
					}

				if ($sucesso) {

						$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'],
						'name'=>$_FILES['imagem']['name']];
						$imagem = Painel::uploadFile($imagemAtual);

						$cad_produto = MySql::conectar()->prepare("INSERT INTO `tb_site.produtos` VALUES (null,?,?,?,?,?,?,?)");
						$cad_produto->execute(array($nome,$preco,$ingredientes,$categoria,$imagem,$tempo,$status));
					
					Painel::alert("sucesso","O produto foi cadastrado com sucesso!");
				}
				
				echo "<script>window.location='".INCLUDE_PATH_PAINEL."edita-produto?id=".$id."'</script>";
				
			}
		?>

			<div class="form-group">	
					<label>	Nome:</label>
					<input type="text" name="nome" placeholder="Nome do produto..."  >
			</div>

			<div class="form-group">
					<label>Preço:</label>
					<input type="text" name="preco" placeholder="Preço do produto..."  >
			</div>

			<div class="form-group">
					<label>Tempo de preparo <span>em minutos</span>:</label>
					<input type="text" name="tempo" placeholder="Tempo em minutos..."  >
			</div>

			<div class="form-group">
					<label>Categoria:</label>
					<select name="categoria">
						
					<?php  
						$sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias`");
						$sql->execute();
						$sql = $sql->fetchAll();

						foreach ($sql as $key => $categoria) {
					?>
						<option value="<?php echo $categoria['nome']; ?>"><?php echo $categoria['nome']; ?></option>

					<?php } ?>

					</select>
				
			</div>

			<div class="form-group">	
					<label>	Ingredientes:</label>
					<?php
					    $sql_produtos_estoque = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos_estoque` WHERE status = 1");
					    $sql_produtos_estoque->execute();
					    $result_pesquisa = $sql_produtos_estoque->fetchAll();
					    
					    foreach($result_pesquisa as $key => $produtos){
					?>
					    <input type="checkbox" value="<?php echo $produtos['nome'] ?>" name="ingredientes[]"> <?php echo $produtos['nome']; ?><br>
					
					<?php } ?>
			</div>

			<div class="form-group">
				<label>Imagem do produto</label>
				<input type="file" name="imagem" >
			</div>

			<input type="submit" name="acao" value="Cadastrar">
	
	</form>
</div>