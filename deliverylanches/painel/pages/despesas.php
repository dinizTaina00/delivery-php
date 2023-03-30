<?php  

    if(isset($_POST['caddespesa'])){
        $item = $_POST['item_despesa'];
        //$data = $_POST['data'];
        $valor = $_POST['valor'];
        
        //$ano date('Y', strtotime($data));
        //$mes date('m', strtotime($data));

        $cad_despesa = MySql::conectar()->prepare("INSERT INTO `tb_admin.itens_despesa_mensal` VALUES (null,?,?)");
        $cad_despesa->execute(array($item,$valor));
        echo "<script>window.location='".INCLUDE_PATH_PAINEL."despesas'</script>";
    }

    if(isset($_POST['caddespesaisolada'])){
        $item = $_POST['item_despesa'];
        $valor = $_POST['valor'];
        $data = $_POST['data'];

        $cad_despesa = MySql::conectar()->prepare("INSERT INTO `tb_admin.itens_despesa_isoladas` VALUES (null,?,?,?)");
        $cad_despesa->execute(array($item,$valor,$data));
        echo "<script>window.location='".INCLUDE_PATH_PAINEL."despesas'</script>";
    }

    if(isset($_POST['attitemdespesamensal'])){
        $id = $_POST['id'];
        $item = $_POST['item'];
        $valor = $_POST['valor'];
        $att = MySql::conectar()->prepare("UPDATE `tb_admin.itens_despesa_mensal` SET item_despesa = '$item', valor = '$valor' WHERE id = $id");
        $att->execute();
        echo "<script>window.location='".INCLUDE_PATH_PAINEL."despesas'</script>";
    }

    if(isset($_POST['cadrelatorio'])){
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];

        $despesa_total = 0;

        $despesas_mensal = MySql::conectar()->prepare("SELECT SUM(valor) FROM `tb_admin.itens_despesa_mensal`");
        $despesas_mensal->execute();
        $despesas_mensal = $despesas_mensal->fetch();

        $despesas_isoladas = MySql::conectar()->prepare("SELECT SUM(valor) FROM `tb_admin.itens_despesa_isoladas` WHERE MONTH(data) = $mes AND YEAR(data) = $ano");
        $despesas_isoladas->execute();
        $despesas_isoladas = $despesas_isoladas->fetch();

        $despesa_total = $despesas_mensal['SUM(valor)'] + $despesas_isoladas['SUM(valor)'];
        $cad_despesa = MySql::conectar()->prepare("INSERT INTO `tb_admin.relatorio_despesas` VALUES (null,?,?,?)");
        $cad_despesa->execute(array($mes,$ano,$despesa_total));
        echo "<script>window.location='".INCLUDE_PATH_PAINEL."despesas'</script>";
    }

?>

<div class="box-content">
	<h2><i class="fas fa-chart-line"></i> Seu Histórico de Despesas</h2>
</div>
<div class="clear"></div>

<div class="box-content">
    <h2>Cadastrar uma despesa fixa mensal</h2>
    <form method="post">
        <div class="form-group">
            <label">Item Despesa</label>
            <input type="text" name="item_despesa">
        </div>
        <div class="form-group">
            <label class="form-group">
                <label>Valor total (R$)</label>
                <input type="text" name="valor">
            </label>
        </div>
        <div class="form-group">
			<input type="submit" name="caddespesa" value="Cadastrar Despesa" style="width: 100%">
		</div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Item despesa</th>
                    <th>Valor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div class="input-group">
                <?php 
                $despesas_mensal = MySql::conectar()->prepare("SELECT * FROM `tb_admin.itens_despesa_mensal`");
                $despesas_mensal->execute();
                $despesas_mensal = $despesas_mensal->fetchAll();
                foreach($despesas_mensal as $item_despesa){
                    ?>
                    <tr>
                        <form method="post" enctype="multipart/form-data">
                        <td><input type="text" class="form-control" name="item" value="<?php echo $item_despesa['item_despesa']; ?>"></td>
                        <td><input type="text" class="form-control" name="valor" value="<?php echo Painel::convertMoney($item_despesa['valor']); ?>"></td>
                        <td><input type="submit" name="attitemdespesamensal" value="Atualizar" class="btn btn-warning"></td>    
                        <input type="hidden" name="id" value="<?php echo $item_despesa['id']; ?>">
                    </form>
                    </tr>
                    <?php
                }
                ?>
                </div>
            </tbody>
        </table>
    </div>
