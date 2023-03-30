<?php
  
  $busca_user = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
  $busca_user->execute(array($_SESSION['id']));
  $user = $busca_user->fetch();
  
  if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $contato = $_POST['contato'];
    
    if(!empty($_POST['password'])){
       $password = $_POST['password'];
    }else{
       $password = $user['password'];
    }
    
    $user = $_POST['user'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];

    if ($user == $_SESSION['user']) {
      $permissao = true;
    }else{
      $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = '$user'");
      $sql->execute();

      if ($sql->rowCount() > 0) {
        $_SESSION['userExiste'] = "Esse nome de usuário já está em uso, por favor, escolha outro";
        $permissao = false;
      }else{
        $permissao = true;
      }
    }

    if ($permissao == true) { 
        $update = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET user=?, password=?, nome=?, contato=?,rua=?, numero=?, bairro=?, complemento=? WHERE id=?");
        $update->execute(array($user,$password,$nome,$contato,$rua,$numero,$bairro,$complemento,$_SESSION['id']));

          $_SESSION['nome'] = $nome;
          $_SESSION['contato'] = $contato;
          $_SESSION['user'] = $user;
          $_SESSION['rua_cliente'] = $rua;
          $_SESSION['numero_casa_cliente'] = $numero;
          $_SESSION['bairro_cliente'] = $bairro;
          $_SESSION['complemento_cliente'] = $complemento;
       
          echo "<script>window.location='".INCLUDE_PATH_PAINEL."editar-usuario'</script>";
    }
  }

?>

<div class="box-content">
	<h2><i class="fa fa-cogs"></i> Informações do Usuário</h2>
</div>

<div class="box-content">
	<form method="post">
		<div class="form-group">
			<label>Nome Completo</label>
			<input type="text" name="nome" value="<?php echo $user['nome']; ?>" required>
		</div>

		<div class="form-group">
			<label>Contato</label>
			<input type="text" name="contato" value="<?php echo $user['contato']; ?>">
		</div>

		<div class="form-group">
			<label>Nome de acesso</label>
			<input type="text" name="user" value="<?php echo $user['user']; ?>">
		</div>
                
                <div class="form-group">
			<label>Senha de acesso</label>
			<input type="text" name="password" placeholder="Nova senha...">
		</div>
                
                <div class="form-group">
			<label>Rua</label>
			<input type="text" name="rua" value="<?php echo $user['rua']; ?>">
		</div>
                
                <div class="form-group">
			<label>Número da casa</label>
			<input type="text" name="numero" value="<?php echo $user['numero']; ?>">
		</div>
                
                <div class="form-group">
			<label>Bairro</label>
			<input type="text" name="bairro" value="<?php echo $user['bairro']; ?>">
		</div>
                
                <div class="form-group">
			<label>Complemento</label>
			<input type="text" name="complemento" value="<?php echo $user['complemento']; ?>">
		</div>

		<div class="form-group">
			<input type="submit" name="atualizar" value="Atualizar Info">
		</div>
	</form>
</div>