<?php  
					if (isset($_POST['addCart'])) {

						$img = $_POST['imgProduto'];
						$preco = $_POST['precoProduto'];
						$nome = $_POST['nomeProduto'];
						$categoria = $_POST['categoriaProduto'];
						$quantidade = $_POST['quantidade'];
						$ingredientes = $_POST['ingredientes'];
						$idProduto = (int)$_POST['idProduto'];
						$tempo = $_POST['tempo_estimado'];

						$itemArray = array($idProduto=>array('id'=>$idProduto, 'ingredientes'=>$ingredientes, 'quantidade'=>$quantidade, 'nomeProduto'=>$nome, 'categoriaProduto'=>$categoria, 'preco'=>$preco, 'tempo'=>$tempo, 'img'=>$img));

							if (!empty($_SESSION['carrinho'])) {
								if (in_array($idProduto, array_keys($_SESSION['carrinho']))) {
									foreach ($_SESSION['carrinho'] as $key => $value) {
										if ($idProduto == $key) {
											if (empty($_SESSION['carrinho'][$key]['quantidade'])) {
												$_SESSION['carrinho'][$key]['quantidade'] = 0;
											}
											$_SESSION['carrinho'][$key]['quantidade'] += $quantidade;
										}
									}
								} else{
									$_SESSION['carrinho'] = array_merge($_SESSION['carrinho'],$itemArray);
								}
							} else{
								$_SESSION['carrinho'] = $itemArray;
							}

							echo '<script>window.location="'.INCLUDE_PATH_USER.'cart"</script>';
					}
				?>
