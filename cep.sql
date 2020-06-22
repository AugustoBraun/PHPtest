-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.23 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for cep
CREATE DATABASE IF NOT EXISTS `cep` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `cep`;

-- Dumping structure for table cep.ceps
CREATE TABLE IF NOT EXISTS `ceps` (
  `cepId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cep` int(10) unsigned NOT NULL,
  `logradouro` varchar(150) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `localidade` varchar(150) NOT NULL,
  `uf` char(2) NOT NULL,
  `xml` text NOT NULL,
  PRIMARY KEY (`cepId`),
  KEY `cepId` (`cepId`),
  KEY `cepNumber` (`cep`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cep.ceps: 5 rows
DELETE FROM `ceps`;
/*!40000 ALTER TABLE `ceps` DISABLE KEYS */;
INSERT INTO `ceps` (`cepId`, `cep`, `logradouro`, `bairro`, `localidade`, `uf`, `xml`) VALUES
	(87, 88036200, 'Rua Doutor Percy João de Borba', 'Trindade', 'Florianópolis', 'SC', '<?xml version="1.0" encoding="UTF-8"?>\n<xmlcep>\n  <cep>88036-200</cep>\n  <logradouro>Rua Doutor Percy João de Borba</logradouro>\n  <complemento></complemento>\n  <bairro>Trindade</bairro>\n  <localidade>Florianópolis</localidade>\n  <uf>SC</uf>\n  <unidade></unidade>\n  <ibge>4205407</ibge>\n  <gia></gia>\n</xmlcep>\n'),
	(84, 88820000, '', '', 'Içara', 'SC', '<?xml version="1.0" encoding="UTF-8"?>\n<xmlcep>\n  <cep>88820-000</cep>\n  <logradouro></logradouro>\n  <complemento></complemento>\n  <bairro></bairro>\n  <localidade>Içara</localidade>\n  <uf>SC</uf>\n  <unidade></unidade>\n  <ibge>4207007</ibge>\n  <gia></gia>\n</xmlcep>\n</xml>\n'),
	(65, 88036230, 'Rua Capitão Pedro Bruno de Lima', 'Trindade', 'Florianópolis', 'SC', '<?xml version="1.0" encoding="UTF-8"?>\n<xmlcep>\n  <cep>88036-230</cep>\n  <logradouro>Rua Capitão Pedro Bruno de Lima</logradouro>\n  <complemento></complemento>\n  <bairro>Trindade</bairro>\n  <localidade>Florianópolis</localidade>\n  <uf>SC</uf>\n  <unidade></unidade>\n  <ibge>4205407</ibge>\n  <gia></gia>\n</xmlcep>\n'),
	(62, 88080350, 'Rua Pascoal Simone', 'Coqueiros', 'Florianópolis', 'SC', '<?xml version="1.0" encoding="UTF-8"?>\n<xmlcep>\n  <cep>88080-350</cep>\n  <logradouro>Rua Pascoal Simone</logradouro>\n  <complemento></complemento>\n  <bairro>Coqueiros</bairro>\n  <localidade>Florianópolis</localidade>\n  <uf>SC</uf>\n  <unidade></unidade>\n  <ibge>4205407</ibge>\n  <gia></gia>\n</xmlcep>\n'),
	(66, 88101360, 'Rua Professora Maria do Carmo Souza', 'Campinas', 'São José', 'SC', '<?xml version="1.0" encoding="UTF-8"?>\n<xmlcep>\n  <cep>88101-360</cep>\n  <logradouro>Rua Professora Maria do Carmo Souza</logradouro>\n  <complemento></complemento>\n  <bairro>Campinas</bairro>\n  <localidade>São José</localidade>\n  <uf>SC</uf>\n  <unidade></unidade>\n  <ibge>4216602</ibge>\n  <gia></gia>\n</xmlcep>\n');
/*!40000 ALTER TABLE `ceps` ENABLE KEYS */;

-- Dumping structure for table cep.login
CREATE TABLE IF NOT EXISTS `login` (
  `id_login` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nivel` int(11) DEFAULT '3',
  `nome` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `login` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `senha` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_login`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cep.login: ~0 rows (approximately)
DELETE FROM `login`;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` (`id_login`, `nivel`, `nome`, `email`, `login`, `senha`) VALUES
	(1, 1, 'Usuário Teste', 'augusto@augustobraun.com', 'usuario', 'e8d95a51f3af4a3b134bf6bb680a213a');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
