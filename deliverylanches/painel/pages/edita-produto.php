<?php  
	if (isset($_POST['addMais'])) {
		
	}

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$produto = Painel::select('tb_site.produtos','id = ?',array($id));
	}else{
		Painel::alert('erro', 'Produto não encontrado.');
		die();
	}

	if (isset($_POST['acao'])) {
				$nome = $_POST['nome'];
				$preco = $_POST['preco'];
				$status = "1";
				$tempo = $_POST['tempo'];

				$categoria = $_POST['categoria'];
				
				$ingredientes = "";
                
                foreach($_POST['ingredientes'] as $key => $value){
                    $ingredientes = $ingredientes . $value . " ";
                }
                
                $imagem = $_FILES['imagem'];
                
                if($_FILES['imagem']['error'] == 4){
                    $imagem = $produto['img'];
                }else{
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
                    }
                }
				

			   $sql = MySql::conectar()->prepare("UPDATE `tb_site.produtos` SET nome = ?, preco = ?, ingredientes = ?, categoria = ?, img = ?, tempo = ?, status = ? WHERE id = $id");
			   $sql->execute(array($nome,$preco,$ingredientes,$categoria,$imagem,$tempo,$status));
				
					echo '<script>window.location="'.INCLUDE_PATH_PAINEL.'edita-produto?id='.$produto['id'].'"</script>';

					Painel::alert("sucesso","O produto foi cadastrado com sucesso!");
				}
                

				// if (!$vazio) {
					
				// 			Painel::alert("sucesso","O produto foi cadastrado com sucesso!");
					
				 //	echo "<script>window.location='".INCLUDE_PATH_PAINEL."edita-produto?id=".$id."'</script>";
				//}
	
?>
<div class="box-content">
	<h2 class=""><i class="	fa fa-edit"></i> Editando produto <b><?php echo $produto['nome']; ?></b></h2>

	<form method="post" enctype="multipart/form-data">	

			<div class="form-group">	
					<label>	Nome:</label>
					<input type="text" name="nome" value="<?php echo $produto['nome']; ?>"  >
			</div>

			<div class="form-group">
					<label>Preço:</label>
					<input type="text" name="preco" value="<?php echo $produto['preco']; ?>"  >
			</div>

			<div class="form-group">
					<label>Tempo de preparo <span>em minutos</span>:</label>
					<input type="text" name="tempo" value="<?php echo $produto['tempo']; ?>"  >
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
						<option <?php if($categoria['nome'] == $produto['categoria']) echo "selected='selected'"; ?> value="<?php echo $categoria['nome']; ?>"><?php echo $categoria['nome']; ?></option>

					<?php } ?>

					</select>
				
			</div>

			<div class="form-group">	
					<label>	Ingredientes:</label>
					<?php
					    $sql_produtos_estoque = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos_estoque` WHERE status = 1");
					    $sql_produtos_estoque->execute();
					    $result_pesquisa = $sql_produtos_estoque->fetchAll();
					    
					    $ingredientes = $produto['ingredientes'];
					    
					    foreach($result_pesquisa as $produtos){
					        
					        if(in_array($produtos['nome'], preg_split('/[ !,.?]+/', $ingredientes))){
					            
					          echo '<input type="checkbox" value="'.$produtos["nome"].'" name="ingredientes[]" checked> '.$produtos['nome'].'<br>';
        					 }else{ 
        					  echo '<input type="checkbox" value="'.$produtos["nome"].'" name="ingredientes[]"> '.$produtos['nome'].'<br>';  
        					 }
        			    } ?> 
			</div>

			<div class="form-group">
			    <img src="<?php INCLUDE_PATH_PAINEL ?>uploads/<?php echo $produto['img']; ?>">
				<label>Imagem atual do produto</label>
				<input type="file" name="imagem" >
			</div>

			<input type="submit" name="acao" value="Cadastrar">
	
	</form>
</div>