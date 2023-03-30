<?php  
	if (isset($_SESSION['permissao'])) {
    header("Location: ".INCLUDE_PATH."index");
    }
        
  $info_site = Site::sqlInfoSite();
?>
<div class="px-4 py-5 my-5 text-center">
  <?php  
        $sql_imagens_banner = Mysql::conectar()->prepare("SELECT * FROM `tb_site.imagens_site`");
          $sql_imagens_banner->execute();
        
            if ($sql_imagens_banner->rowCount() > 0) {
              $sql_imagens_banner = $sql_imagens_banner->fetch();
              ?>
                    <img style="border-radius: 50%; width:200px ;" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $sql_imagens_banner['imagem_logo']; ?>">
              <?php
            }
          ?>
  <span class="fs-4 ms-4"><?php echo $info_site['nome_negocio']; ?></span>
  <div class="col-lg-6 mx-auto">
    <p class="lead mb-4"><strong>Endereço</strong> <?php echo $info_site['rua'].", ". $info_site['numero']."- ".$info_site['bairro'].", ".$info_site['cidade']."- ".Site::formataCep($info_site['cep']); ?></p>

     <?php  
        $horaAtual = date('H:i:s');
        $status_estabelecimento = "";
        if ($horaAtual >= $info_site['horaInicio'] && $horaAtual <= $info_site['horaTermino']) {
         $status_estabelecimento = "Aberto";
        }else{
        $status_estabelecimento = "Fechado";
        }
      ?>

      <p class="lead mb-4"><strong>Horário</strong> <span style="color: green;"><?php echo $status_estabelecimento; ?></span> <?php echo $info_site['horaInicio']." às ". $info_site['horaTermino']; ?></p>

      <p class="lead mb-4"><strong>Contato</strong>
        <?php  
            foreach ($contatos as $key => $contato) {
              echo Site::formataContato($contato['contato']);
              echo "<br>";
            }
          ?>
       </p>
  </div>
</div>
