<?php  
        	if (isset($_SESSION['permissao'])) {
		header("Location: ".INCLUDE_PATH."index");
		}

	if (isset($_COOKIE['lembrar'])) {
		$user = $_COOKIE['user'];
		$password = $_COOKIE['password'];

		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
		$sql->execute(array($user,$password));
			if ($sql->rowCount()==1) {
				$info = $sql->fetch();
				//Logamos com sucesso
				$_SESSION['id'] = $info['id'];
				$_SESSION['login'] = true;
				$_SESSION['user'] = $user;
				$_SESSION['password'] = $password;
				$_SESSION['permissao'] = $info['permissao'];
				$_SESSION['nome'] = $info['nome'];
				header('Location: '.INCLUDE_PATH_PAINEL);
				die();
			}
	}
?>
	<div class="box-login">
		
		<?php  
			if (isset($_POST['acao']) && $_POST['acao'] == 'Acessar') {
				$user = $_POST['user'];
				$password = $_POST['password'];
				//? para nao ter ataque de inject
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
				$sql->execute(array($user,$password));
				
				if ($sql->rowCount() == 1) {
					$info = $sql->fetch();
					//Logamos com sucesso
					$_SESSION['id'] = $info['id'];
					$_SESSION['login'] = true;
					$_SESSION['user'] = $user;
					$_SESSION['password'] = $password;
					$_SESSION['permissao'] = $info['permissao'];
					$_SESSION['nome'] = $info['nome'];
					$_SESSION['contato'] = $info['contato'];
					$_SESSION['rua_cliente'] = $info['rua'];
					$_SESSION['numero_casa_cliente'] = $info['numero'];
					$_SESSION['bairro_cliente'] = $info['bairro'];
					$_SESSION['complemento_cliente'] = $info['complemento'];
                                       

					$sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.informacoes_site`");
					$sql->execute();
					$info_site = $sql->fetch();
					//Info site
					$_SESSION['id_site'] = $info_site['id'];
					$_SESSION['nome_negocio'] = $info_site['nome_negocio'];
					$_SESSION['cnpj'] = $info_site['cnpj'];
					$_SESSION['retirar_local'] = $info_site['retirar_local'];
					$_SESSION['rua'] = $info_site['rua'];
					$_SESSION['numero'] = $info_site['numero'];
					$_SESSION['bairro'] = $info_site['bairro'];
					$_SESSION['cidade'] = $info_site['cidade'];
					$_SESSION['cep'] = $info_site['cep'];
					$_SESSION['horaInicio'] = $info_site['horaInicio'];
					$_SESSION['horaTermino'] = $info_site['horaTermino'];
					$_SESSION['contatoLocal'] = $info_site['contato'];

					if (isset($_POST['lembrar'])) {
						setcookie('lembrar',true,time()+60*60*24*7,'/');
						setcookie('user',$user,time()+60*60*24*7,'/');
						setcookie('password',$password,time()+60*60*24*7,'/');

					}
					if ($info['permissao'] == 0) {
						echo '<script>window.location="'.INCLUDE_PATH_USER.'home"</script>';
						die();
					}else if ($info['permissao'] == 1){
						echo '<script>window.location="'.INCLUDE_PATH_PAINEL.'home"</script>';	
						die();
					}
					
 				}else{
					//Falhou
					$_SESSION['falhaLogin'] = "<h3 style='color: red;'>Usuario ou senha incorretos!!</h3>";
				}
			}

			if (isset($_POST['cadastro'])) {
				
				$nome = $_POST['nome'];
				$senha = $_POST['password'];
				$imagem = "";
				$permissao = 0;
				$user = $_POST['login'];
				$usuario = new Usuario();
				
				//Se o usuário ja foi cadastrado
				if (Usuario::userExists($user)) {
					Painel::alert('erro','O usuário '.$user.' já existe!');
				}else{
					//Cadastrar no banco de dados
					$usuario->cadastrarUsuario($user,$senha,$imagem,$nome,$permissao);
				}

				echo '<script>window.location="'.INCLUDE_PATH_PAINEL.'home"</script>';
			 ?>

			<?php
			 }
		?>

<?php  
	$info_site = Site::sqlInfoSite();
?>

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
  <div class="row align-items-center g-5 py-5">
    <div class="col-lg-7 text-center text-lg-start">
      <h1 class="display-5 mb-1"><?php echo $info_site['nome_negocio']; ?></h1>
      <p class="col-lg-10 fs-4"><?php echo $info_site['frase_efeito']; ?></p>
    </div>
    
    <div class="col-10 mx-auto col-lg-5">
      <form class="p-5 border rounded-3 bg-light" method="post">
      	<?php if (!empty($_SESSION['falhaLogin'])){
			    	echo $_SESSION['falhaLogin'];
			    	unset($_SESSION['falhaLogin']);
			    }
		?>
        <div class="form-floating mb-3">
          <input type="text" name="user" class="form-control" id="floatingInput" placeholder="Usuário...">
          <label for="floatingInput">Usuário</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha de acesso...">
          <label for="floatingPassword">Senha</label>
        </div>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Lembre-me
          </label>
        </div>
        <input type="submit" class="w-100 btn btn-lg btn-primary" name="acao" value="Acessar">
        <hr class="my-4">
        <small class="text-muted">Ainda não possui uma conta?  <a href="cadastro">Cadastre-se</a> é grátis</small>
      </form>
    </div>
  </div>
</div>