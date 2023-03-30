<!-- Modal -->
<div class="modal fade" id="modal<?php echo $produto['id']; ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form method="post" action="<?php echo INCLUDE_PATH_USER; ?>/addCarrinho">
         <center> <img class="img-produto" src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $produto['img']; ?>" style="border-radius: 50%;"></center>

          <div class="modal-opcoes">
            <p class="modal-prod-name"><?php echo $produto['nome']; ?></p>
            
            <p style="font-size: 20px; font-weight: 700;">R$<?php echo Painel::convertMoney($produto['preco']); ?></p>
            
            <p class="modal-prod-desc">
              <p>Escolha os ingredientes:</p>
              <p>
                <textarea name="ingredientes" class="modal-ingredientes"><?php echo $produto['ingredientes']; ?></textarea>
            </p>

            <p>Quantidade:</p>
            <p><input type="number" name="quantidade" value="1" maxlength="50" minlength="0" class="modal-quantidade"></p>

            <p><input type="submit" name="addCart" value="Adicionar ao carrinho" class="btn btn-success"></p>
          </div>
          <input type="hidden" name="imgProduto" value="<?php echo $produto['img']; ?>">
          <input type="hidden" name="precoProduto" value="<?php echo $produto['preco']; ?>">
          <input type="hidden" name="nomeProduto" value="<?php echo $produto['nome']; ?>">
          <input type="hidden" name="idProduto" value="<?php echo $produto['id']; ?>">
          <input type="hidden" name="tempo_estimado" value="<?php echo $produto['tempo']; ?>">
          <input type="hidden" name="categoriaProduto" value="<?php echo $produto['categoria']; ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
    <style type="text/css">
      .modal-prod-name{
        font-size: 22px;
        font-weight: 900;
      }

      .modal-ingredientes{
        width: 40%;
        text-align: center;
      }

      .modal-quantidade{
        width: 5%;
        text-align: center;
      }

      .modal-opcoes{
        margin-top: 20px;
      }

      .img-produto{
        width: 200px;
      }

      @media (min-width : 320px) and (max-width : 480px) { 
        .modal-ingredientes{
          width: 70%; 
          text-align: center;
        }
        .modal-quantidade{
          width: 20%;
          text-align: center;
        }
      }

      @media screen and (min-width: 375px){
        .img-produto{
         
        }
      }

    </style>