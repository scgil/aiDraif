START TRANSACTION;


DROP USER IF EXISTS 'tester'@'localhost';
DROP DATABASE IF EXISTS Aidraif;

CREATE USER 'tester'@'localhost' IDENTIFIED BY 'tester';

CREATE DATABASE IF NOT EXISTS `Aidraif`; 
USE 'Aidraif';

CREATE TABLE IF NOT EXISTS `USER`(
			`email` VARCHAR(40) NOT NULL,
			`password` CHAR(32) CHARACTER SET 'ascii' NOT NULL,
			`login` CHAR(40) NOT NULL,

		CONSTRAINT `pk_user` PRIMARY KEY USING HASH (`email`)
);

CREATE TABLE IF NOT EXISTS `DIRECTORY`(
			`name` VARCHAR(30) NOT NULL,
			`owner` VARCHAR(40) NOT NULL,
			`uuid` CHAR(36) NOT NULL, 
			`father` CHAR(36) DEFAULT NULL,
		CONSTRAINT `pk_uuid` PRIMARY KEY USING HASH (`uuid`),
		CONSTRAINT `recursive_father` FOREIGN KEY (`father`) REFERENCES `DIRECTORY`(`uuid`) ON UPDATE CASCADE,
		CONSTRAINT `fk_owner` FOREIGN KEY (`owner`) REFERENCES `USER`(`email`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `FILES`(
			`originalName` VARCHAR(50) NOT NULL,
			`uuid` CHAR(36)  NOT NULL,
			`father` CHAR(36) NOT NULL,
			`owner` VARCHAR(40) NOT NULL,
			`mimeType`  VARCHAR(25) NOT NULL,
		CONSTRAINT `pk_uuid_files` PRIMARY KEY USING HASH (`uuid`),
		CONSTRAINT `recursive_father_for_files` FOREIGN KEY (`father`) REFERENCES `DIRECTORY` (`uuid`) ON UPDATE CASCADE,
		CONSTRAINT `fk_owner_files` FOREIGN KEY (`owner`) REFERENCES `USER` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `SHARES`(
			`uuid` CHAR(36) NOT NULL,
			`share_id` CHAR(36) NOT NULL,

		CONSTRAINT `pk_share` PRIMARY KEY USING HASH (`uuid`,`share_id`),
		CONSTRAINT `fk_uuid` FOREIGN KEY (`uuid`) REFERENCES `FILES`(`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `USER` SET  `email` = 'test@test.test',
						`password` = '098f6bcd4621d373cade4e832627b4f6', -- test en MD5--
						`login` = 'tester';
INSERT INTO `DIRECTORY` SET `name`= '/',
							`owner` = 'test@test.test',
							`uuid` = '1';

GRANT SELECT, UPDATE, INSERT, DELETE ON TABLE `USER` TO 'tester'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON TABLE `DIRECTORY` TO 'tester'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON TABLE `FILES` TO 'tester'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON TABLE `SHARES` TO 'tester'@'localhost';

COMMIT;