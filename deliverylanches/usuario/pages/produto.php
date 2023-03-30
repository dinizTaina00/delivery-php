<?php  		

	if (isset($_GET['id'])) {
		$id = (int)$_GET['id'];
		$produto = Painel::select('tb_site.produtos','id = ?',array($id));
	}else{
				
		Painel::alert('erro', 'Produto não encontrado.');
		die();
	}

?>

<style type="text/css">
	.menu{
		display: none;
	}
	header,.content{
		width: 100%;
		left: 0;
	}

	.content-left{
		width: 100%;
		max-width: 700px;
		float: left;
		left: 0;

	}

	.content-right{
		width: calc(100% - 700px);
		left: 700px;
	}

	.row{
		display: flex;
		flex-flow: row wrap;
	}

	.produto-detalhes{
		margin-left: 15%;
	}

	.produto-tamanhos{
		display: flex;
		margin-top: 50px;
	}

	.ul-tamanhos {
	  list-style: none;
	  margin: 0;
	  padding: 0;
	}

	.ul-tamanhos:after {
	  content: "";
	  clear: both;
	}

	.tamanho {
		width: 15%;
	  border: 1px solid #ccc;
	  box-sizing: border-box;
	  float: left;
	  height: 70px;
	  position: relative;
	  width: 120px;
	}

	.tamanho label {
	  bottom: 1px;
	  cursor: pointer;
	  display: block;
	  font-size: 0;
	  left: 1px;
	  position: absolute;
	  right: 1px;
	  text-indent: 100%;
	  top: 1px;
	  white-space: nowrap;
	}

	.tamanho + .tamanho {
	  margin-left: 25px;
	}

	.ul-tamanhos input:focus + label {
	  outline: 2px dotted #21b4d0;
	}

	.ul-tamanhos input:checked + label {
	  outline: 4px solid #21b4d0;
	}

	.ul-tamanhos input:checked + label:after {

	  bottom: -10px;
	  content: "";
	  display: inline-block;
	  height: 20px;
	  position: absolute;
	  right: -10px;
	  width: 20px;
	}

</style>


<div class="box-content">
	
	<?php  
		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.produto_imagens` WHERE produto_id = '".$produto['id']."'");
		$sql->execute();
		$produto_imagens = $sql->fetchAll();
	?>

	<h1><?php echo $produto['nome']; ?></h1>

	<div class="box-content">
		<?php  
			foreach ($produto_imagens as $key => $value) {
				?>

					<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']; ?>">

				<?php
			}
		?>
	</div>

	<div class="clear"></div>

	<div class="box-content">
		<form method="post" action="<?php echo INCLUDE_PATH_USER ?>cart?add">

                <div class="form-group">
                  <div class="form-group">
                    <h3>Para saber o valor de cada peça, confira nossa tabela de preços </h3>
                  </div>

                  <label>Escolha o tamanho e quantidade</label>
                  <select name="tamanho" >
                  	<?php  
                  		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.produto_modelo_tamanho` WHERE produto_id = '".$produto['id']."'");
                  		//OBS - Fazer uma coluna na tabela tamanhos para inserir as categorias, e colocar a clausula where categoria = $produto[categoria]
                  		$sql->execute();
                  		$sql = $sql->fetchAll();
                  		foreach ($sql as $key => $value) {
                  			echo "<option value='".$value['tamanho']."'>".$value['tamanho']."</option>";
                  		}
                  	?>
                  </select>
                  <label>Quantidade</label>
                  <input type="number" name="quantidade" required>
                   <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>"> 
                   <input type="hidden" name="categoria" value="<?php echo $produto['categoria']; ?>">
                </div>

                <div class="form-group">
                <input type="submit" value="Adicionar ao Carrinho">
                </div>
              </form>
	</div>
</div>