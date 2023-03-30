<?php  
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
		$id = $_GET['id'];
		$update = MySql::conectar()->prepare("UPDATE `tb_admin.metodos_pagamento` SET status = $status WHERE id = $id");
		$update->execute();
		echo "<script>window.location='".INCLUDE_PATH_PAINEL."pagamento'</script>";
	}
?>


<div class="box-content">
	<h2>Configurações de pagamento</h2>
</div>

<div class="clear"></div>

<div class="box-content">
	<?php  
		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.metodos_pagamento`");
		$sql->execute();
		$sql = $sql->fetchAll();

		foreach ($sql as $key => $metodo_pagamento) {
			
			?>

			<div class="box-content" style="background: #f2f2f2;">
				<h4><?php  
					switch ($metodo_pagamento['metodo_pagamento']) {
						case 'cartao de debito':
							echo "Cartão de Débito";echo "<br>";
							break;
						
						case 'cartao de credito':
							echo "Cartão de Credito";echo "<br>";
							break;
						case 'pix':
							echo "PIX";echo "<br>";
							echo "<a href='metodo-pagamento?id=".$metodo_pagamento['id']."'>Ver Chave Pix Cadastrada</a>";
							break;
						case 'dinheiro':
							echo "Dinheiro";echo "<br>";
							break;
					}
				?></h4>

				<?php  
					if ($metodo_pagamento['status'] == 0) {
						echo "<a href='?status=1&id=".$metodo_pagamento['id']."'>Ativar forma de pagamento</a>";
					}
					if ($metodo_pagamento['status'] == 1) {
						echo "<a href='?status=0&id=".$metodo_pagamento['id']."'>Desativar forma de pagamento</a>";
					}
				?>

				<!-- --------------------------------------------------------- -->

				<div class="clear"></div>
			</div>

			<div class="clear"></div>
			<?php
		}
	?>
</div>
