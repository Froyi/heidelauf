-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.7.19 - MySQL Community Server (GPL)
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Struktur von Tabelle heidelauf.run
CREATE TABLE IF NOT EXISTS `run` (
  `runId` varchar(200) NOT NULL,
  `transponderNumber` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`runId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle heidelauf.run: 2 rows
/*!40000 ALTER TABLE `run` DISABLE KEYS */;
INSERT INTO `run` (`runId`, `transponderNumber`, `timestamp`) VALUES
	('11212ce0-a5db-4d20-b5b2-bbc17e8772a0', 1, '2018-06-20 13:19:08'),
	('d9e344f1-0ec7-4038-b7d6-36055f862e16', 1, '2018-06-20 13:20:28');
/*!40000 ALTER TABLE `run` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle heidelauf.team
CREATE TABLE IF NOT EXISTS `team` (
  `teamId` varchar(200) NOT NULL,
  `teamName` varchar(200) NOT NULL,
  `transponderNumber` int(11) NOT NULL,
  `extreme` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`teamId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle heidelauf.team: 22 rows
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` (`teamId`, `teamName`, `transponderNumber`, `extreme`) VALUES
	('1abdeadb-8c29-4714-9394-6db901a8af6f', 'UniversitÃ¤t Halle', 20, 0),
	('58fb8242-baed-4892-8cca-6b939c356ae3', 'Team Super', 18, 0),
	('aa96297e-71f2-4f49-9418-d20cb2ff8518', 'Running Tthal', 19, 0),
	('3679bab7-cf58-4cfe-8add-497408a2d2fb', 'Turbine Halle', 13, 0),
	('6bb5eaa9-3c16-4df7-9f7e-dbeecb8afd86', 'Orientierungslos', 14, 0),
	('fb27bb57-11c5-4a63-9a6e-b79d0594ff50', 'Ultra Running Team Halle', 15, 1),
	('6c31c2a9-68e3-4a92-a0fc-fe28e4bbdd66', 'Running TÃœVtler', 16, 0),
	('6d6e0c07-3d16-4007-aff8-6e79903c2093', 'HWG aktiv', 17, 0),
	('0a2588ae-23f4-4f61-bc26-e240fd400900', 'Running Rabbits', 1, 0),
	('ff03042f-7c96-47d2-ac74-4da54e0ce835', 'Schildhauers Erben', 2, 0),
	('248706bb-f1a6-4b90-8a3f-be17a36a31f9', 'Schmiede Dich', 3, 1),
	('fe673d09-628c-4495-b5c3-33a61659de34', 'Halleluja 2018', 4, 0),
	('c067e73e-d185-4c1b-842f-34b32ac3e130', 'Heidemudderer', 5, 0),
	('317a98a4-f2dc-473f-b135-790563619acb', 'Heidemudderer Extrem 1', 6, 1),
	('440c13cc-74a7-40e3-b5f5-e7eb91a899ff', 'Heidemudderer Extrem 2', 7, 1),
	('ab86e7d3-37eb-4584-9796-80a4ea5d001e', 'SG Elbe-Saale', 8, 0),
	('e601764d-ea72-4615-905d-948e35aa9498', 'Turn Team Halle', 9, 0),
	('2df28ee7-e742-4537-b248-5ddecf4e66b1', 'Eisleber FrÃ¼hlingslÃ¤ufer', 10, 0),
	('7ca52a13-eaae-4d25-ba58-92be3028945d', 'Eisleber FrÃ¼hlingslÃ¤ufer', 11, 0),
	('79299672-7513-47bd-bd24-53aae9196e6a', 'Freerennnix', 12, 0),
	('86759b78-26be-4398-8790-57207647488c', 'LAV Halenisa 1 "Schleichende Hal(l)unken"', 21, 1),
	('b1c5b6d4-741c-44f3-a12a-9273708c557b', 'LAV Halensia 2', 22, 0);
/*!40000 ALTER TABLE `team` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
