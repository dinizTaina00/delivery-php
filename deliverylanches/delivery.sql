-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 05-Abr-2023 às 14:43
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `delivery`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.dados_pagamento`
--

DROP TABLE IF EXISTS `tb_admin.dados_pagamento`;
CREATE TABLE IF NOT EXISTS `tb_admin.dados_pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `metodo_pagamento` varchar(50) NOT NULL,
  `beneficiario` varchar(255) NOT NULL,
  `cpf_beneficiario` varchar(15) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `conta` int NOT NULL,
  `agencia` int NOT NULL,
  `tipo_conta` varchar(20) NOT NULL,
  `chave_pix` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.despesas`
--

DROP TABLE IF EXISTS `tb_admin.despesas`;
CREATE TABLE IF NOT EXISTS `tb_admin.despesas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mes` varchar(15) NOT NULL,
  `ano` int NOT NULL,
  `total_despesa` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.faturamento`
--

DROP TABLE IF EXISTS `tb_admin.faturamento`;
CREATE TABLE IF NOT EXISTS `tb_admin.faturamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mes` varchar(11) NOT NULL,
  `ano` int NOT NULL,
  `valor_faturado` double NOT NULL,
  `total_dinheiro` double NOT NULL,
  `total_debito` double NOT NULL,
  `total_credito` double NOT NULL,
  `despesas` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.faturamento`
--

INSERT INTO `tb_admin.faturamento` (`id`, `mes`, `ano`, `valor_faturado`, `total_dinheiro`, `total_debito`, `total_credito`, `despesas`) VALUES
(21, '03', 2022, 17, 17, 0, 0, 31);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.itens_despesa_isoladas`
--

DROP TABLE IF EXISTS `tb_admin.itens_despesa_isoladas`;
CREATE TABLE IF NOT EXISTS `tb_admin.itens_despesa_isoladas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_despesa` varchar(100) NOT NULL,
  `valor` double NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.itens_despesa_isoladas`
--

INSERT INTO `tb_admin.itens_despesa_isoladas` (`id`, `item_despesa`, `valor`, `data`) VALUES
(1, 'Conserto da geladeira', 100, '2022-03-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.itens_despesa_mensal`
--

DROP TABLE IF EXISTS `tb_admin.itens_despesa_mensal`;
CREATE TABLE IF NOT EXISTS `tb_admin.itens_despesa_mensal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_despesa` varchar(100) NOT NULL,
  `valor` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.itens_despesa_mensal`
--

INSERT INTO `tb_admin.itens_despesa_mensal` (`id`, `item_despesa`, `valor`) VALUES
(1, 'Fucionário', 500),
(2, 'Aluguel', 700),
(3, 'Plano de internet', 100);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.itens_relatorio_despesas`
--

DROP TABLE IF EXISTS `tb_admin.itens_relatorio_despesas`;
CREATE TABLE IF NOT EXISTS `tb_admin.itens_relatorio_despesas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mes` varchar(15) NOT NULL,
  `ano` varchar(10) NOT NULL,
  `valor` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.metodos_pagamento`
--

DROP TABLE IF EXISTS `tb_admin.metodos_pagamento`;
CREATE TABLE IF NOT EXISTS `tb_admin.metodos_pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `metodo_pagamento` varchar(50) NOT NULL,
  `beneficiario` varchar(150) NOT NULL,
  `cpf_beneficiario` varchar(15) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `conta` varchar(20) NOT NULL,
  `agencia` varchar(20) NOT NULL,
  `tipo_conta` varchar(25) NOT NULL,
  `chave_pix` varchar(255) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.metodos_pagamento`
--

INSERT INTO `tb_admin.metodos_pagamento` (`id`, `metodo_pagamento`, `beneficiario`, `cpf_beneficiario`, `banco`, `conta`, `agencia`, `tipo_conta`, `chave_pix`, `status`) VALUES
(1, 'pix', 'Tainã Machado', '', 'Nu Pagamentos', '', '', 'Corrente', '123456789', 1),
(2, 'dinheiro', '', '', '', '', '', '', '', 1),
(3, 'cartao de credito', '', '', '', '', '', '', '', 1),
(4, 'cartao de debito', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.online`
--

DROP TABLE IF EXISTS `tb_admin.online`;
CREATE TABLE IF NOT EXISTS `tb_admin.online` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `ultima_acao` datetime NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.online`
--

INSERT INTO `tb_admin.online` (`id`, `ip`, `ultima_acao`, `token`) VALUES
(5, '::1', '2021-03-10 12:06:19', '6048cd57289cd'),
(6, '::1', '2021-03-11 15:55:01', '604a67851ddb3');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.relatorio_despesas`
--

DROP TABLE IF EXISTS `tb_admin.relatorio_despesas`;
CREATE TABLE IF NOT EXISTS `tb_admin.relatorio_despesas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mes` varchar(15) NOT NULL,
  `ano` varchar(10) NOT NULL,
  `valor_total` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.relatorio_despesas`
--

INSERT INTO `tb_admin.relatorio_despesas` (`id`, `mes`, `ano`, `valor_total`) VALUES
(2, '03', '2022', 1400);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.usuarios`
--

