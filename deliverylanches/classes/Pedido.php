<?php  
	
	class Pedido{
		public static function cadastrarPedidoMinimo(){
			
		}

		public static function listarNovosPedidos(){
			$novosPedidos = MySql::conectar()->prepare("SELECT * FROM `tb_site.pedidos` WHERE status = 'realizado'");
			$novosPedidos->execute();
			return $novosPedidos->fetchAll();
		}

	}

?>