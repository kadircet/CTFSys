CREATE TABLE `contest`
(
	`id` int(11) NOT NULL auto_increment,
	`startTime` int(11),
	PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `msgBoard`
(
	`id` int(11) NOT NULL auto_increment,
	`teamID` int(11) NOT NULL,
	`msg` varchar(255),
	`time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY `teamID` (`teamID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `teams`
(
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(255) UNIQUE,
	`pass` varchar(512),
	`salt` varchar(255),
	`mail` varchar(255),
	`status` int NOT NULL,
	`regdate` DATETIME,
	`members` varchar(255),
	`score` int DEFAULT 0,
	`realscore` int DEFAULT 0,
	`verification` varchar(255),
	`lang` varchar(5) DEFAULT 'EN',
	PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(8192) DEFAULT NULL,
  `solvers` varchar(255) DEFAULT NULL,
  `realsolvers` varchar(255) DEFAULT NULL,
  `cat` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `point` int(11) DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teamID` (`teamID`),
  KEY `taskID` (`taskID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `flags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `flag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teamID` (`teamID`),
  KEY `taskID` (`taskID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

