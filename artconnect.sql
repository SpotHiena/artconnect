-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/09/2025 às 12:41
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `artes`
--

INSERT INTO `artes` (`id`, `titulo`, `descricao`, `imagem`, `preco`, `desconto`, `preco_final`, `artista_id`, `data_publicacao`, `preco_promocao`, `promocao`, `status`) VALUES
(1, 'Aurora Mágica', 'Uma pintura digital com cores vibrantes', 'aurora.jpg', 150.00, 10, 135.00, 1, '2025-08-01 10:00:00', 5.00, b'1', b'1'),
(3, 'Labirinto Místico', 'Ilustração detalhada de labirinto', 'labirinto.jpg', 300.00, 15, 255.00, 5, '2025-08-17 13:35:00', 20.00, b'1', b'1'),
(11, 'Noite Estrelada', 'Pintura inspirada em Van Gogh', 'noite.jpg', 200.00, 0, 200.00, 3, '2025-08-02 11:00:00', 0.00, b'0', b'1'),
(13, 'Céu em Chamas', 'Uma ilustração digital com tons quentes', 'ceo.png', 180.00, 20, 144.00, 3, '2025-08-03 12:30:00', 10.00, b'1', b'1'),
(16, 'Floresta Encantada', 'Arte inspirada em contos de fadas', 'floresta.jpg', 220.00, 0, 220.00, 4, '2025-08-04 09:15:00', 0.00, b'0', b'1'),
(17, 'Cidade Futurista', 'Ilustração de uma cidade futurística', 'cidade.jpg', 300.00, 15, 255.00, 5, '2025-08-05 14:45:00', 20.00, b'1', b'1'),
(18, 'Mar Profundo', 'Cena subaquática em aquarela', 'mar.jpg', 130.00, 0, 130.00, 6, '2025-08-06 16:20:00', 0.00, b'0', b'1'),
(19, 'Rosas Vermelhas', 'Arranjo de flores pintado à mão', 'rosa.jpg', 90.00, 10, 81.00, 7, '2025-08-07 08:50:00', 5.00, b'1', b'1'),
(20, 'Dragão Imponente', 'Desenho de dragão em pose heroica', 'dragao.jpg', 250.00, 25, 187.50, 27, '2025-08-08 11:30:00', 15.00, b'1', b'1'),
(21, 'Pôr do Sol', 'Ilustração digital com tons quentes', 'sol.jpg', 120.00, 0, 120.00, 9, '2025-08-09 13:00:00', 0.00, b'0', b'1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `arte_tag`
--

CREATE TABLE IF NOT EXISTS `arte_tag` (
  `mult_id` int(11) NOT NULL AUTO_INCREMENT,
  `arte_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`mult_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(18, 24, 10),
(19, 28, 1),
(20, 29, 8),
(21, 30, 8);

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
  PRIMARY KEY (`codigo_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargo`
--

INSERT INTO `cargo` (`codigo_cargo`, `nome`, `observacao`, `status`, `data_cadastro`) VALUES
(1, 'Gerente de Projetos', 'Responsável pela gestão de projetos', b'1', '2023-01-10 09:00:00'),
(2, 'Analista de Marketing', 'Planejamento e execução de campanhas', b'1', '2023-02-15 10:00:00'),
(3, 'Designer Gráfico', 'Criação de artes e peças visuais', b'1', '2023-03-20 11:30:00'),
(4, 'Desenvolvedor Web', 'Desenvolvimento de sites e sistemas', b'1', '2023-04-25 14:15:00'),
(5, 'Analista de Sistemas', 'Suporte e manutenção de sistemas', b'1', '2023-05-30 15:45:00'),
(6, 'Assistente Administrativo', 'Suporte administrativo e documentação', b'1', '2023-06-05 08:30:00'),
(8, 'Redator', 'Produção de textos e conteúdos', b'1', '2023-08-18 10:20:00'),
(9, 'Fotógrafo', 'Registro fotográfico e tratamento de imagens', b'1', '2023-09-22 11:10:00'),
(10, 'Especialista em SEO', 'Otimização de sites para motores de busca', b'1', '2023-10-30 12:00:00'),
(11, 'Coordenador de Eventos', 'Planejamento e coordenação de eventos', b'1', '2023-11-15 13:25:00'),
(12, 'Assistente de RH', 'Recrutamento, seleção e folha de pagamento', b'1', '2023-12-05 14:40:00'),
(13, 'Programador Mobile', 'Desenvolvimento de aplicativos móveis', b'1', '2024-01-08 15:55:00'),
(14, 'Editor de Vídeo', 'Edição e pós-produção de vídeos', b'1', '2023-07-12 09:50:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato`
--

CREATE TABLE IF NOT EXISTS `contato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `rede` varchar(50) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `icone` varchar(100) DEFAULT NULL,
  `artista_rede` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contato_usuario` (`artista_rede`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contato`
--

INSERT INTO `contato` (`id`, `nome`, `rede`, `status`, `icone`, `artista_rede`, `url`) VALUES
(11, 'bb', 'facebook', b'1', NULL, 3, NULL),
(12, 'cu gozado', 'twitter', b'1', NULL, 3, 'https://x.com/EguaESuaMae'),
(13, 'cuzo', 'inkbunny', b'1', NULL, 3, ''),
(14, 'cuzao', 'furaffinity', b'1', NULL, 3, ''),
(16, 'AAG', 'PINTREST', b'1', NULL, 3, ''),
(17, 'CG', 'WHATSAPP', b'1', NULL, 3, ''),
(18, 'tori', 'x', b'1', NULL, 3, ''),
(19, 'x', 'X', b'1', NULL, 3, ''),
(20, 'twitter', 'twitter', b'1', NULL, 3, ''),
(21, 'a', 'X', b'1', NULL, 3, '');

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
  PRIMARY KEY (`codigo_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`codigo_funcionario`, `nome`, `nome_social`, `data_nascimento`, `sexo`, `estado_civil`, `cpf`, `rg`, `salario`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `telefone_residencial`, `telefone_celular`, `email`, `status`, `data_cadastro`, `usuario`, `senha`, `tipo_acesso`, `foto`, `codigo_cargo`) VALUES
(1, 'Roberto Mendes', 'Beto Mendes', '1985-07-12', 'M', 'Casado', '123.456.789-00', 'MG-12.345.67', 7200.50, 'Rua das Palmeiras', 120, 'Apto 101', 'Centro', 'Belo Horizonte', 'MG', '30123-456', '(31) 3333-444', '(31) 98877-665', 'roberto.mendes@example.com', b'1', '2023-08-15 08:00:00', 'rmendes', 'rob12345', b'1', 'perfil_roberto.jpg', 1),
(2, 'Juliana Ramos', 'Ju Ramos', '1990-03-25', 'F', 'Solteira', '234.567.890-11', 'SP-23.456.78', 4800.00, 'Avenida Paulista', 900, 'Sala 502', 'Bela Vista', 'São Paulo', 'SP', '01310-100', '(11) 3333-555', '(11) 97555-889', 'juliana.ramos@example.com', b'1', '2023-05-03 09:30:00', 'jramos', 'juliana4', b'0', 'perfil_juliana.jpg', 2),
(3, 'Fernando Costa', 'Nando Costa', '1988-11-10', 'M', 'Casado', '345.678.901-22', 'RJ-34.567.89', 4300.00, 'Rua das Laranjeiras', 45, 'Casa', 'Laranjeiras', 'Rio de Janeiro', 'RJ', '22240-001', '(21) 2222-333', '(21) 98888-223', 'fernando.costa@example.com', b'1', '2023-01-10 10:00:00', 'fcosta', 'fernando', b'0', 'perfil_fernando.jpg', 3),
(4, 'Mariana Lopes', 'Mari Lopes', '1992-05-14', 'F', 'Solteira', '456.789.012-33', 'SC-45.678.90', 5200.50, 'Rua Hercílio Luz', 78, 'Apto 202', 'Centro', 'Florianópolis', 'SC', '88010-001', '(48) 3333-444', '(48) 99999-111', 'mariana.lopes@example.com', b'1', '2023-07-18 08:45:00', 'mlopes', 'mari2025', b'1', 'perfil_mari.jpg', 4),
(6, 'Patrícia Martins', 'Pat Martins', '1995-08-17', 'F', 'Solteira', '678.901.234-55', 'PE-67.890.12', 3500.00, 'Rua do Sol', 150, 'Casa', 'Boa Vista', 'Recife', 'PE', '50030-000', '(81) 3333-666', '(81) 97555-667', 'patricia.martins@example.com', b'1', '2023-02-12 08:30:00', 'pmartins', 'paty3210', b'0', 'perfil_patricia.jpg', 6),
(7, 'Bruno Souza', 'Bruninho Souza', '1993-02-28', 'M', 'Solteiro', '789.012.345-66', 'MA-78.901.23', 4200.00, 'Rua das Flores', 25, 'Apto 305', 'Centro', 'São Luís', 'MA', '65010-001', '(98) 3333-777', '(98) 98888-334', 'bruno.souza@example.com', b'1', '2023-11-05 10:15:00', 'bsouza', 'bruno654', b'0', 'perfil_bruno.jpg', 7),
(8, 'Uryan Diego Gonsales', 'Uryan Diego Gonsales', '2005-02-11', 'm', 'solteiro', '441.181.111-11', '11.011.444-4', 4444.44, 'Rua Maria Isabel da Silva Mattos', 605, 'casa', 'Loteamento Ipanema', 'Piracicaba / SP', 'PA', '13402-303', '(19) 9714-548', '(19) 97145-483', 'uryan@senac.com', b'1', '2025-05-23 15:15:07', '4444484442', '1111', b'0', '8.png', 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `status` bit(1) NOT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tags`
--

INSERT INTO `tags` (`id`, `nome`, `status`, `observacao`) VALUES
(1, 'Arte Digital', b'1', 'Trabalhos criados digitalmente'),
(2, 'Pintura', b'1', 'Obras feitas com tinta em tela'),
(3, 'Escultura', b'1', 'Trabalhos tridimensionais em diversos materiais'),
(4, 'Fotografia', b'1', 'Captura e edição de fotos'),
(5, 'Ilustração', b'1', 'Desenhos manuais ou digitais'),
(8, 'Artesanato', b'1', 'Trabalhos manuais e feitos à mão'),
(9, 'aaaaa', b'0', '1'),
(10, 'Bryan BANHADO', b'1', '1');

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
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` bit(1) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `apelido` varchar(50) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `cidade` varchar(40) NOT NULL,
  `estado` char(2) NOT NULL,
  `rede_artista` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_cpf` (`cpf`),
  KEY `fk_usuario_contato` (`rede_artista`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `nome_social`, `email`, `senha`, `tipo`, `cpf`, `rg`, `data_nascimento`, `foto`, `status`, `data_cadastro`, `apelido`, `sexo`, `descricao`, `cidade`, `estado`, `rede_artista`) VALUES
(1, 'Lucas Pereira', '', 'lucas.pereira@example.com', 'abc123xyz', b'0', '444.444', '44.444.444-4', '1995-07-12', '1.jpeg', b'1', '2025-05-21 16:55:14', 'Lukinhaz', 'M', 'Apaixonado por arte e tecnologia.', 'Belo Horizonte', 'MG', NULL),
(3, 'Mariana Lopes', 'Mari Lopes', 'mariana.lopes@example.com', 'mari2025', b'0', '222.222.222-22', '22.222.222-2', '1997-11-05', '6.jpeg', b'1', '2025-05-22 15:23:24', 'MariBee', 'F', 'Designer gráfica e pintora digital.', 'Florianópolis', 'SC', NULL),
(4, 'Carlos Henrique', 'Firo Pellegrini', 'carlos.henrique@example.com', 'senha123', b'0', '111.122.222-22', '46.777.777-7', '1990-01-18', '2.png', b'1', '2025-06-03 16:28:24', 'Carlão', 'M', 'Administrador de sistemas e gamer nas horas vagas.', 'Curitiba', 'PR', NULL),
(5, 'Beatriz Ramos', NULL, 'beatriz.ramos@example.com', 'beatriz789', b'1', '234.567.890-76', '12.345.678-9', '2000-09-10', '7.jpeg', b'1', '2025-06-03 16:39:01', 'BiaR', 'F', 'Fotógrafa e criadora de conteúdo.', 'Piracicaba', 'SP', NULL),
(6, 'Gabriel Santos', '', 'gabriel.santos@example.com', 'gabriel321', b'1', '847.876.543-55', '76.546.995-6', '1996-06-22', '8.jpeg', b'1', '2025-06-16 14:43:12', 'Gabi', 'M', 'Músico e ilustrador amador.', 'Salvador', 'BA', NULL),
(7, 'Juliana Pacheco', '', 'juliana.pacheco@example.com', 'ju2025!', b'1', '222.333.525-44', '4444424444', '1999-04-12', '9.jpeg', b'1', '2025-07-16 00:10:53', 'JuP', 'F', 'Artista plástica e escultora.', 'Fortaleza', 'CE', NULL),
(9, 'Patrícia Martins', '', 'patricia.martins@example.com', 'paty456', b'1', '227.222.222-22', '22.222.222-2', '2001-08-17', '10.jpg', b'1', '2025-07-16 00:30:01', 'Paty', 'F', 'Artista digital especializada em ilustrações 3D.', 'Recife', 'PE', NULL),
(14, 'Tiago Lima', '', 'tiago.lima@example.com', 'tig789', b'1', '545.542.465-76', '55.576.767-6', '1994-05-30', '4.jpeg', b'1', '2025-07-26 12:52:47', 'Tig', 'M', 'Designer de jogos e animador.', 'Manaus', 'AM', NULL),
(27, 'Iuri Montebelo', '', 'iurimvo@gmail.com', '111', b'1', '222.626.620-02', '62.666.266-0', '1798-12-19', '', b'1', '2025-08-15 13:31:49', 'IuriMTB', 'M', 'Musico, professor, e uma pessoa altamente dedicada', 'Piracicaba', 'SP', NULL);

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
-- Restrições para tabelas `contato`
--
ALTER TABLE `contato`
  ADD CONSTRAINT `fk_contato_usuario` FOREIGN KEY (`artista_rede`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuario_contato` FOREIGN KEY (`rede_artista`) REFERENCES `contato` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
