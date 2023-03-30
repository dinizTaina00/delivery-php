<?php  
  if (isset($_POST['atualizar_1'])) {
    $nome = $_POST['nome'];
    $contato = $_POST['contato'];
    $password = $_POST['password'];
    $user = $_POST['user'];

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
        $update = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET user=?, password=?, nome=?, contato=? WHERE id=?");
        $update->execute(array($user,$password,$nome,$contato,$_SESSION['id']));

          $_SESSION['password'] = $password;
          $_SESSION['nome'] = $nome;
          $_SESSION['contato'] = $contato;
          $_SESSION['user'] = $user;
       
          echo "<script>window.location='".INCLUDE_PATH_USER."perfil'</script>";
    }
  }

  if (isset($_POST['atualizar_2'])) {
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];

    $update = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET rua=?, numero=?, bairro=?, complemento=? WHERE id=?");
    $update->execute(array($rua,$numero,$bairro,$complemento,$_SESSION['id']));

    $_SESSION['rua_cliente'] = $rua;
    $_SESSION['numero_casa_cliente'] = $numero;
    $_SESSION['bairro_cliente'] = $bairro;
    $_SESSION['complemento_cliente'] = $complemento;

    echo "<script>window.location='".INCLUDE_PATH_USER."perfil'</script>";
  }
?>


<div class="container p-2">
  <div class="row g-1">

      <div class="col-md-7 col-lg-8" style="margin-bottom: 20px;">
        <form method="post">
          <div class="row g-3">
            <h2>Seu perfil</h2>
            <div class="col-sm-6">
              <label for="rua" class="form-label">Nome completo</label>
              <input type="text" name="nome" class="form-control" id="nome" value="<?php echo $_SESSION['nome']; ?>">
            </div>
          </div>

          <div class="row g-3">
            <div class="col-sm-6">
              <label for="contato" class="form-label">Número para contato</label>
              <input type="text" class="form-control" name="contato" id="contato" value="<?php echo $_SESSION['contato']; ?>">
            </div>
          </div>

          <div class="row g-3">
            <div class="col-sm-6">
              <?php if (isset($_SESSION['userExiste'])): ?>
                <p style="color: red;"><?php echo $_SESSION['userExiste']; unset($_SESSION['userExiste']); ?></p>
              <?php endif ?>
              <label for="user" class="form-label">Nome de acesso</label>
              <input type="text" class="form-control" id="user" name="user" value="<?php echo $_SESSION['user']; ?>">
            </div>
          </div>

          <div class="row g-3">
            <div class="col-sm-6">
              <label for="password" class="form-label">Senha de acesso</label>
              <input type="text" class="form-control" id="password" name="password" value="<?php echo $_SESSION['password']; ?>">
            </div>
          </div>

          <div class="row g-3 p-5">
            <div class="col-sm-6">
              <input type="submit" name="atualizar_1" value="Atualizar informações" class="btn btn-success form-control">
            </div>
          </div>

        </form>

          <hr style="background: transparent;">

        <form method="post">
          <div class="row g-3">
            <h2>Endereço</h2>
            <div class="col-sm-6">
              <label for="rua" class="form-label">Rua</label>
              <input type="text" name="rua" class="form-control" id="rua" value="<?php echo $_SESSION['rua_cliente']; ?>">
            </div>

            <div class="col-sm-6">
              <label for="numero" class="form-label">Número da casa</label>
              <input type="text" name="numero" class="form-control" id="numero" value="<?php echo $_SESSION['numero_casa_cliente']; ?>">
            </div>

            <div class="col-sm-6">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" name="bairro" class="form-control" id="bairro" value="<?php echo $_SESSION['bairro_cliente']; ?>">
            </div>

            <div class="col-sm-6">
              <label for="complemento" class="form-label">Complemento</label>
              <input type="text" name="complemento" class="form-control" id="complemento" value="<?php echo $_SESSION['complemento_cliente']; ?>">
            </div>
          </div>

          <div class="row g-3 p-5">
            <div class="col-sm-6">
              <input type="submit" name="atualizar_2" value="Atualizar informações" class="btn btn-success form-control">
            </div>
          </div>
        </form>
      </div>
    </div>
</div>