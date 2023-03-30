<?php 

	if (isset($_SESSION['permissao'])) {
		header("Location: ".INCLUDE_PATH."index");
		}

?>
	<div class="box-login">
		<span class="close" style="color: black;">&times;</span>
		<?php  
			if (isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar') {
				$nome = $_POST['nome'];
				$contato = $_POST['contato'];
				$user = $_POST['user'];
				$password = $_POST['password'];
				//? para nao ter ataque de inject
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ?");
				$sql->execute(array($user));

				if ($sql->rowCount() > 0){
					$_SESSION['userExiste'] = "<h3 style='color: red;'>Já foi cadastrado um usuário com esse login!!</h3>";
				}else{
					$cadastra = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuarios` VALUES (null,?,?,?,?,?,?,?,?,?)");
					$cadastra->execute(array($user,$password,$nome,0,$contato,'','','',''));
					echo '<script>window.location="'.INCLUDE_PATH.'login"</script>';
				}
			}
		?>

<?php  
	$info_site = Site::sqlInfoSite();
?>

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
  <div class="row align-items-center g-5 py-5">
    <div class="col-lg-7 text-center text-lg-start">
      <h1 class="display-5 mb-1"><?php echo $info_site['nome_negocio']; ?></h1>
      <p class="col-lg-10 fs-4"><?php echo $info_site['frase_efeito']; ?>.</p>
    </div>
    <div class="col-10 mx-auto col-lg-5">
      <form class="p-5 border rounded-3 bg-light" method="post">
      	
      		<?php if (!empty($_SESSION['userExiste'])){
				    	echo "<p style='font-size: 16px!important;'>".$_SESSION['userExiste']."</p>";
				    	unset($_SESSION['userExiste']);
				    }
		    ?>

      	<div class="form-floating mb-3">
		  <label for="floatNome">Nome completo</label>
      	  <input type="text" name="nome" class="form-control" id="floatNome" placeholder="Seu nome completo...">
      		
      	</div>

      	<div class="form-floating mb-3">
		  	<label for="floatContato">Número para contato</label>
      		<input type="text" name="contato" class="form-control" id="floatContato" placeholder="Número para contato...">
      		
      	</div>

        <div class="form-floating mb-3">
		  <label for="floatingInput">Nome para acesso (Não utilize espaços ou acentos)</label>
          <input type="text" name="user" class="form-control" value="55" id="floatingInput" placeholder="Nome para login (apenas letras e números)...">
          
        </div>

        <div class="form-floating mb-3">
		  <label for="floatingPassword">Senha</label>
          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha de acesso...">
          
        </div>

        <input type="submit" class="w-100 btn btn-lg btn-primary" name="acao" value="Cadastrar">
        <hr class="my-4">
        <small class="text-muted">Já possui uma conta?  <a href="login">Acesse aqui</a></small>
      </form>
    </div>
  </div>
</div>