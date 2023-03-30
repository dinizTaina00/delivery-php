<?php  
	class Produto{

		public static function cadastrarCategoria($nome){
			$sql = MySql::conectar()->prepare("INSERT INTO `tb_site.categorias` VALUES (null,?)");
			if ($sql->execute(array($nome))) {
				return true;
			}else{
				return false;
			}
		}

		public static function categoriaExist($nome){
			$sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_site.categorias` WHERE nome=?");
			$sql->execute(array($nome));
			if ($sql->rowCount()==1) {
				return true;
			}else{
				return false;
			}
		}

		public static function atualizaProduto($nome,$marca,$descricao,$largura,$altura,$comprimento,$peso,$categoria,$modelo,$cor,$quantidade,$id){
			$sql = MySql::conectar()->prepare("UPDATE `tb_admin.produto` SET 
																nome=?,
																marca=?,
																descricao=?,
																largura=?,
																altura=?,
																comprimento=?,
																peso=?,
																categoria=? 

																WHERE id = ?");
			$sql->execute(array($nome,$marca,$descricao,$largura,$altura,$comprimento,$peso,$categoria,$id));

			$sqlModelo = MySql::conectar()->prepare("UPDATE `tb_admin.produto_modelo` SET
											modelo=?,
											cor=?,
											quantidade=?

										WHERE produto_id = ?");
			$sqlModelo->execute(array($modelo,$cor,$quantidade,$id));
		}

	}
?>