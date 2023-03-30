
<div class="box-content w50">
	<h2 class=""><i class="	fa fa-edit"></i> Cadastrar categoria</h2>

	<form method="post" enctype="multipart/form-data">	

		<?php  
		if (isset($_POST['acao'])) {

				$nome = $_POST['nome'];
				$categoria = new Produto();

				if (Produto::categoriaExist($nome)) {
				 Painel::alert('erro','A categoria '.$nome.' já existe!');
				 }else{
				 	$categoria->cadastrarCategoria($nome);
				 	Painel::alert('sucesso','Categoria cadastrado com sucesso!');
				 }
			}

		if (isset($_GET['excluir'])) {
			$idExcluir = intval($_GET['excluir']);
			Painel::deletar('tb_site.categorias',$idExcluir);
		}
		?>

			<div class="form-group ">	
					<label>	Nome:</label>
					<input type="text" name="nome" required>
			</div>

			<div class="form-group ">	
				<input type="submit" name="acao" value="Atualizar">
			</div>
	</form>
</div>

	<div class="clear"></div>

<div class="box-content w50">
	
	<h2><i class="fa fa-user"></i> Lista de categorias</h2>

	<div class="table-responsive">
		<div class="row">
			<div class="col">
				<p>Nome</p>
			</div>
			<div class="clear"></div>
		</div>

		<?php  
			$categoriasPainel = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias`");
			$categoriasPainel->execute();
			$categoriasPainel = $categoriasPainel->fetchAll();
			foreach ($categoriasPainel as $key => $value) {
				
		?>

		<div class="row">
			<div class="col">
				<p><?php echo $value['nome']; ?></p>
			</div>
			<a href="<?php echo INCLUDE_PATH_PAINEL ?>categorias?excluir=<?php echo $value['id']; ?>" class=""><i class="fa fa-times"></i> Excluir</a>
			<div class="clear"></div>
		</div>

		<?php } ?>

	</div>


</div>