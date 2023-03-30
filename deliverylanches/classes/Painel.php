<?php  
	
	class Painel{

		public static $permissao = [
			'0' => 'Usuario',
			'1' => 'Administrador'];

		public static function logado(){
			return isset($_SESSION['login']) ? true : false;
		}

		public static function convertMoney($valor){
			return number_format($valor, 2, ',', '.');
		}

		public static function loggout(){
			setcookie('lembrar','true',time()-1,'/');
			session_destroy();
			header('Location: '.INCLUDE_PATH_PAINEL);
		}

		public static function carregarPagina(){
			if (isset($_GET['url'])) {
				$url = explode('/', $_GET['url']);
				if (file_exists('pages/'.$url[0].'.php')) {
					include('pages/'.$url[0].'.php');
				}else{
					header("Location: ".INCLUDE_PATH_PAINEL);
				}
			}else{
				include('pages/home.php');
			}
		}

		public static function carregarPaginaUser(){
			if (isset($_GET['url'])) {
				$url = explode('/',$_GET['url']);
				if (file_exists('pages/'.$url[0].'.php')) {
					include('pages/'.$url[0].'.php');
				}else{
					header('Location: '.INCLUDE_PATH_USER);
				}
			}else{
				include('pages/home.php');
			}
		}

		public static function alert($tipo,$mensagem){
			if ($tipo == 'sucesso') {
				echo "<div class='box-alert sucesso'><i class='fa fa-check'></i> ".$mensagem."</div>";
			}elseif ($tipo == 'erro') {
				echo "<div class='box-alert erro'><i class='fa fa-close'></i> ".$mensagem."</div>";
			}else if($tipo = 'atencao'){
				echo "<div class='box-alert atencao'><i class='fa fa-warning'></i> ".$mensagem."</div>";
			}
		}

		public static function imagemValida($imagem){
			if($imagem['type'] == 'image/jpeg' ||
				$imagem['type'] == 'imagem/jpg' ||
				$imagem['type'] == 'imagem/png'){

				$tamanho = intval($imagem['size']/1024);
				if($tamanho < 900)
					return true;
				else
					return false;
			}else{
				return false;
			}
		}

		public static function uploadFile($file){
			$formatoArquivo = explode('.', $file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/'.$imagemNome)){
				return $imagemNome;
			}else{
				return false;
			}
		}

		public static function uploadFileComprovante($file){
			$formatoArquivo = explode('.', $file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/comprovantes/'.$imagemNome)){
				return $imagemNome;
			}else{
				return false;
			}
		}

		public static function deleteFile($file){
			@unlink('uploads/'.$file);
		}

		public static function deletar($tabela,$id){
			if ($id == false) {
				$sql = MySql::conectar()->prepare("DELETE FROM `$tabela`");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = '$id'");
			}
			$sql->execute();
		}


		public static function insert($arr){
			$certo = true;
			$nome_tabela = $arr['nome_tabela'];
			$query = "INSERT INTO `$nome_tabela` VALUES (null";

			foreach ($arry as $key => $value) {
				$nome = $key;
				$valor = $value;
				if ($nome == 'acao' || $nome == 'nome_tabela') 
					continue;

				if ($value == '') {
					$certo = false;
					break;
				}

				$query.=",?";
				$paramentros[] = $value;
			}

			$query .=")";
			if ($certo == true) {
				$sql = MySql::conectar()->prepare($query);
				$sql->execute($paramentros);
				$lastid = MySql::conectar()->lastInsertId();
				$sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $lastid");
				$sql->execute(array($lastid));
			}
			return $certo;
		}

		public static function select($table,$query,$arr){
			$sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
			$sql->execute($arr);
			return $sql->fetch();
		}

		public static function updateStatus($table,$set,$clause){
			$sql = MySql::conectar()->prepare("UPDATE `$table` SET $set WHERE $clause");
			$sql->execute();

		}

		public static function selectAll($table){
			$sql = MySql::conectar()->prepare("SELECT * FROM `$table`");
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function update($arr){
			$primeiro = false;
			$certo = true;
			$nome_tabela = $arr['nome_tabela'];

			$query = "UPDATE `$nome_tabela` SET ";
			foreach ($arr as $key => $value) {
				$nome = $key;
				$valor = $value;
				if ($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id') 
					continue;

				if ($value == '') {
						$certo = false;
						break;
				}
				
				if ($primeiro == false) {
					$primeiro = true;
					$query.="$nome=?";
				
				}else{
					$query.=",$nome=?";
				}

				$paramentros[] = $value;
			}

			if ($certo == true) {
				$paramentros[] = $arr['id'];
				$sql = MySql::conectar()->prepare($query.' WHERE id=?');
				$sql->execute($paramentros);
			}
			return $certo;
		}


		public static function getFaturamentoSeteDias(){
			$faturamentoSeteDias = MySql::conectar()->prepare("SELECT `total_pedido` FROM `tb_site.pedidos` WHERE status = 'entregue' OR status = 'entregue' AND data BETWEEN CURRENT_DATE()-7 AND CURRENT_DATE()");
			$faturamentoSeteDias->execute();
			return $faturamentoSeteDias->fetchAll();
		}

		public static function getFaturamentoTrintaDias(){
			$faturamentoTrintaDias = MySql::conectar()->prepare("SELECT `total_pedido` FROM `tb_site.pedidos` WHERE status = 'entregue' OR status = 'entregue' AND data BETWEEN CURRENT_DATE()-30 AND CURRENT_DATE()");
			$faturamentoTrintaDias->execute();
			return $faturamentoTrintaDias->fetchAll();
		}

		public static function getFaturamentoPedidosNaoProcessados(){
			$faturamentoTrintaDias = MySql::conectar()->prepare("SELECT `total_pedido` FROM `tb_site.pedidos` WHERE status = 'realizado'");
			$faturamentoTrintaDias->execute();
			return $faturamentoTrintaDias->fetchAll();
		}
                
                public static function setOnesignalId(){
                        if(isset($_POST['userId'])){
                            $userId = $_POST['userId'];
                            
                            $uid = $_SESSION['id'];
                            $query = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET onesignal_id = ? WHERE id = ?");
                            $query->execute($id, $uid); 
				
                        }else{
                                echo "ok";
                        }
                
                }
                
                public static function sendOnesignalNotification(){
                        /*
                        $qrUserId = MySql::conectar()->prepare("SELECT `onesignal_id` FROM `tb_admin.usuarios` WHERE permissao = 1");
                        $qrUserId->execute();
                        $qrUserId->fetch();
                        
                        $onesignal_id = $qrUserId;
                        
                        $content      = array(
                                "en" => 'ola mundo!',
                                "pt" => 'ola mundo!'
                            );
                            
                            $fields = array(
                                'app_id' => "f8e565c2-bed2-4b2c-a491-53d8e5856750",
                                'include_player_ids' => [$onesignal_id],
                                'data' => array(
                                    "foo" => "bar"
                                ),
                                'contents' => $content,
                            );
                            
                            $fields = json_encode($fields);
                           
                            
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic NGI3MDU1ZTYtMmYwNC00MGQ0LWFjYjAtNTI3YWM4MGUxNjVl'
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            curl_setopt($ch, CURLOPT_HEADER, FALSE);
                            curl_setopt($ch, CURLOPT_POST, TRUE);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                            
                            $response = curl_exec($ch);
                            curl_close($ch);
                            
                            return $response;
                            */
                
                }

	}

?>