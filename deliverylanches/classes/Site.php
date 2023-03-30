<?php  

	class Site{
		public static function formataContato($numero){
			   $formata = substr($numero, 0, 2);
			   $formata_2 = substr($numero, 2, 1);
			   $formata_3 = substr($numero, 3, 4);
			   $formata_4 = substr($numero, 7, 8);
			   return "(".$formata.") ". $formata_2 ." ". $formata_3 . "-". $formata_4;
		}

		public static function formataCnpj($cnpj){
 			$formata = substr($cnpj, 0, 2);
			$formata_2 = substr($cnpj, 2, 3);
			$formata_3 = substr($cnpj, 5, 3);
			$formata_4 = substr($cnpj, 8, 4);
			$formata_5 = substr($cnpj, 12, 2);
			return $formata.".".$formata_2.".".$formata_3."/".$formata_4."-".$formata_5;
		}

		public static function formataCep($cep){
			$formata = substr($cep, 0, 5);
			$formata_2 = substr($cep, 5, 7);
			return $formata."-".$formata_2;
		}
		public static function sqlInfoSite(){
			$sql_info_site = MySql::conectar()->prepare("SELECT * FROM `tb_site.informacoes_site`");
			$sql_info_site->execute();
			return $sql_info_site->fetch();
		}

		public static function sqlImagensSite(){
			$sql_imagens_site = MySql::conectar()->prepare("SELECT * FROM `tb_site.imagens_site`");
			$sql_imagens_site->execute();
			return $sql_imagens_site->fetch();
		}

		public static function contatosNegocio(){
			$sql_contatos_negocio = MySql::conectar()->prepare("SELECT * FROM `tb_site.numeros_contato`");
			$sql_contatos_negocio->execute();
			return$sql_contatos_negocio->fetchAll();
		}

		public static function updateUsuarioOnline(){
			if (isset($_SESSION['online'])) {
				$token = $_SESSION['online'];
				$horarioAtual = date('Y-m-d H:i:s');
				$check = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.online` WHERE token = ?");
				$check->execute(array($_SESSION['online']));

				if ($check->rowCount() == 1) {
					$sql = MySql::conectar()->prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ?");
					$sql->execute(array($horarioAtual,$token));
				}else{
					$_SESSION['online'] = uniqid();
					$token = $_SESSION['online'];
					$ip = $_SERVER['REMOTE_ADDR'];
					$horarioAtual = date('Y-m-d H:i:s');
					$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (NULL,?,?,?)");
					$sql->execute(array($ip,$horarioAtual,$token));
				}

			}else{
				$_SESSION['online'] = uniqid();
				$token = $_SESSION['online'];
				$ip = $_SERVER['REMOTE_ADDR'];
				$horarioAtual = date('Y-m-d H:i:s');
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (NULL,?,?,?)");
				$sql->execute(array($ip,$horarioAtual,$token));
			}
		}

		public static function contador(){
			setcookie('visita','true',time() - 1);
			if (!isset($_COOKIE['visita'])) {
				setcookie('visita','true',time() + (60*60*24*7));
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.visitas` VALUES (null,?,?)");
				$sql->execute(array($_SERVER['REMOTE_ADDR'],date("Y-m-d")));
			}
		}

		public static function cadastraInfoSite($nome_negocio,$cnpj,$retirar_local,$rua,$numero,$bairro,$cidade,$cep,$horaInicio,$horaTermino,$contato,$valor_entrega){
			$sql = MySql::conectar()->prepare("INSERT INTO `tb_site.informacoes_site` VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?)");
			$sql->execute(array($nome_negocio,$cnpj,$retirar_local,$rua,$numero,$bairro,$cidade,$cep,$horaInicio,$horaTermino,$contato,$valor_entrega));

				$lastid = MySql::conectar()->lastInsertId();
					$_SESSION['id_site'] = $lastid;
					$_SESSION['nome_negocio'] = $nome_negocio;
					$_SESSION['cnpj'] = $cnpj;
					$_SESSION['retirar_local'] = $retirar_local;
					$_SESSION['rua'] = $rua;
					$_SESSION['numero'] = $numero;
					$_SESSION['bairro'] = $bairro;
					$_SESSION['cidade'] = $cidade;
					$_SESSION['cep'] = $cep;
					$_SESSION['horaInicio'] = $horaInicio;
					$_SESSION['horaTermino'] = $horaTermino;
					$_SESSION['contato'] = $contato;
					$_SESSION['valor_entrega'] = $valor_entrega;
		}

		public static function atualizaInfoSite($nome_negocio,$cnpj,$retirar_local,$rua,$numero,$bairro,$cidade,$cep,$horaInicio,$horaTermino,$contato,$valor_entrega,$id){

				$sql = MySql::conectar()->prepare("UPDATE `tb_site.informacoes_site` SET 
																					nome_negocio = ?,
																					cnpj = ?,
																					retirar_local = ?,
																					rua = ?,
																					numero = ?,
																					bairro = ?,
																					cidade = ?,
																					cep = ?,
																					horaInicio = ?,
																					horaTermino = ?,
																					contato = ?,
																					valor_entrega = ?

																				WHERE id = ?
																					");
			$sql->execute(array($nome_negocio,$cnpj,$retirar_local,$rua,$numero,$bairro,$cidade,$cep,$horaInicio,$horaTermino,$contato,$valor_entrega,$id));


					$_SESSION['nome_negocio'] = $nome_negocio;
					$_SESSION['cnpj'] = $cnpj;
					$_SESSION['retirar_local'] = $retirar_local;
					$_SESSION['rua'] = $rua;
					$_SESSION['numero'] = $numero;
					$_SESSION['bairro'] = $bairro;
					$_SESSION['cidade'] = $cidade;
					$_SESSION['cep'] = $cep;
					$_SESSION['horaInicio'] = $horaInicio;
					$_SESSION['horaTermino'] = $horaTermino;
					$_SESSION['contato'] = $contato;
					$_SESSION['valor_entrega'] = $valor_entrega;

		}
	}
?>