-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 10-Set-2019 às 10:37
-- Versão do servidor: 10.3.14-MariaDB
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forummgy`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `idAdmin` int(11) NOT NULL,
  `nickAdmin` varchar(50) COLLATE utf8_bin NOT NULL,
  `lvlAdmin` int(11) NOT NULL,
  `funcaoAdmin` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alertas`
--

DROP TABLE IF EXISTS `alertas`;
CREATE TABLE IF NOT EXISTS `alertas` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `texto` varchar(50) COLLATE utf8_bin NOT NULL,
  `cor` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `alertas`
--

INSERT INTO `alertas` (`id`, `texto`, `cor`) VALUES
(1, 'OFERTAO', 'success'),
(2, 'NOVO', 'danger'),
(3, 'QUEIMA', 'warning'),
(4, 'NIVER', 'info');

-- --------------------------------------------------------

--
-- Estrutura da tabela `banidos`
--

DROP TABLE IF EXISTS `banidos`;
CREATE TABLE IF NOT EXISTS `banidos` (
  `idBan` int(12) NOT NULL AUTO_INCREMENT,
  `idForum` int(12) NOT NULL,
  `ip` varchar(50) NOT NULL,
  UNIQUE KEY `id` (`idBan`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cash`
--

DROP TABLE IF EXISTS `cash`;
CREATE TABLE IF NOT EXISTS `cash` (
  `id` int(12) NOT NULL,
  `status` varchar(50) COLLATE utf8_bin NOT NULL,
  `nickPainel` varchar(50) COLLATE utf8_bin NOT NULL,
  `idUser` int(11) NOT NULL,
  `nickServer` varchar(50) COLLATE utf8_bin NOT NULL,
  `data` varchar(50) COLLATE utf8_bin NOT NULL,
  `dataAti` varchar(50) COLLATE utf8_bin NOT NULL,
  `metodoPagamento` varchar(50) COLLATE utf8_bin NOT NULL,
  `valor` int(11) NOT NULL,
  `opcoes` varchar(50) COLLATE utf8_bin NOT NULL,
  `indicado` varchar(50) COLLATE utf8_bin NOT NULL,
  `serverNota` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `cash`
--

INSERT INTO `cash` (`id`, `status`, `nickPainel`, `idUser`, `nickServer`, `data`, `dataAti`, `metodoPagamento`, `valor`, `opcoes`, `indicado`, `serverNota`) VALUES
(1, 'Aprovado', 'Thur_MaliGnY', 1, 'Thur_MaliGnY', '19/07/2019', '20/07/2019', 'MercadoPago', 60, 'Cash, Familia Comum', 'Theus_Crazzy', '10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) COLLATE utf8_bin NOT NULL,
  `produtos` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `produtos`) VALUES
(1, 'Canecas', 2),
(2, 'Camisas', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `idProcess` int(12) NOT NULL DEFAULT 0,
  `userID` int(12) NOT NULL DEFAULT 0,
  `comentario` text COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `data` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `hora` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `editado` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`id`, `idProcess`, `userID`, `comentario`, `ip`, `data`, `hora`, `editado`) VALUES
(1, 6, 1, '<p>ASSDASDASDD</p>', '::1', '02/08/2019', '02:51:50', 0),
(2, 6, 1, '<p>ASSDASDASDD</p>', '::1', '02/08/2019', '02:51:55', 0),
(3, 6, 3, 'asdadsadsadsadsadsads', '0', '0', '0', 0),
(4, 6, 1, '<p>adsadssdasdasddsadsa</p>', '::1', '02/08/2019', '03:03:38', 0),
(5, 6, 1, '<p>dsasdasdasdasdasd</p>', '::1', '02/08/2019', '03:03:51', 0),
(6, 6, 3, '<p>aasasadsasd</p><p><br></p>', '::1', '04/08/2019', '04:54:30', 0),
(7, 7, 1, '<p>vsf&nbsp;</p>', '::1', '21/08/2019', '21:47:30', 0),
(8, 9, 1, '<p>adsasdasd</p>', '::1', '27/08/2019', '21:18:47', 0),
(9, 8, 1, '<div class=\"alert alert-warning alert-dismissible\"><h5><i class=\"icon fas fa-eye-slash\"></i> Este processo se encontra em modo oculto.</h5></div>', '::1', '27/08/2019', '22:32:07', 0),
(10, 9, 1, '<p><br></p>', '::1', '27/08/2019', '22:32:41', 0),
(11, 9, 1, '<div class=\"alert alert-warning alert-dismissible\"><h5><i class=\"icon fas fa-eye-slash\"></i> Este processo se encontra em modo oculto.</h5></div>', '::1', '27/08/2019', '22:33:09', 0),
(12, 15, 1, '<p><br></p>', '::1', '27/08/2019', '23:02:08', 0),
(13, 8, 1, '27c47b28fb5f4545bda5d276ab55d84ccf9cc790581904c72fecdb4d623ce049396a14ab206e2b44e03c4e00393e948cce36a6b0f0d7489cb46d944b33ad51c8', '::1', '28/08/2019', '02:20:37', 0),
(14, 8, 1, '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8', '::1', '27/08/2019', '23:25:07', 0),
(15, 8, 1, '27c47b28fb5f4545bda5d276ab55d84ccf9cc790581904c72fecdb4d623ce049396a14ab206e2b44e03c4e00393e948cce36a6b0f0d7489cb46d944b33ad51c8', '::1', '28/08/2019', '02:25:25', 0),
(16, 8, 1, '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8', '::1', '27/08/2019', '23:25:37', 0),
(17, 8, 1, '27c47b28fb5f4545bda5d276ab55d84ccf9cc790581904c72fecdb4d623ce049396a14ab206e2b44e03c4e00393e948cce36a6b0f0d7489cb46d944b33ad51c8', '::1', '27/08/2019', '23:26:19', 0),
(18, 8, 1, '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8', '::1', '27/08/2019', '23:26:54', 0),
(19, 8, 1, '27c47b28fb5f4545bda5d276ab55d84ccf9cc790581904c72fecdb4d623ce049396a14ab206e2b44e03c4e00393e948cce36a6b0f0d7489cb46d944b33ad51c8', '::1', '27/08/2019', '23:27:04', 0),
(20, 28, 5, '6d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf4', '::1', '04/09/2019', '22:49:25', 0),
(21, 28, 5, '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8', '::1', '04/09/2019', '22:49:56', 0),
(22, 29, 5, '6d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf4', '::1', '04/09/2019', '23:55:02', 0),
(23, 9, 1, '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8', '::1', '05/09/2019', '09:20:53', 0),
(24, 11, 1, '6d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf4', '::1', '05/09/2019', '11:41:52', 0),
(25, 10, 1, '6d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf4', '::1', '05/09/2019', '11:42:39', 0),
(26, 7, 1, '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8', '::1', '05/09/2019', '11:43:02', 0),
(27, 25, 1, '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8', '::1', '05/09/2019', '11:47:48', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `idUser` int(12) NOT NULL,
  `area` varchar(50) COLLATE utf8_bin NOT NULL,
  `acao` text COLLATE utf8_bin NOT NULL,
  `data` varchar(50) COLLATE utf8_bin NOT NULL,
  `hora` varchar(50) COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `logs`
--

INSERT INTO `logs` (`id`, `idUser`, `area`, `acao`, `data`, `hora`, `ip`) VALUES
(1, 6, 'Motivos', 'O jogador x acaba de criar um novo motivo!', '05/09/2019', '00:27:50', '127.0.0.1'),
(2, 5, 'Cargo', 'Acaba de criar um novo cargo', '05/09/2019', '20:30:45', '127.0.0.2'),
(3, 1, 'Motivo', 'Tentou criar um novo motivo (teste), pÃ³rem ele nÃ£o tem permissÃ£o.', '05/09/2019', '12:26:03', '::1'),
(4, 1, 'Motivo', 'Tentou criar um novo motivo (teste), pÃ³rem ele nÃ£o tem permissÃ£o.', '05/09/2019', '12:26:08', '::1'),
(5, 1, 'Motivo', 'Tentou criar um novo motivo (teste), pÃ³rem ele nÃ£o tem permissÃ£o.', '05/09/2019', '09:27:46', '::1'),
(6, 1, 'Pegou o processo nÂº 11 para analisar.', 'Processos', '05/09/2019', '11:41:52', '::1'),
(7, 1, 'Pegou o processo nÂº 10 para analisar.', 'Processos', '05/09/2019', '11:42:39', '::1'),
(8, 1, 'Aplicou a sentenÃ§a em no processo nÂº7', 'Processos', '05/09/2019', '11:43:02', '::1'),
(9, 1, 'Processos', 'Aplicou a sentenÃ§a em no processo nÂº25', '05/09/2019', '11:47:48', '::1'),
(10, 1, 'Motivo', 'Criou um novo motivo (Cop X Cop) com sucesso.', '05/09/2019', '21:29:51', '::1'),
(11, 1, 'Motivo', 'Criou um novo motivo (Cop X Cop) com sucesso.', '05/09/2019', '21:30:00', '::1'),
(12, 1, 'Administradores', 'Tentou adicionar um novo administrador, mas o mesmo nÃ£o tem permissÃ£o.', '07/09/2019', '02:59:43', '::1'),
(13, 1, 'Administradores', 'Adicionou  (Pedro_KilleR) com sucesso como administrador.', '07/09/2019', '03:00:19', '::1'),
(14, 1, 'Administradores', 'Adicionou  (BerN) com sucesso como administrador.', '07/09/2019', '03:00:39', '::1'),
(15, 1, 'Administradores', 'Removeu o administrador de ID (1) com sucesso.', '07/09/2019', '03:04:23', '::1'),
(16, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '03:04:30', '::1'),
(17, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '03:04:41', '::1'),
(18, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '03:05:17', '::1'),
(19, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '03:06:17', '::1'),
(20, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '03:06:27', '::1'),
(21, 1, 'Administradores', 'Adicionou  (Yoshi) com sucesso como administrador.', '07/09/2019', '14:01:15', '::1'),
(22, 1, 'Administradores', 'Removeu o administrador de ID (1) com sucesso.', '07/09/2019', '14:01:20', '::1'),
(23, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:01:22', '::1'),
(24, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:01:59', '::1'),
(25, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:02:39', '::1'),
(26, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:02:41', '::1'),
(27, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:02:44', '::1'),
(28, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:03:23', '::1'),
(29, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:03:25', '::1'),
(30, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:04:06', '::1'),
(31, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:05:40', '::1'),
(32, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:05:41', '::1'),
(33, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:05:46', '::1'),
(34, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:05:48', '::1'),
(35, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:06:01', '::1'),
(36, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:09:19', '::1'),
(37, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:09:29', '::1'),
(38, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:09:31', '::1'),
(39, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:09:44', '::1'),
(40, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:09:46', '::1'),
(41, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:09:47', '::1'),
(42, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:10:14', '::1'),
(43, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '14:10:15', '::1'),
(44, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '07/09/2019', '23:52:41', '::1'),
(45, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (1) com sucesso.', '08/09/2019', '02:55:22', '::1'),
(46, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '02:55:28', '::1'),
(47, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '02:56:28', '::1'),
(48, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '02:56:29', '::1'),
(49, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '02:56:31', '::1'),
(50, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '02:56:37', '::1'),
(51, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (1) com sucesso.', '08/09/2019', '02:57:19', '::1'),
(52, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (1) com sucesso.', '08/09/2019', '02:57:20', '::1'),
(53, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '02:57:48', '::1'),
(54, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '02:58:54', '::1'),
(55, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  () com sucesso.', '08/09/2019', '02:58:59', '::1'),
(56, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  () com sucesso.', '08/09/2019', '03:01:16', '::1'),
(57, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  () com sucesso.', '08/09/2019', '03:02:20', '::1'),
(58, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '03:02:25', '::1'),
(59, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (2) com sucesso.', '08/09/2019', '03:02:29', '::1'),
(60, 1, 'Administradores', 'Atualizou o cargo do administrador de ID  (3) com sucesso.', '08/09/2019', '03:02:35', '::1'),
(61, 1, 'Administradores', 'Atualizou o cargo do administrador BerN com sucesso.', '08/09/2019', '03:06:14', '::1'),
(62, 1, 'Administradores', 'Atualizou o cargo do administrador Yoshi com sucesso.', '08/09/2019', '03:36:55', '::1'),
(63, 1, 'Administradores', 'Atualizou o cargo do administrador BerN com sucesso.', '08/09/2019', '03:37:00', '::1'),
(64, 1, 'Administradores', 'Atualizou o cargo do administrador Thur_MaliGnY com sucesso.', '08/09/2019', '03:42:45', '::1'),
(65, 1, 'Administradores', 'Atualizou o cargo do administrador Thur_MaliGnY com sucesso.', '08/09/2019', '03:42:51', '::1'),
(66, 3, 'Administradores', 'Tentou acessar a Ã¡rea de gerenciamento de usuarios, porÃ©m nÃ£o tinha permissÃ£o', '08/09/2019', '03:44:57', '::1'),
(67, 3, 'Administradores', 'Tentou acessar a Ã¡rea de gerenciamento de usuarios, porÃ©m nÃ£o tinha permissÃ£o', '08/09/2019', '03:45:04', '::1'),
(68, 1, 'Administradores', 'Atualizou o cargo do administrador Yoshi com sucesso.', '08/09/2019', '03:45:17', '::1'),
(69, 3, 'Administradores', 'Tentou acessar a Ã¡rea de gerenciamento de usuarios, porÃ©m nÃ£o tinha permissÃ£o', '08/09/2019', '03:46:39', '::1'),
(70, 3, 'Administradores', 'Tentou acessar a Ã¡rea de gerenciamento de usuarios, porÃ©m nÃ£o tinha permissÃ£o', '08/09/2019', '03:47:16', '::1'),
(71, 1, 'Administradores', 'Tentou acessar a Ã¡rea de gerenciamento de usuarios, porÃ©m nÃ£o tinha permissÃ£o', '08/09/2019', '03:47:30', '::1'),
(72, 1, 'Administradores', 'Removeu o administrador de ID (3) com sucesso.', '08/09/2019', '03:49:55', '::1'),
(73, 1, 'Administradores', 'Removeu o administrador de ID (3) com sucesso.', '08/09/2019', '03:50:17', '::1'),
(74, 1, 'Administradores', 'Removeu o administrador Yoshi com sucesso.', '08/09/2019', '03:51:17', '::1'),
(75, 1, 'Administradores', 'Removeu o administrador BerN com sucesso.', '08/09/2019', '03:51:28', '::1'),
(76, 1, 'PuniÃ§Ã£o', 'Atualizou as permissÃµes do cargo de ID 7.', '08/09/2019', '03:59:58', '::1'),
(77, 1, 'Administradores', 'Adicionou  (Yoshi) com sucesso como administrador.', '08/09/2019', '04:00:16', '::1'),
(78, 1, 'Administradores', 'Adicionou  (Yoshi) com sucesso como administrador.', '08/09/2019', '04:00:56', '::1'),
(79, 1, 'Administradores', 'Adicionou  (Yoshi) com sucesso como administrador.', '08/09/2019', '04:02:20', '::1'),
(80, 1, 'Administradores', 'Adicionou  (Yoshi) com sucesso como administrador.', '08/09/2019', '04:03:06', '::1'),
(81, 1, 'Administradores', 'Adicionou  (Yoshi) com sucesso como administrador.', '08/09/2019', '04:03:09', '::1'),
(82, 1, 'PuniÃ§Ã£o', 'Atualizou as permissÃµes do cargo de ID 7.', '08/09/2019', '04:07:45', '::1'),
(83, 1, 'PuniÃ§Ã£o', 'Atualizou as permissÃµes do cargo de ID 7.', '08/09/2019', '04:08:07', '::1'),
(84, 1, 'PuniÃ§Ã£o', 'Atualizou as permissÃµes do cargo de ID 1.', '08/09/2019', '13:20:14', '::1'),
(85, 1, 'PuniÃ§Ã£o', 'Atualizou as permissÃµes do cargo de ID 7.', '08/09/2019', '13:20:28', '::1'),
(86, 1, 'Administradores', 'Adicionou BerN como administrador com sucesso.', '09/09/2019', '12:53:54', '::1'),
(87, 1, 'Administradores', 'Tentou acessar a Ã¡rea de gerenciamento de banidos, porÃ©m nÃ£o tinha permissÃ£o', '09/09/2019', '22:48:28', '::1'),
(88, 1, 'Administradores', 'Tentou acessar a Ã¡rea de gerenciamento de banidos, porÃ©m nÃ£o tinha permissÃ£o', '09/09/2019', '22:48:32', '::1'),
(89, 1, 'Administradores', 'Adicionou Yoshi como administrador com sucesso.', '09/09/2019', '22:55:56', '::1'),
(90, 1, 'Administradores', 'Adicionou Yoshi como administrador com sucesso.', '09/09/2019', '23:02:59', '::1'),
(91, 1, 'Administradores', 'Adicionou Yoshi como administrador com sucesso.', '09/09/2019', '23:26:02', '::1'),
(92, 1, 'Administradores', 'Adicionou Yoshi como administrador com sucesso.', '09/09/2019', '23:31:41', '::1'),
(93, 1, 'Administradores', 'Adicionou Yoshi como administrador com sucesso.', '09/09/2019', '23:32:27', '::1'),
(94, 1, 'Administradores', 'Adicionou Yoshi como administrador com sucesso.', '09/09/2019', '23:32:40', '::1'),
(95, 1, 'Administradores', 'Adicionou BerN como administrador com sucesso.', '09/09/2019', '23:55:19', '::1'),
(96, 1, 'Administradores', 'Removeu o banimento de BerN com sucesso.', '10/09/2019', '00:27:20', '::1'),
(97, 1, 'Administradores', 'Removeu o banimento de BerN com sucesso.', '10/09/2019', '00:28:13', '::1'),
(98, 1, 'Banidos', 'Removeu o banimento de Yoshi com sucesso.', '10/09/2019', '00:28:37', '::1'),
(99, 1, 'Administradores', 'Adicionou 0 como administrador com sucesso.', '10/09/2019', '00:28:57', '::1'),
(100, 1, 'Banidos', 'Adicionou um banimento manual em Yoshi  com sucesso.', '10/09/2019', '00:30:29', '::1'),
(101, 1, 'Banidos', 'Removeu o banimento de Yoshi com sucesso.', '10/09/2019', '00:30:45', '::1'),
(102, 1, 'Banidos', 'Adicionou um banimento manual em Yoshi  com sucesso.', '10/09/2019', '00:30:55', '::1'),
(103, 1, 'Banidos', 'Removeu o banimento de Yoshi com sucesso.', '10/09/2019', '00:32:09', '::1'),
(104, 1, 'Banidos', 'Adicionou um banimento manual em Yoshi  com sucesso.', '10/09/2019', '00:32:12', '::1'),
(105, 1, 'Banidos', 'Removeu o banimento de Yoshi com sucesso.', '10/09/2019', '00:32:49', '::1'),
(106, 1, 'Banidos', 'Adicionou um banimento manual em Yoshi  com sucesso.', '10/09/2019', '00:32:54', '::1'),
(107, 1, 'Banidos', 'Removeu o banimento de Yoshi com sucesso.', '10/09/2019', '00:35:02', '::1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `motivo`
--

DROP TABLE IF EXISTS `motivo`;
CREATE TABLE IF NOT EXISTS `motivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motivo` varchar(15) COLLATE utf8_bin NOT NULL,
  `motivoValue` varchar(15) COLLATE utf8_bin NOT NULL,
  KEY `index` (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `motivo`
--

INSERT INTO `motivo` (`id`, `motivo`, `motivoValue`) VALUES
(1, 'DM', 'dm'),
(2, 'DB', 'db'),
(3, 'Anti-RPG', 'antirpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `organizacao`
--

DROP TABLE IF EXISTS `organizacao`;
CREATE TABLE IF NOT EXISTS `organizacao` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `organizacaoName` varchar(50) COLLATE utf8_bin NOT NULL,
  `organizacaoID` int(12) NOT NULL,
  `organizacaoTipo` int(50) NOT NULL,
  `statusOrganizao` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE IF NOT EXISTS `permissoes` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `isAdmin` int(12) NOT NULL DEFAULT 0,
  `moveProcess` int(12) NOT NULL DEFAULT 0,
  `hideProcess` int(12) NOT NULL DEFAULT 0,
  `showProcess` int(12) NOT NULL DEFAULT 0,
  `lockProcess` int(12) NOT NULL DEFAULT 0,
  `unlockProcess` int(12) NOT NULL DEFAULT 0,
  `getPlayer` int(12) NOT NULL DEFAULT 0,
  `getLider` int(12) NOT NULL DEFAULT 0,
  `getStaff` int(12) NOT NULL DEFAULT 0,
  `getCheater` int(12) NOT NULL DEFAULT 0,
  `getCaloteiro` int(12) NOT NULL DEFAULT 0,
  `getForum` int(12) NOT NULL DEFAULT 0,
  `getTS` int(12) NOT NULL DEFAULT 0,
  `getJuiz` int(12) NOT NULL DEFAULT 0,
  `getDel` int(12) NOT NULL DEFAULT 0,
  `getRestore` int(12) NOT NULL DEFAULT 0,
  `getViewDel` int(12) NOT NULL DEFAULT 0,
  `getDelPerm` int(12) NOT NULL DEFAULT 0,
  `getViewPunish` int(12) DEFAULT 0,
  `getApplyPunish` int(12) DEFAULT 0,
  `getCreateReason` int(12) NOT NULL DEFAULT 0,
  `getRemoveReason` int(12) NOT NULL DEFAULT 0,
  `getCreateRole` int(12) NOT NULL DEFAULT 0,
  `getDeleteRole` int(12) NOT NULL DEFAULT 0,
  `getManagerPermition` int(12) NOT NULL DEFAULT 0,
  `getGiveRole` int(12) NOT NULL DEFAULT 0,
  `getRemoveRole` int(12) NOT NULL DEFAULT 0,
  `getViewLogs` int(12) NOT NULL DEFAULT 0,
  `getViewPunishment` int(12) NOT NULL DEFAULT 0,
  `getRequestJuri` int(12) DEFAULT 0,
  `getUseCode` int(12) NOT NULL DEFAULT 0,
  `getGiveAdmin` int(12) NOT NULL DEFAULT 0,
  `getRemoveAdmin` int(12) NOT NULL DEFAULT 0,
  `getBan` int(12) NOT NULL,
  `getDesban` int(12) NOT NULL,
  `isJuri` int(12) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`id`, `name`, `isAdmin`, `moveProcess`, `hideProcess`, `showProcess`, `lockProcess`, `unlockProcess`, `getPlayer`, `getLider`, `getStaff`, `getCheater`, `getCaloteiro`, `getForum`, `getTS`, `getJuiz`, `getDel`, `getRestore`, `getViewDel`, `getDelPerm`, `getViewPunish`, `getApplyPunish`, `getCreateReason`, `getRemoveReason`, `getCreateRole`, `getDeleteRole`, `getManagerPermition`, `getGiveRole`, `getRemoveRole`, `getViewLogs`, `getViewPunishment`, `getRequestJuri`, `getUseCode`, `getGiveAdmin`, `getRemoveAdmin`, `getBan`, `getDesban`, `isJuri`) VALUES
(1, 'Master', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(7, 'Juiz', 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(8, 'Juiz 3', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `processos`
--

DROP TABLE IF EXISTS `processos`;
CREATE TABLE IF NOT EXISTS `processos` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `area` varchar(30) COLLATE utf8_bin NOT NULL,
  `data` varchar(20) COLLATE utf8_bin NOT NULL,
  `edit` int(12) NOT NULL DEFAULT 0,
  `ip` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `hora` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `motivo` varchar(50) COLLATE utf8_bin NOT NULL,
  `provas` varchar(500) COLLATE utf8_bin NOT NULL,
  `descricao` text COLLATE utf8_bin NOT NULL,
  `status` text COLLATE utf8_bin NOT NULL,
  `autorID` int(12) NOT NULL,
  `autorNick` varchar(50) COLLATE utf8_bin NOT NULL,
  `autorOrg` varchar(50) COLLATE utf8_bin NOT NULL,
  `reuID` int(12) NOT NULL,
  `reuNick` varchar(50) COLLATE utf8_bin NOT NULL,
  `reuOrg` varchar(50) COLLATE utf8_bin NOT NULL,
  `respID` int(12) NOT NULL DEFAULT 0,
  `juri` int(12) DEFAULT 0,
  `visibile` int(12) DEFAULT 1,
  `access` int(12) DEFAULT 1,
  `deletado` int(12) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `processos`
--

INSERT INTO `processos` (`id`, `area`, `data`, `edit`, `ip`, `hora`, `motivo`, `provas`, `descricao`, `status`, `autorID`, `autorNick`, `autorOrg`, `reuID`, `reuNick`, `reuOrg`, `respID`, `juri`, `visibile`, `access`, `deletado`) VALUES
(6, 'Staff Server', '28/07/2019', 0, '::1', '01:52:16', 'dm', 'http://www.google.com', '<p>ata</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 3, 'Erick_Carrasco', 'Civil', 2, 0, 1, 1, 1),
(7, 'Player', '28/07/2019', 0, '::1', '02:04:24', 'dm', 'http://www.google.com', '<p>ata</p>', 'Apurado', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 1, 1, 0, 1, 0),
(8, 'Player', '28/07/2019', 0, '::1', '02:05:18', 'dm', 'http://www.google.com', '<p>ata</p>', 'PuniÃ§Ã£o Aplicada', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 1, 1, 1, 1, 0),
(9, 'Player', '15/08/2019', 1565919974, '::1', '22:46:14', 'db', 'http://www.google.com', '<p>aaa</p>', 'PuniÃ§Ã£o Aplicada', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 1, 1, 1, 1, 0),
(10, 'Staff Server', '18/08/2019', 1566098467, '::1', '00:21:07', 'dm', 'http://www.google.com', '<p>asdasddsads</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 1, 0, 1, 1, 0),
(11, 'Staff Server', '18/08/2019', 1566098478, '::1', '00:21:18', 'dm', 'http://www.google.com', '<p>asdasddsads</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 1, 0, 1, 1, 0),
(12, 'Staff Server', '18/08/2019', 1566098552, '::1', '00:22:32', 'dm', 'http://www.google.com', '<p>asddsasdadsa</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil2', 0, 0, 1, 1, 0),
(13, 'Juiz', '18/08/2019', 1566098702, '::1', '00:25:02', 'dm', 'http://www.google.com', '<p>asddsasdadsa</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil2', 0, 0, 1, 1, 0),
(14, 'Staff Server', '18/08/2019', 1566098720, '::1', '00:25:20', 'dm', 'http://www.google.com', '<p>asdsdasdasda</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 0, 0, 1, 1, 0),
(15, 'Staff Server', '18/08/2019', 1566099899, '::1', '00:44:59', 'dm', 'http://www.google.com', '<p>asdsdasdasda</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 1, 1, 1, 1, 0),
(16, 'Staff Server', '18/08/2019', 1566099912, '::1', '00:45:12', 'dm', 'http://www.google.com', '<p>asdsdasdasda</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 0, 0, 1, 1, 0),
(17, 'Staff Server', '18/08/2019', 1566100221, '::1', '00:50:21', 'dm', 'http://www.google.com', '<p>aaaaa</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 0, 0, 1, 1, 0),
(18, 'Staff Server', '18/08/2019', 1566105188, '::1', '02:13:08', 'dm', 'http://www.google.com', '<p>dsasdadsads</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Helper', 0, 0, 1, 1, 0),
(19, 'Staff Server', '18/08/2019', 1566105892, '::1', '02:24:52', 'dm', 'http://www.google.com', '<p>jjjj</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Administrador', 0, 0, 1, 1, 0),
(20, 'Cheater', '18/08/2019', 1566105917, '::1', '02:25:17', 'dm', 'http://www.google.com', '<p>kkkk</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Exercito', 1, 0, 1, 1, 0),
(21, 'Caloteiro', '20/08/2019', 1566319296, '::1', '13:41:36', 'dm', 'http://www.google.com', '<p>dcacdsdsdads</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 0, 0, 1, 1, 0),
(22, 'Staff Server', '21/08/2019', 1566358817, '::1', '00:40:17', 'dm', 'http://www.google.com', '<p>117</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Administrador', 0, 0, 1, 1, 0),
(23, 'Player', '21/08/2019', 1566358866, '::1', '00:41:06', 'antirpg', 'http://www.google.com', '<p>abandonou na call</p>', 'PuniÃ§Ã£o Aplicada', 1, 'Thur_MaliGnY', 'Civil', 0, 'Pedro_KilleR', 'Civil', 1, 0, 1, 1, 0),
(24, 'Cheater', '21/08/2019', 1566440805, '::1', '23:26:45', 'dm', 'http://www.google.com', '<p>asdasdasd</p>', 'Em andamento', 1, 'Thur_MaliGnY', 'Civil', 0, 'Erick_Carrasco', 'Civil', 1, 1, 1, 1, 1),
(25, 'Lider/Sublideres', '27/08/2019', 1566953304, '::1', '21:48:24', 'db', 'http://www.google.com', '<p>sasaddsadsadsadsa</p>', 'Apurado', 1, 'Thur_MaliGnY', 'Civil', 0, 'Pedro_KilleR', 'Civil', 1, 0, 1, 1, 0),
(26, 'Player', '27/08/2019', 1566953498, '::1', '21:51:38', 'dm', 'http://www.google.com', '<p>44</p><p><br></p>', 'PuniÃ§Ã£o Aplicada', 1, 'Thur_MaliGnY', 'Civil', 4, 'Pedro_KilleR', 'Civil', 1, 0, 1, 1, 0),
(27, 'Player', '27/08/2019', 1566953888, '::1', '21:58:08', 'dm', 'http://www.google.com', '<p>sfsdsdf</p>', 'PuniÃ§Ã£o Aplicada', 1, 'Thur_MaliGnY', 'Civil', 4, 'Pedro_KilleR', 'Civil', 1, 0, 1, 1, 0),
(28, 'Player', '28/08/2019', 1566962126, '::1', '00:15:26', 'dm', 'http://www.google.com', '<p>666</p>', 'PuniÃ§Ã£o Aplicada', 1, 'Thur_MaliGnY', 'Civil', 3, 'Erick_Carrasco', 'Civil', 5, 0, 1, 1, 0),
(29, 'Staff Server', '04/09/2019', 1567649606, '::1', '23:13:26', 'db', 'http://www.google.com', '<p>aasdadsasd</p>', 'Em andamento', 5, 'Thur_MaliGnY', 'Civil', 0, 'Pedro_KilleR', 'Helper', 5, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `alerta` int(11) NOT NULL,
  `categoria` varchar(250) COLLATE utf8_bin NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `preco` float NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0,
  `desconto` int(11) NOT NULL,
  `vendas` int(12) NOT NULL DEFAULT 0,
  `avaliacao` int(11) NOT NULL,
  `img1` varchar(250) COLLATE utf8_bin NOT NULL,
  `img2` varchar(250) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `alerta`, `categoria`, `nome`, `preco`, `estoque`, `desconto`, `vendas`, `avaliacao`, `img1`, `img2`) VALUES
(1, 1, 'Canecas', 'Caneca PlayStart', 25, 0, 25, 1, 4, '1a', '1b'),
(2, 2, 'Camisas', 'Camisa PlayStart', 40, 0, 0, 120, 504, '2a', '2b'),
(3, 3, 'Camisas', 'Camisa PlayStart2', 55, 0, 60, 1, 3, '2b', '2a'),
(4, 4, 'Canecas', 'Caneca PlayStart2', 25, 20, 40, 1, 4, '1b', '1a'),
(5, 1, 'Canecas', 'Caneca PlayStart', 25, 0, 25, 1, 4, '1a', '1b'),
(6, 2, 'Camisas', 'Camisa PlayStart', 40, 0, 0, 1, 5, '2a', '2b'),
(7, 3, 'Camisas', 'Camisa PlayStart2', 55, 0, 60, 1, 5, '2b', '2a'),
(8, 4, 'Canecas', 'Caneca PlayStart2', 25, 0, 40, 1, 4, '1b', '1a'),
(9, 1, 'Canecas', 'Caneca PlayStart', 25, 0, 25, 1, 4, '1a', '1b'),
(10, 2, 'Camisas', 'Camisa PlayStart', 40, 0, 0, 1, 3, '2a', '2b'),
(11, 3, 'Camisas', 'Camisa PlayStart2', 55, 0, 60, 1, 3, '2b', '2a'),
(12, 4, 'Canecas', 'Caneca PlayStart2', 25, 0, 40, 1, 4, '1b', '1a'),
(13, 1, 'Canecas', 'Caneca PlayStart', 25, 0, 25, 1, 4, '1a', '1b'),
(14, 2, 'Camisas', 'Camisa PlayStart', 40, 0, 0, 1, 5, '2a', '2b'),
(15, 3, 'Camisas', 'Camisa PlayStart2', 55, 0, 60, 1, 5, '2b', '2a'),
(16, 4, 'Canecas', 'Caneca PlayStart2', 25, 0, 40, 1, 4, '1b', '1a');

-- --------------------------------------------------------

--
-- Estrutura da tabela `punicao`
--

DROP TABLE IF EXISTS `punicao`;
CREATE TABLE IF NOT EXISTS `punicao` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `apply` int(12) NOT NULL DEFAULT 0,
  `id_processo` int(12) NOT NULL DEFAULT 0,
  `data` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `juiz` int(12) NOT NULL DEFAULT 0,
  `autorID` int(12) NOT NULL DEFAULT 0,
  `reuID` int(12) NOT NULL DEFAULT 0,
  `motivo` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `gravidade` int(12) NOT NULL DEFAULT 0,
  `minutos` int(12) NOT NULL DEFAULT 0,
  `avisos` int(12) NOT NULL DEFAULT 0,
  `provas` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `punicao`
--

INSERT INTO `punicao` (`id`, `apply`, `id_processo`, `data`, `juiz`, `autorID`, `reuID`, `motivo`, `gravidade`, `minutos`, `avisos`, `provas`) VALUES
(2, 1, 23, '27/08/2019 | 21:45:20', 1, 1, 0, 'antirpg', 0, 1, 0, NULL),
(11, 1, 28, '04/09/2019 | 22:49:56', 5, 1, 3, 'dm', 1, 0, 0, ''),
(4, 1, 26, '27/08/2019 | 21:51:52', 1, 1, 4, 'dm', 0, 1, 0, 'https://imgur.com/exemplo'),
(8, 1, 8, '27/08/2019 | 23:25:07', 1, 1, 0, 'dm', 1, 0, 0, 'https://imgur.com/'),
(12, 1, 9, '05/09/2019 | 09:20:53', 1, 1, 0, 'db', 0, 30, 0, 'https://imgur.com/exemplo'),
(13, 0, 7, '05/09/2019 | 11:43:02', 1, 1, 0, 'dm', 1, 0, 0, NULL),
(14, 0, 25, '05/09/2019 | 11:47:48', 1, 1, 0, 'db', 1, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `idForum` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `senha` varchar(500) COLLATE utf8_bin NOT NULL,
  `salt` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `grupo` int(12) NOT NULL DEFAULT 0,
  `alert` int(12) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `idForum`, `name`, `senha`, `salt`, `email`, `grupo`, `alert`) VALUES
(1, 1, 'Thur_MaliGnY', '$2y$10$mvyV4QsGaNhtSKMG8hA0G.x8HTUyzfebOd4UX.l0Q62PDJ1qXvSgu', '', 'thurpolidoro@gmail.com', 1, 0),
(2, 2, 'BerN', '$2y$10$2H0CK54e1x3x.OyVKtJD7uxJQ6ANFP7pLP.9mkZvSkKnjjVV0iQxm', '', 'bernardoemanuel1999@gmail.com', 8, 0),
(3, 3, 'Yoshi', '$2y$10$5xS6cSCb/gC7oIuHYYt3zOaW2ouGfcjWVJ4o8mUI4uUP06yfKTpX.', '', 'ronaldobueno2002@gmail.com', 7, 0),
(4, 4, 'Eagle_', '$2y$10$qqueXVAcXR/AIueIMYO6bezED8DLGAVtI574jM8sNquyNnShk7zYC', '', 'filipe_santuche@hotmail.com', 0, 0),
(5, 5, 'Energy_Staff', '$2y$10$pVCxucwKY.h/S76ESGOXJeL8J8vuS6lFMB8sZhPYB79KECp1wj/dS', '', 'energy0007.masterzin@gmail.com', 0, 0),
(6, 6, 'Luuk_AimBoT', '$2y$10$2DlX0SikA7iseRPdhwZAeutxZvY/6YEB3eBfwN/eIlVo0iOnK1Mqm', '', 'Lucassanttos0oficial@gmail.com', 0, 0),
(7, 7, 'Master_Staff', '$2y$10$PKxx1Rzn27ZxUoYcJjl0lefcNGyYOXpBvx0P7dGPgDr8nOq4rBfUS', '', 'dinisca12@gmail.com', 0, 0),
(8, 8, 'iStanLey_KingsMan', '$2y$10$jeuojbJc9ELxS.m0LoDHx.zkAh.FbVuCQvfWgl3stO3FF.6EIOXVW', '', 'gustavo2021.br@gmail.com', 0, 0),
(9, 9, 'XAROPE_AimBoT', '$2y$10$lUwcZIDGHtKULUMm8a4B5.f7f2lLWupoXnCYYJQfhxOC7oURQQxSy', '', 'rhveiculo@gmail.com', 0, 0),
(10, 10, 'ipsLuan', '$2y$10$4lW7GwHrzpUsJXwxvsGTJevKJMK7vng7WyGDD0JB8pKPwiIGyJXe2', '', 'ipsluan@icloud.com', 0, 0),
(11, 11, 'Fin2', '$2y$10$HuIvbFQNwPdvQZT2VMKIWe66FU2.15r7Ito0Ck4t3AIRnJhrHlFoe', '', 'viga.habboleiro0@gmail.com', 0, 0),
(12, 12, 'Obscure_WasteD', '$2y$10$5GxjGS2yxIfr9JKm33oTweym5xpJvoHLziIBJ4g7YSI1clEF2yBkG', '', 'danielsilsil99@gmail.com', 0, 0),
(13, 13, 'M4theusBR_GoldeN', '$2y$10$V86V6Sr7BwcfIaDyW94IeeHUr1BjJQWglipl.vw7CMf1C7Z.GdeQ6', '', 'pcontaparajogar@gmail.com', 0, 0),
(14, 14, 'Keilinha_Staff', '$2y$10$L.r8.7vBRasYqBXl426laO75x17v1xHHOyCxu.pREaTAmyr7FvoKu', '', 'keilinha111@hotmail.com', 0, 0),
(15, 15, 'Kelvin', '$2y$10$CPj1zxh3HL/g4WBT0TmSEugIZRW2umwWf1DSVdLaNi2alm7/uiAuK', '', 'kelvindestak@hotmail.com', 0, 0),
(16, 16, 'GOLLD_Staff', '$2y$10$7m1PPiDDjINZu6OM9foJBugvoslT4hPU2gqAeIYuKF.8W31ACdy5C', '', 'rodolfoagra.2001@gmail.com', 0, 0),
(17, 17, 'Cicinho_GoldeN', '$2y$10$eBKVbtO.mxM4lrEUpNO8pujQQMaKcJnkWVpGf1NzgSpeETuKmW36y', '', 'welithosilva@gmail.com', 0, 0),
(18, 18, 'Arcanjos_AimBoT', '$2y$10$1OpVff7hSpzl3gpQn8U74uAR.SnDTBrk9PC0C4tpYhUKNDig1H.PS', '', 'netoferreira131@hotmail.com', 0, 0),
(19, 19, 'Samuka_Matarazzi', '$2y$10$9PC/E8ygJ5PHGrHpYp3vb.bCk3A9ZKFRG7RmAGQi1l912mb9K.Zx.', '', 'samukarasta11@gmail.com', 0, 0),
(20, 20, 'HDS_WarninG', '$2y$10$Ret7sO8N3AdxOxR5juSd6.tDudgRGm1GJSgvXiOHDxYRepFX9rN.S', '', 'gabrielhonorio612@gmail.com', 0, 0),
(21, 21, 'Champanha', '$2y$10$.18Ol9qahCLA9MMisz2ze.BpIy6cjT3Ucf0jfERlRvI28t5YsWDAm', '', 'jarlisonlima2@gmail.com', 0, 0),
(22, 22, 'Jhonnye_Terballo', '$2y$10$S6KSFYrPUVwzdC6.EFibBekDMEZg5ww16Z5s5qwdTeLij3AlQYc7q', '', 'jhonnyecooper@gmail.com', 0, 0),
(23, 23, 'Walter_MagiC', '$2y$10$b/21tW87P7I7zUI.p6drQOrLxUp7.A3KPwRSVSWVURw16MAsaRJqi', '', 'walterfilhomagic1998@gmail.com', 0, 0),
(24, 24, 'Chapisco_AimBoT', '$2y$10$yCLpTrMI1wOlljjwJ4I.Se.pCOuyhwflaWHYvwA3y8QPZ80Alo71i', '', 'marcosalexandre223344@hotmail.com', 0, 0),
(25, 25, 'Asthenic', '$2y$10$MIohH3e63HlP9pjKHjdXmeA/KZI/P5t67ikoWoqospqXY59.5H1F6', '', 'jdastretas@gmail.com', 0, 0),
(26, 26, 'HaiKaisS', '$2y$10$8jeVg8lX4NeJf8/NqlnJqemLWmSxjOKv862tbzkPnsIbXlp/j5Zgi', '', 'joaovytorsx28@gmail.com', 0, 0),
(27, 27, 'R.Ribas', '$2y$10$PLKSAwJdNOyQ07kLl.wzy.xfuL.gV76Cy5Vvrvx1jVLBM4gaoyBTK', '', 'renangbi@msn.com', 0, 0),
(28, 28, '$$L4M4RCK_WanteD', '$2y$10$n6IQuFSZZjocY0HviKIWTO0sOuxgDrJ3CjreBzcI9hUoEXyjY3DCm', '', 'easybyme@gmail.com', 0, 0),
(29, 29, 'HiGod_WanteD', '$2y$10$L.56MToYQZ0QPgfSoeV7zOuMBpY/npCepX6V7lalOFcmndjKOFtJO', '', 'higorlenon@hotmail.com', 0, 0),
(30, 30, 'Sl4yer', '$2y$10$N5GnHAGvVnXx.Uq4EOTq6.2w8.PmvjdVFxU07aHcIfnErb0cPV4Dq', '', 'matheusfiauxfigueira@gmail.com', 0, 0),
(31, 31, 'Victor_py', '$2y$10$k53ltsY6K32aFRb2AXmOc.LOPNP1FZ.rndWHsWoVaRNggd151A8Ba', '', 'victorhugodasilva26@gmail.com', 0, 0),
(32, 32, 'Marcos', '$2y$10$p.yPVleJbZV23MZjBawxhOIxak2Q5z38ATszfevw.iunoGW50uoPC', '', 'marcoslyon12@outlook.com', 0, 0),
(33, 33, '', '', '', '', 0, 0),
(34, 34, 'Styletto', '$2y$10$tpdvAbFZimG6.Fj0k7DSVuzdgDzprCW90tLdBQNuJofD3DAn2z5IG', '', 'gamerguilherme804@gmail.com', 0, 0),
(35, 35, 'pushline', '$2y$10$HIUm2osHb1gR/RKI6TEmruyD57Mc35UsLXVYg8A1rNTPWOw4EvFbO', '', 'pushl1n3@gmail.com', 0, 0),
(36, 36, 'ProuD_KingsMan', '$2y$10$sK9Eg.PumYltVJ2YAL94ie/S2xIutFlbw9AYMT1UCfqw9KpebfGlW', '', 'yarleileal6@gmail.com', 0, 0),
(37, 37, 'EnD_KingsMan', '$2y$10$/KKjnvkXB7FXAFAEZpijbOn23bsGggyldhNTa5WzZXBd42Sq7jnJa', '', 'victorplay191000@gmail.com', 0, 0),
(38, 38, 'JefersoN_AbsoluT', '$2y$10$nzlJoEpr0HXvgR3kGX/uGuGSeTbJVNGCEhjfYrNn7RiAuOnywDf9e', '', 'jefersonjhgs24@hotmail.com', 0, 0),
(39, 39, 'Kaique22', '$2y$10$PCfL5rvNCQs9RNBWzJ.o/OMNXxqE7kxfBWkA.Wr2eoAXb2BAWXne2', '', 'kaiquezula22@gmail.com', 0, 0),
(40, 40, 'Snake_Wonder', '$2y$10$pSJPJz71WYgxt9BmW8PdIOmF3FUR2zRMwPiZuqNg6vKPX8lUoXc9m', '', 'rafaelcaetanomendes@gmail.com', 0, 0),
(41, 41, 'mike_', '$2y$10$S6H..aOHYgvhnwDVOBcxZ.dkH/Fak/0TiaGf2Sf0jx7cH6an3QR8m', '', 'miguelmoita05@gmail.com', 0, 0),
(42, 42, 'rei_x', '$2y$10$Z0hFdITGiqHRXJKCV0V5CuZI9CTmnTSMqsc/iyJ2ZDtzgvEP7x87m', '', 'vitor_andre07@hotmail.com', 0, 0),
(43, 43, 'Vinicius_KaWaSaKi', '$2y$10$imcM.tARNPUjVNY4QYPF4.emeAWssPPSlr8ZaV.Zb681nIFTEUE4y', '', 'viniciusalbes1908@gmail.com', 0, 0),
(44, 44, 'Eduardo_Nisio', '$2y$10$dtiNfNM/OBW7dyoSb4Vw8OE4blUQ7ANP7j9a71e6abT5ThuUBdUGu', '', 'dudu_dk2012@hotmail.com', 0, 0),
(45, 45, 'Bart_KingsMan', '$2y$10$j2YnHOj70JBVqVqJjuHO1.9Q96V/YOutmEgsEQlV3zsQws90jK1uK', '', 'petrick9871@gmail.com', 0, 0),
(46, 46, 'Zenitsu', '$2y$10$HbQHTgcT3.H9Jpn4h.Rc7uh8JmA67C8m.MTcGvGtAviPuD7/G9Hk6', '', 'clownkiing@hotmail.com', 0, 0),
(47, 47, 'Escanor_AimBoT', '$2y$10$HBS7kvMBzrKaFY7h6sIRnu5Md/wHsof6ZZ82yioVWqYGeLrj/kfq2', '', 'rivesnuno@gmail.com', 0, 0),
(48, 48, 'Jorge_KingsMan', '$2y$10$dk2LXOCy2VikfRJxHqhPx.cnoBArcKmW0QPkkuHLJ.D6lkkGibUHO', '', 'admfelippe08@gmail.com', 0, 0),
(49, 49, 'Swwet_KingsMan', '$2y$10$HzZfB0lYlphZVuY.xYBKsOHh1Uz9O6WDzbKfoUYe2jog90p3P86X.', '', 'valdirpinto90@gmail.com', 0, 0),
(51, 51, 'SaaDz_KingsMan', '$2y$10$/Ra7yo0qBkEPwLRERmlvHOxPvHvR4gtVdzzc6DnDIkc.wuBuCVl/.', '', 'murilo.0santana2012@gmail.com', 0, 0),
(52, 52, 'Berlim', '$2y$10$JV1OyMjgBfWwfNQWy01HMu53fZLyuROMXcVvkUnig0dhxLvdk0hf2', '', 'xhackergrupox@gmail.com', 0, 0),
(53, 53, 'luiscabral12', '$2y$10$TUFE0akum8hAz0.oPQB4vuJtGNZ0gBPX02ZF2y75HLDLbN5DQ8.Hq', '', 'luiscabral012@gmail.com', 0, 0),
(54, 54, 'KSoSy_KingsMan', '$2y$10$3kwNYD58wfDG4xQ9CSGKM.CSilViW41ptwGQT8YiH2262eFzYeCvu', '', 'manowrain12@gmail.com', 0, 0),
(55, 55, 'Cajuzin_KingsMan', '$2y$10$OQs.AOqnMVNiUY1yWkK7v.tLlWpvNcU5OM4zu.lIvGbBI8cQ71.pq', '', 'ferreiragabriel400@hotmail.com', 0, 0),
(56, 56, 'jungkook_KingsMan', '$2y$10$odiG95k5XMv/ymgC5kJwyeB.MCt0S8K/1XswQpaD0xG.LOhQFCKDy', '', 'diogomorello7@gmail.com', 0, 0),
(57, 57, 'Small', '$2y$10$s6Y5m6G0JEd4Rqqcv5wHP.vdkb9XEFhyTT0A.WWHMiLYICWDTZdki', '', 'playerryan8@gmail.com', 0, 0),
(59, 59, 'sky_', '$2y$10$ngQGLNpoMxHRwU0yw2jykuApVSlSayt9ZGatdChvDWNwuvQHhKtQa', '', 'douglasdaluzpaulista@gmail.com', 0, 0),
(60, 60, 'Tuba_KingsMan', '$2y$10$A4KVGCVusjohgrGXR5Phje46rYBiX2mTno8myD/Jv8w996.tHyHG.', '', 'ryansilvacosta2018@outlook.com', 0, 0),
(62, 62, 'Nicholas_Camargo', '$2y$10$dcBxzydKGqkPPY9I8JNC3uYTzwg2tJcVB4idTPD1cIAu/uxsjDDP6', '', 'nicolascamargosn@outlook.com', 0, 0),
(63, 63, 'BiG', '$2y$10$cmLC/kZUGDYccmlLSz.qSum6ufh9zA91//NtxVbhlmDLuJ.4muLOy', '', 'higormello008@gmail.com', 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
