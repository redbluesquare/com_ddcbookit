CREATE TABLE IF NOT EXISTS `#__ddcbookit_services` (
  `ddcbookit_serivce_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) NOT NULL,
  `service_class` varchar(100) NOT NULL,
  `service_description` text NOT NULL,
  PRIMARY KEY (`ddcbookit_services_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `#__ddcbookit_apartment_prices` 
ADD COLUMN `startdate` DATE NULL DEFAULT '0000-00-00' AFTER `modified`,
ADD COLUMN `enddate` DATE NULL DEFAULT '0000-00-00' AFTER `startdate`,
ADD `catid` int(11) NOT NULL DEFAULT '0' AFTER `enddate`,
ADD INDEX `startdate` (`startdate` ASC, `enddate` ASC);

ALTER TABLE `#__ddcbookit_apartments` CHANGE COLUMN `default_price` `featured` INT NULL DEFAULT NULL,
ADD `catid` int(11) NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `#__ddcbookit_poi` (
  `ddcbookit_poi_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NULL,
  `address1` varchar(45) NOT NULL,
  `address2` varchar(45) NOT NULL,
  `town` varchar(45) NOT NULL,
  `county` varchar(45) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `state` tinyint(3) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddcbookit_poi_id`),
  KEY `post_code` (`post_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;