<?php  
	if (isset($_GET['deleta'])) {
		$id = $_GET['deleta'];
		$table = "tb_admin.usuarios";
		$deleta = Painel::deletar($table,$id);
		echo "<script>window.location='".INCLUDE_PATH_PAINEL."lista-usuarios'</script>";
	}
?>
<div class="box-content">
	<div class="container">
		<div class="table-responsive">
		  <table class="table table-hover">
		     <thead class="table">
			    <tr>
			      <th scope="col"></th>
			      <th scope="col">Cliente</th>
			      <th scope="col">Contato</th>
			      <th scope="col">Login</th>
				  <th scope="col">Senha</th>
			      <th scope="col">Ação</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php  
			  	$usuarios = MySql::conectar()->prepare("SELECT * FROM  `tb_admin.usuarios` WHERE permissao = 0");
			  	$usuarios->execute();
			  	$usuarios = $usuarios->fetchAll();

			  	foreach ($usuarios as $key => $usuario) {
			  	?>
			    <tr>
			      <td><a href="">Ver</a></td>
			      <td><?php echo $usuario['nome']; ?></td>
			      <td><?php echo $usuario['contato']; ?></td>
			      <td><?php echo $usuario['user']; ?></td>
				  <td><?php echo $usuario['password']; ?></td>
			      <td><a href="?deleta=<?php echo $usuario['id'] ?>" style="color: red;">Excluir</a></td>
			    </tr>
				<?php } ?>
			  </tbody>
		  </table>
		</div>
	</div>
</div>