DROP TABLE IF EXISTS `tb_admin.usuarios`;
CREATE TABLE IF NOT EXISTS `tb_admin.usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `permissao` int NOT NULL,
  `contato` varchar(20) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.usuarios`
--

INSERT INTO `tb_admin.usuarios` (`id`, `user`, `password`, `nome`, `permissao`, `contato`, `rua`, `numero`, `bairro`, `complemento`) VALUES
(5, 'admin', 'admin', 'Tainã Machado', 1, '', '', '', '', ''),
(18, 'taina', '123', 'Tainã Machado', 0, '', 'Rua ', '358', 'Gaúcha', 'casa'),
(20, 'Wagner', '1234', 'Wagner', 0, '', '', '', '', ''),
(21, 'Carine', 'manu', 'Carine Lima', 0, '', '', '', '', ''),
(23, 'johnwick', '12345', 'John Wick', 0, '', 'Ernani', '358', 'Gaúcha', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.visitas`
--

DROP TABLE IF EXISTS `tb_admin.visitas`;
CREATE TABLE IF NOT EXISTS `tb_admin.visitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `dia` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_admin.visitas`
--

INSERT INTO `tb_admin.visitas` (`id`, `ip`, `dia`) VALUES
(1, '::1', '2021-02-27'),
(2, '::1', '2021-02-27'),
(3, '::1', '2021-02-27'),
(4, '::1', '2021-02-27'),
(5, '::1', '2021-02-27'),
(6, '::1', '2021-02-27'),
(7, '::1', '2021-03-05'),
(8, '::1', '2021-03-10'),
(9, '::1', '2021-03-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.categorias`
--

DROP TABLE IF EXISTS `tb_site.categorias`;
CREATE TABLE IF NOT EXISTS `tb_site.categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_site.categorias`
--

INSERT INTO `tb_site.categorias` (`id`, `nome`) VALUES
(14, 'Xis'),
(15, 'Refrigerante'),
(17, 'Sanduiches'),
(18, 'Hamburguer');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.compras_estoque`
--

DROP TABLE IF EXISTS `tb_site.compras_estoque`;
CREATE TABLE IF NOT EXISTS `tb_site.compras_estoque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `valor` double NOT NULL,
  `produto` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `tb_site.compras_estoque`
--

INSERT INTO `tb_site.compras_estoque` (`id`, `data`, `valor`, `produto`, `quantidade`) VALUES
(8, '2022-03-09', 15.5, 'Pão', 300),
(9, '2022-03-10', 15.6, 'Tomate', 80);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.dias_funcionamento`
--

DROP TABLE IF EXISTS `tb_site.dias_funcionamento`;
CREATE TABLE IF NOT EXISTS `tb_site.dias_funcionamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dia_semana` varchar(20) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.estoque`
--

DROP TABLE IF EXISTS `tb_site.estoque`;
CREATE TABLE IF NOT EXISTS `tb_site.estoque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `quantidade_atual` int NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.imagens_site`
--

DROP TABLE IF EXISTS `tb_site.imagens_site`;
CREATE TABLE IF NOT EXISTS `tb_site.imagens_site` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagem_logo` varchar(255) DEFAULT NULL,
  `imagem_banner` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_site.imagens_site`
--

INSERT INTO `tb_site.imagens_site` (`id`, `imagem_logo`, `imagem_banner`) VALUES
(2, '607a1c5280c52.jpg', '607a1c58a8fdb.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.informacoes_site`
--

DROP TABLE IF EXISTS `tb_site.informacoes_site`;
CREATE TABLE IF NOT EXISTS `tb_site.informacoes_site` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_negocio` varchar(255) DEFAULT NULL,
  `cnpj` varchar(25) DEFAULT NULL,
  `retirar_local` text,
  `rua` text,
  `numero` int DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `cep` varchar(11) DEFAULT NULL,
  `horaInicio` time DEFAULT NULL,
  `horaTermino` time DEFAULT NULL,
  `valor_entrega` double DEFAULT NULL,
  `fretegratis_apartir` double NOT NULL,
  `sobre` varchar(255) NOT NULL,
  `instagram` varchar(50) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `frase_efeito` varchar(255) NOT NULL,
  `contato` varchar(14) NOT NULL,
  `disponivel` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_site.informacoes_site`
--

INSERT INTO `tb_site.informacoes_site` (`id`, `nome_negocio`, `cnpj`, `retirar_local`, `rua`, `numero`, `bairro`, `cidade`, `cep`, `horaInicio`, `horaTermino`, `valor_entrega`, `fretegratis_apartir`, `sobre`, `instagram`, `facebook`, `frase_efeito`, `contato`, `disponivel`) VALUES
(12, 'Notus Lanches', '', 'sim', 'Vaz Ferreira', 300, 'Centro', 'Tupan', '98170-000', '19:00:00', '03:00:00', 7, 0, 'O melhor lanche da cidade aqui para você.', '', '', '', '55997330222', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.numeros_contato`
--

DROP TABLE IF EXISTS `tb_site.numeros_contato`;
CREATE TABLE IF NOT EXISTS `tb_site.numeros_contato` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contato` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.pagamentos`
--

DROP TABLE IF EXISTS `tb_site.pagamentos`;
CREATE TABLE IF NOT EXISTS `tb_site.pagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `comprovante` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.pedidos`
--

DROP TABLE IF EXISTS `tb_site.pedidos`;
CREATE TABLE IF NOT EXISTS `tb_site.pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `id_user` int NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `entrega` varchar(20) NOT NULL,
  `valor_entrega` double NOT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero_casa` varchar(10) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `pagamento` varchar(50) NOT NULL,
  `total_pedido` double NOT NULL,
  `troco` double NOT NULL,
  `status` varchar(50) NOT NULL,
  `comprovante` varchar(255) NOT NULL,
  `tempo_estimado` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_site.pedidos`
--

INSERT INTO `tb_site.pedidos` (`id`, `data`, `hora`, `id_user`, `nome_cliente`, `entrega`, `valor_entrega`, `rua`, `numero_casa`, `bairro`, `complemento`, `pagamento`, `total_pedido`, `troco`, `status`, `comprovante`, `tempo_estimado`) VALUES
(56, '2022-03-15', '20:37:37', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(57, '2022-03-15', '20:45:24', 18, 'Tainã Machado', 'sim', 7, 'Rua ', '358', 'Gaúcha', 'casa', 'cartao de debito', 24, 0, 'realizado', '', '20'),
(58, '2022-03-15', '20:48:38', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(59, '2022-03-15', '20:49:47', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(60, '2022-03-15', '20:50:57', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'cartao de debito', 17, 0, 'realizado', '', '20'),
(61, '2022-03-15', '21:00:40', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(62, '2022-03-15', '21:03:53', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(63, '2022-03-15', '21:04:00', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(64, '2022-03-15', '21:04:14', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(65, '2022-03-15', '21:05:16', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'realizado', '', '20'),
(66, '2022-03-15', '21:27:22', 18, 'Tainã Machado', 'nao', 0, '', '', '', '', 'dinheiro', 17, 0, 'entregue', '', '20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.produtos`
--

DROP TABLE IF EXISTS `tb_site.produtos`;
CREATE TABLE IF NOT EXISTS `tb_site.produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `preco` double NOT NULL,
  `ingredientes` varchar(255) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `img` varchar(255) NOT NULL,
  `tempo` int NOT NULL,
  `status` int NOT NULL,
  `disponivel` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_site.produtos`
--

INSERT INTO `tb_site.produtos` (`id`, `nome`, `preco`, `ingredientes`, `categoria`, `img`, `tempo`, `status`, `disponivel`) VALUES
(18, 'Hamburguer Monstro', 17, 'Pão Tomate Ervilha Alface ', 'Hamburguer', '607a1b63a0189.jpg', 10, 1, 0),
(21, 'Xis Simples', 15, 'Pão Tomate Cebola ', 'Xis', '622ecab12ef2e.jpg', 10, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.produtos_estoque`
--

DROP TABLE IF EXISTS `tb_site.produtos_estoque`;
CREATE TABLE IF NOT EXISTS `tb_site.produtos_estoque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `quantidade` int NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `tb_site.produtos_estoque`
--

INSERT INTO `tb_site.produtos_estoque` (`id`, `nome`, `quantidade`, `status`) VALUES
(1, 'Pão', 300, 1),
(2, 'Tomate', 80, 1),
(3, 'Cebola', 0, 1),
(5, 'Milho', 0, 1),
(6, 'Ervilha', 0, 1),
(7, 'Alface', 0, 1),
(8, 'Maionese', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site.produtos_pedido`
--

DROP TABLE IF EXISTS `tb_site.produtos_pedido`;
CREATE TABLE IF NOT EXISTS `tb_site.produtos_pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `id_produto` int NOT NULL,
  `produto_nome` varchar(50) NOT NULL,
  `produto_categoria` varchar(50) NOT NULL,
  `produto_preco` double NOT NULL,
  `ingredientes` varchar(255) NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_site.produtos_pedido`
--

INSERT INTO `tb_site.produtos_pedido` (`id`, `id_pedido`, `id_produto`, `produto_nome`, `produto_categoria`, `produto_preco`, `ingredientes`, `quantidade`) VALUES
(61, 56, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(62, 57, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(63, 58, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(64, 59, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(65, 60, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(66, 61, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(67, 62, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(68, 63, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(69, 64, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(70, 65, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(71, 66, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 1),
(72, 67, 18, 'Hamburguer Monstro', 'Hamburguer', 17, 'Pão Tomate Ervilha Alface ', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
