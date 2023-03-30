<?php  
	
	if(isset($_GET['deleta_ingrediente'])){
	    $id = $_GET['deleta_ingrediente'];
	    $table = "tb_site.produtos_estoque";
	    $deleta = Painel::deletar($table,$id);
	    //echo "<script>window.location='".INCLUDE_PATH_PAINEL."estoque'</script>";
	}
?>

<div class="box-content">
	<h2 class=""><i class="	fa fa-edit"></i> Adicionar algum produto no seu estoque</h2>

	<form method="post" enctype="multipart/form-data">	

		<?php  
		if (isset($_POST['cad_produto_estoque'])) {

				$nome = $_POST['nome'];
				//$preco = $_POST['preco'];
				$quantidade = 0;
                
				$status = 1;

				$cad_produto = MySql::conectar()->prepare("INSERT INTO `tb_site.produtos_estoque` VALUES (null,?,?,?)");
				$cad_produto->execute(array($nome,$quantidade,$status));
				
				echo "<script>window.location='".INCLUDE_PATH_PAINEL."estoque'</script>";
				
				Painel::alert("sucesso","O produto foi cadastrado no seu estoque!");
				
				
			}
		?>

			<div class="form-group">	
					<label>	Nome:</label>
					<input type="text" name="nome" placeholder="Nome do produto..."  >
			</div>

			<input type="submit" name="cad_produto_estoque" value="Cadastrar produto no estoque">
	
	</form>
</div>

<div class="clear"></div>
 
<div class="box-content">
	<h2 class=""><i class="	fa fa-edit"></i> Adicionar uma compra feita</h2>
        
        <?php 
        if(isset($_POST['cad_compra_estoque'])){
    	    $produto = $_POST['produto'];
    	    $data = $_POST['data'];
    	  	$valor = $_POST['valor'];
    	   	$quantidade = $_POST['quantidade'];
    		
    		$insert = MySql::conectar()->prepare("INSERT INTO `tb_site.compras_estoque` VALUES (null,?,?,?,?)");
    		$insert->execute(array($data,$valor,$produto,$quantidade));
    		
    		$sql_quantidade = Painel::select('tb_site.produtos_estoque','nome = ?',array($produto));
    		$quantidade_total = $sql_quantidade['quantidade'] + $quantidade;
    		
    		$update_produtos_estoque = MySql::conectar()->prepare("UPDATE `tb_site.produtos_estoque` SET quantidade = $quantidade_total WHERE nome = '$produto'");
    		$update_produtos_estoque->execute();
    		
    		echo "<script>window.location='".INCLUDE_PATH_PAINEL."estoque'</script>";
    	}
        ?>
        
        <form method="post" enctype="multipart/form-data">	
            <div class="form-group">
                <label>Produto do estoque:</label>
                <select name="produto">
                    <?php 
                        $sql_busca_produto = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos_estoque`");
                        $sql_busca_produto->execute();
                        $result_estoque_produto = $sql_busca_produto->fetchAll();
                        
                        foreach($result_estoque_produto as $key => $estoque_produto){
                    ?>
                            
                            <option value="<?php echo $estoque_produto['nome']; ?>"><?php echo $estoque_produto['nome']; ?></option>
                    
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
            	<label>Data da compra:</label>
            	<input type="date" name="data" placeholder="Data..."  >
            </div>
            
            <div class="form-group">
            	<label>Valor pago: (use . ao invés de ,)</label>
            	<input type="text" name="valor" placeholder="Valor..."  >
            </div>
            			
            <div class="form-group">
            	<label>Quantidade:</label>
            	<input type="text" name="quantidade" placeholder="Quantidade comprada..."  >
            </div>
            
            <input type="submit" name="cad_compra_estoque" value="Cadastrar compra">
            
        </form>
			
			
<div class="clear"></div>

<div class="box-content">
    <h2 class=""><i class="	fa fa-edit"></i> Lista do seu estoque</h2>
    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade Atual</th>
                        <th colspan="2">Ações</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos_estoque` WHERE status = 1");
                    $sql->execute();
                    $result_sql = $sql->fetchAll();
                    
                    foreach($result_sql as $key => $estoque){
                    ?>
                        <tr>
                            <td><?php echo $estoque['nome']; ?></td>
                            <td><?php echo $estoque['quantidade']; ?></td>
                            <td>
                                <a href="?edita_ingrediente&id=<?php echo $estoque['id']; ?>">Editar</a>
                                <a href="?deleta_ingrediente=<?php echo $estoque['id']; ?>" style="color: red;">Deleta</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="clear"></div>

<div class="box-content">
    <h2 class=""><i class="	fa fa-edit"></i> Histórico de compras </h2>
    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Produto</th>
                        <th>Data</th>
                        <th>Valor pago</th>
                        <th>Quantidade comprada</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.compras_estoque`");
                    $sql->execute();
                    $result_sql = $sql->fetchAll();
                    
                    foreach($result_sql as $key => $compras_estoque){
                    ?>
                        <tr>
                            <td>Ver</td>
                            <td><?php echo $compras_estoque['produto']; ?></td>
                            <td><?php echo $compras_estoque['data']; ?></td>
                            <td>R$ <?php echo $compras_estoque['valor']; ?></td>
                            <td><?php echo $compras_estoque['quantidade']; ?> unidades</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="clear"></div>