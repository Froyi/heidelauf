CREATE DATABASE `heidelauf` /*!40100 COLLATE 'utf8_general_ci' */

CREATE TABLE `team` (
	`teamId` VARCHAR(200) NOT NULL,
	`teamName` VARCHAR(200) NOT NULL,
	`transponderNumber` INT(11) NOT NULL,
	`isExtreme` TINYINT(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`teamId`)
);

CREATE TABLE `run` (
	`runId` VARCHAR(200) NOT NULL,
	`transponderNumber` INT(11) NOT NULL,
	`timestamp` DATETIME NOT NULL,
	PRIMARY KEY (`runId`)
);

