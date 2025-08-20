-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/07/2025 às 22:26
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `artconnect`
--
CREATE DATABASE IF NOT EXISTS `artconnect` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `artconnect`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `artes`
--

CREATE TABLE IF NOT EXISTS `artes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `desconto` int(11) DEFAULT 0,
  `preco_final` decimal(10,2) DEFAULT NULL,
  `artista_id` int(11) NOT NULL,
  `data_publicacao` datetime DEFAULT current_timestamp(),
  `preco_promocao` decimal(10,2) DEFAULT 0.00,
  `promocao` bit(1) NOT NULL,
  `status` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_artista` (`artista_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `artes`
--

INSERT INTO `artes` (`id`, `titulo`, `descricao`, `imagem`, `preco`, `desconto`, `preco_final`, `artista_id`, `data_publicacao`, `preco_promocao`, `promocao`, `status`) VALUES
(1, 'aaa', 'AAAAA', '683042924ec07.jpg', 11.00, 0, NULL, 1, '2025-05-23 06:40:34', 0.00, b'0', b'1'),
(3, 'aaaa', 'aaaaaaaaaaa', '6830464f02806.png', 22.22, 0, NULL, 1, '2025-05-23 06:56:31', 0.00, b'0', b'0'),
(11, '1', '444', '6830b5d2d21b7.gif', 44.00, 0, 44.00, 1, '2025-05-23 14:52:18', 0.00, b'0', b'0'),
(13, 'quario', 'ssss', '6830be081e9a4.png', 387.61, 0, 387.61, 1, '2025-05-23 15:27:20', 0.00, b'0', b'0'),
(16, 'quario', '33', '6830c270bc6a7.gif', 55.00, 0, 55.00, 1, '2025-05-23 15:46:08', 0.00, b'0', b'0'),
(17, '1', '1', '6830cfa9a0ed0.png', 2.00, 0, 2.00, 1, '2025-05-23 16:42:33', 0.00, b'0', b'0'),
(18, 'quario', '7556', '6830cfe8f26f1.png', 90.00, 20, 72.00, 1, '2025-05-23 16:43:36', 18.00, b'0', b'0'),
(19, 'jjyyyuy', '88', '6830d075f2dd3.png', 35.00, 20, 28.00, 1, '2025-05-23 16:45:57', 7.00, b'0', b'0'),
(20, 'EU NAO AGUENTO MAAAAAAAAAAAAIS', 'eu aguentando', '6830d0d481fff.png', 74.00, 0, 74.00, 1, '2025-05-23 16:47:32', 0.00, b'0', b'0'),
(21, 'a', '0', '6830d14b02458.png', 0.00, 0, 0.00, 1, '2025-05-23 16:49:31', 0.00, b'0', b'0'),
(22, 'mamama', 'aaaa', 'OIP.jfif', 789.08, 0, 789.08, 1, '2025-05-23 16:52:53', 0.00, b'0', b'0'),
(23, 'capivara', 'capibaba', 'OIP.jfif', 124.57, 0, 124.57, 1, '2025-06-18 16:44:56', 0.00, b'0', b'0');

-- --------------------------------------------------------

--
-- Estrutura para tabela `arte_tag`
--

CREATE TABLE IF NOT EXISTS `arte_tag` (
  `mult_id` int(11) NOT NULL AUTO_INCREMENT,
  `arte_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`mult_id`),
  KEY `arte_id` (`arte_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `arte_tag`
--

INSERT INTO `arte_tag` (`mult_id`, `arte_id`, `tag_id`) VALUES
(1, 16, 3),
(2, 16, 2),
(3, 16, 5),
(4, 13, 3),
(5, 11, 2),
(6, 11, 5),
(7, 13, 2),
(8, 17, 2),
(9, 18, 4),
(10, 19, 2),
(11, 20, 2),
(12, 20, 3),
(13, 20, 4),
(14, 20, 5),
(15, 22, 5),
(16, 23, 1),
(17, 23, 10),
(18, 24, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargo`
--

CREATE TABLE IF NOT EXISTS `cargo` (
  `codigo_cargo` int(2) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `status` bit(1) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  PRIMARY KEY (`codigo_cargo`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargo`
--

INSERT INTO `cargo` (`codigo_cargo`, `nome`, `observacao`, `status`, `data_cadastro`) VALUES
(1, 'Moderador', 'Poder?', b'0', '2025-05-21 19:02:48'),
(2, 'JOSEFINO', 'AWAWAWA', b'1', '2025-05-23 16:01:49'),
(3, 'MARIA DO CARMO', 'A', b'1', '2025-05-23 16:01:56'),
(4, 'addsds', 'sasd', b'1', '2025-05-23 16:02:05'),
(6, 'aaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaa', b'1', '2025-06-03 14:57:56'),
(7, 'Marionetista', 'Marioneta', b'1', '2025-06-16 17:01:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE IF NOT EXISTS `funcionario` (
  `codigo_funcionario` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `nome_social` varchar(60) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `estado_civil` varchar(20) DEFAULT NULL,
  `cpf` char(14) NOT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `salario` decimal(7,2) DEFAULT NULL,
  `endereco` varchar(70) NOT NULL,
  `numero` int(4) NOT NULL,
  `complemento` varchar(40) DEFAULT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `estado` char(2) NOT NULL,
  `cep` char(9) DEFAULT NULL,
  `telefone_residencial` char(13) DEFAULT NULL,
  `telefone_celular` char(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` bit(1) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `senha` char(8) NOT NULL,
  `tipo_acesso` bit(1) NOT NULL,
  `foto` varchar(40) DEFAULT NULL,
  `codigo_cargo` int(2) DEFAULT NULL,
  PRIMARY KEY (`codigo_funcionario`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `codigo_cargo` (`codigo_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`codigo_funcionario`, `nome`, `nome_social`, `data_nascimento`, `sexo`, `estado_civil`, `cpf`, `rg`, `salario`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `telefone_residencial`, `telefone_celular`, `email`, `status`, `data_cadastro`, `usuario`, `senha`, `tipo_acesso`, `foto`, `codigo_cargo`) VALUES
(1, 'aaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaa', '2288-11-11', 'uf', 'solteiro', '111.111', '11.111.111-1', 111.11, 'Rua Maria Isabel da Silva Mattos', 605, 'casa', 'Loteamento Ipanema', 'Piracicaba / SP', 'SP', '13402-303', '(19) 9714-548', '(19) 97145-483', '1111111111@1', b'1', '2025-05-23 15:07:36', '141', '1111', b'1', '', 1),
(2, 'Uryan Diego Gonsales', 'Uryan Diego Gonsales', '2005-02-11', 'm', 'solteiro', '441.111.111-11', '11.111.444-4', 4444.44, 'Rua Maria Isabel da Silva Mattos', 605, 'casa', 'Loteamento Ipanema', 'Piracicaba / SP', 'PA', '13402-303', '(19) 9714-548', '(19) 97145-483', 'a@a44', b'1', '2025-05-23 15:15:07', '4444444442', '4444441', b'0', '', 1),
(3, 'Thomy Jando', 'Thomy Jando', '2001-11-19', 'n', 'solteiro', '222.222.222-22', '22.222.222-2', 244.42, 'Rua Maria Isabel da Silva Mattos', 605, 'casa', 'Loteamento Ipanema', 'Piracicaba / SP', 'SP', '13402-303', '(19) 9714-548', '(19) 97145-483', '33333@2', b'1', '2025-05-23 16:39:00', 'JorginhodaSilva69D4', '222', b'1', '', 3),
(7, 'Uryan Diego Gonsales', 'Uryan Diego Gonsales', '2005-02-11', 'm', 'solteiro', '441.211.111-11', '11.111.444-4', 4444.44, 'Rua Maria Isabel da Silva Mattos', 605, 'casa', 'Loteamento Ipanema', 'Piracicaba / SP', 'PA', '13402-303', '(19) 9714-548', '(19) 97145-483', 'a@a44', b'1', '2025-05-23 15:15:07', '4444445442', '4444441', b'0', '', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `apelido` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `ativo` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `status` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tags`
--

INSERT INTO `tags` (`id`, `nome`, `status`) VALUES
(1, 'Marlom', b'1'),
(2, 'tori', b'1'),
(3, 'deluubulu', b'1'),
(4, 'aaa', b'1'),
(5, 'uryan', b'1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `nome_social` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` bit(1) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `status` bit(1) DEFAULT b'1',
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `apelido` varchar(100) DEFAULT NULL,
  `sexo` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `nome_social`, `email`, `senha`, `tipo`, `cpf`, `rg`, `data_nascimento`, `foto`, `status`, `data_cadastro`, `apelido`, `sexo`) VALUES
(1, 'Uryan Diego Gonsales', 'aaaaaaaaaaaaaaaaa', 'comedor@decervos', '123', b'0', '444.444', '44.444.444-4', '2222-02-02', 'OIP.jfif', b'1', '2025-05-21 16:55:14', 'a', 'N'),
(3, 'deluubulu', 'aaaaaaaaaaaaaaaaa', 'comedor@decer', '123', b'0', '222.222.222-22', '22.222.222-2', '2222-02-22', 'photo_2025-05-04_09-18-12.jpg', b'1', '2025-05-22 15:23:24', 'Mentinha', 'F'),
(4, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaa@a', 'aaaa', b'0', '111.122.222-22', '46.777.777-7', '8811-07-14', '', b'1', '2025-06-03 16:28:24', 'aaaaaaaaaaaaaaaaaaaa', 'N'),
(5, '76543', '34567890', '1@11', '234567890', b'1', '234.567.890-76', '12.345.678-9', '2001-03-22', '', b'1', '2025-06-03 16:39:01', '23467890', 'M'),
(6, 'Thomy Jando', '', 'tomyjando@gmail.com', '123456789', b'1', '847.876.543-55', '76.546.995-6', '2012-01-19', '', b'1', '2025-06-16 14:43:12', '', 'M');

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `artes`
--
ALTER TABLE `artes`
  ADD CONSTRAINT `artes_ibfk_1` FOREIGN KEY (`artista_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_artista` FOREIGN KEY (`artista_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`codigo_cargo`) REFERENCES `cargo` (`codigo_cargo`);

--
-- Restrições para tabelas `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