</div>

<div class="box-content">
    <h2>Cadastrar outra despesa</h2>
    <form method="post">
        <div class="form-group">
            <label">Item Despesa</label>
            <input type="text" name="item_despesa">
        </div>
        <div class="form-group">
            <label class="form-group">
                <label>Valor total (R$)</label>
                <input type="text" name="valor">
            </label>
        </div>
        <div class="form-group">
            <label class="form-group">
                <label>Data</label>
                <input type="date" name="data">
            </label>
        </div>
        <div class="form-group">
			<input type="submit" name="caddespesaisolada" value="Cadastrar Despesa" style="width: 100%">
		</div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Item despesa</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div class="input-group">
                <?php 
                $despesas_isoladas = MySql::conectar()->prepare("SELECT * FROM `tb_admin.itens_despesa_isoladas`");
                $despesas_isoladas->execute();
                $despesas_isoladas = $despesas_isoladas->fetchAll();
                foreach($despesas_isoladas as $item_despesa_isolada){
                    ?>
                    <tr>
                        <form method="post" enctype="multipart/form-data">
                        <td><input type="text" class="form-control" name="item" value="<?php echo $item_despesa_isolada['item_despesa']; ?>"></td>
                        <td><input type="text" class="form-control" name="valor" value="<?php echo Painel::convertMoney($item_despesa_isolada['valor']); ?>"></td>
                        <td><input type="submit" name="attitemdespesamensal" value="Atualizar" class="btn btn-warning"></td>    
                        <input type="hidden" name="id" value="<?php echo $item_despesa_isolada['id']; ?>">
                    </form>
                    </tr>
                    <?php
                }
                ?>
                </div>
            </tbody>
        </table>
    </div>
</div>

<div class="box-content">
    <h2>Receber o relatório das suas despesas</h2>
    <form method="post">
        <div class="form-group">
            <label>Mês</label>
            <select name="mes">
				<option value="01">Janeiro</option>
				<option value="02">Fevereiro</option>
				<option value="03">Março</option>
				<option value="04">Abril</option>
				<option value="05">Maio</option>
				<option value="06">Junho</option>
				<option value="07">Julho</option>
				<option value="08">Agosto</option>
				<option value="09">Setembro</option>
				<option value="10">Outubro</option>
				<option value="11">Novembro</option>
				<option value="12">Dezembro</option>
			</select>
        </div>

        <div class="form-group">
            <label>Ano</label>
            <input type="text" name="ano">
        </div>

        <div class="form-group">
			<input type="submit" name="cadrelatorio" value="Receber relatório" style="width: 100%">
		</div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Mês</th>
                    <th>Ano</th>
                    <th>Valor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $relatorio_despesas = MySql::conectar()->prepare("SELECT * FROM `tb_admin.relatorio_despesas`");
                $relatorio_despesas->execute();
                $relatorio_despesas = $relatorio_despesas->fetchAll();
                foreach($relatorio_despesas as $relatorio){
                    switch ($relatorio['mes']) {
                        case '01':
                            $mes = "Janeiro";
                            break;
                        
                        case '02':
                            $mes = "Fevereiro";
                            break;

                        case '03':
                            $mes = "Março";
                            break;

                        case '04':
                            $mes = "Abril";
                            break;

                        case '05':
                            $mes = "Maio";
                            break;

                        case '06':
                            $mes = "Junho";
                            break;

                        case '07':
                            $mes = "Julho";
                            break;

                        case '08':
                            $mes = "Agosto";
                            break;

                        case '09':
                            $mes = "Setembro";
                            break;

                        case '10':
                            $mes = "Outubro";
                            break;

                        case '11':
                            $mes = "Novembro";
                            break;

                        case '12':
                            $mes = "Dezembro";
                            break;
                    }
                    ?>
                    <tr>
                        <td><?php echo $mes; ?></td>
                        <td><?php echo $relatorio['ano']; ?></td> 
                        <td><?php echo "R$".Painel::convertMoney($relatorio['valor_total']); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
