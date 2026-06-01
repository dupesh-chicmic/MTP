-- adding user login to eliminate need of using email as login as they are long sometimes.
ALTER TABLE `uzytkownik` ADD `email` VARCHAR(254) NULL AFTER `status_uzytkownika`;

UPDATE `uzytkownik` SET `email`=`login` WHERE 1 

--ranges for used cars
ALTER TABLE `used_cars_model` ADD `cartype` VARCHAR( 255 ) NULL ,
ADD `rangecode` INT NULL ;
--ranges for used comms
ALTER TABLE `used_com_cars_model` ADD `rangecode` INT NULL ;


CREATE TABLE IF NOT EXISTS `used_cars_ranges` (
  `id` int(11) NOT NULL,
  `id_import` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `rangecode` int(11) NOT NULL,
  `rangedesc` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `used_comms_ranges` (
  `id` int(11) NOT NULL,
  `id_import` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `rangecode` int(11) NOT NULL,
  `rangedesc` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- security for users:
ALTER TABLE `uzytkownik` ADD `desktop_token` VARCHAR( 50 ) NULL AFTER `mobile_token` ;

ALTER TABLE `uzytkownik` ADD `network_licences_number` INT NULL ;

CREATE TABLE IF NOT EXISTS `uzytkownik_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `uzytkownik_id` int(11) NOT NULL,
  `sid` varchar(128) default NULL,
  `when` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `user_token_changes` (
  `id` int(11) NOT NULL auto_increment,
  `uzytkownik_id` int(11) NOT NULL,
  `when` timestamp NULL default CURRENT_TIMESTAMP,
  `ip_address` varchar(50) default NULL,
  `old_token` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
