/*
 * Changes on database please add below
 */

ALTER TABLE  `used_cars_model` ADD  `corecode` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `note5`;
ALTER TABLE  `used_cars_model` ADD  `rge` VARCHAR( 255 ) NULL DEFAULT  NULL;
ALTER TABLE  `used_cars_model` ADD  `bod` VARCHAR( 255 ) NULL DEFAULT  NULL;
ALTER TABLE  `used_cars_model` ADD  `drs` VARCHAR( 255 ) NULL DEFAULT  NULL;
ALTER TABLE  `used_cars_model` ADD  `notenum` VARCHAR( 255 ) NULL DEFAULT  NULL;
ALTER TABLE  `used_cars_model` ADD  `badgetype` VARCHAR( 255 ) NULL DEFAULT  NULL;
ALTER TABLE  `used_cars_model` ADD  `transmission` VARCHAR( 255 ) NULL DEFAULT  NULL;

ALTER TABLE  `used_com_cars_model` ADD  `corecode` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `note5`;
ALTER TABLE  `used_com_cars_model` ADD  `rge` VARCHAR( 255 ) NULL DEFAULT NULL;
ALTER TABLE  `used_com_cars_model` ADD  `bod` VARCHAR( 255 ) NULL DEFAULT NULL;
ALTER TABLE  `used_com_cars_model` ADD  `drs` VARCHAR( 255 ) NULL DEFAULT NULL;
ALTER TABLE  `used_com_cars_model` ADD  `notenum` VARCHAR( 255 ) NULL DEFAULT NULL;
ALTER TABLE  `used_com_cars_model` ADD  `badgetype` VARCHAR( 255 ) NULL DEFAULT NULL;
ALTER TABLE  `used_com_cars_model` ADD  `transmission` VARCHAR( 255 ) NULL DEFAULT NULL;

ALTER TABLE  `used_cars_model` ADD  `mdl` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `rge`;
ALTER TABLE  `used_com_cars_model` ADD  `mdl` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `rge`;

UPDATE `en_cms_page` SET `name` = 'Used Valuations', `link_name` = 'Used Valuations' WHERE `id`=70;
UPDATE `en_cms_page` SET `name` = 'Commercials & 4WDs', `link_name` = 'Commercials & 4WDs' WHERE `id`=73;

UPDATE `en_cms_page` SET `param_1` = 'index.php?r=site/loggedWelcome' , `function` = 4 WHERE `id`=75;

ALTER TABLE  `used_cars_model` ADD  `linkas` VARCHAR( 255 ) NULL DEFAULT  NULL;
ALTER TABLE  `used_com_cars_model` ADD  `linkas` VARCHAR( 255 ) NULL DEFAULT NULL;


-- Michal amends 12-2015

-- electric cars amends
ALTER TABLE `xml_kms_bands_model` ADD `electricUp` CHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `dieselDn` ,
ADD `electricDn` CHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `electricUp` ;

CREATE TABLE IF NOT EXISTS `xml_electric_bands_model` (
  `id` int(11) NOT NULL auto_increment,
  `id_import` int(11) NOT NULL,
  `fromXml` int(11) default NULL,
  `toXml` int(11) default NULL,
  `yr1` int(11) default NULL,
  `yr2` int(11) default NULL,
  `yr3` int(11) default NULL,
  `yr4` int(11) default NULL,
  `yr5` int(11) default NULL,
  `yr6` int(11) default NULL,
  `yr7` int(11) default NULL,
  `yr8` int(11) default NULL,
  `yr9` int(11) default NULL,
  `yr10` int(11) default NULL,
  `yr11` int(11) default NULL,
  `yr12` int(11) default NULL,
  `yr13` int(11) default NULL,
  `yr14` int(11) default NULL,
  `yr15` int(11) default NULL,
  `yr16` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id_import` (`id_import`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Constraints for table `xml_electric_bands_model`
--
ALTER TABLE `xml_electric_bands_model`
  ADD CONSTRAINT `xml_electric_bands_model_ibfk_1` FOREIGN KEY (`id_import`) REFERENCES `import` (`id`) ON DELETE CASCADE;


--
-- Table structure for table `xml_petrol_bands_up_model`
--

CREATE TABLE IF NOT EXISTS `xml_electric_bands_up_model` (
  `id` int(11) NOT NULL auto_increment,
  `id_import` int(11) NOT NULL,
  `fromXml` int(11) default NULL,
  `toXml` int(11) default NULL,
  `yr1` int(11) default NULL,
  `yr2` int(11) default NULL,
  `yr3` int(11) default NULL,
  `yr4` int(11) default NULL,
  `yr5` int(11) default NULL,
  `yr6` int(11) default NULL,
  `yr7` int(11) default NULL,
  `yr8` int(11) default NULL,
  `yr9` int(11) default NULL,
  `yr10` int(11) default NULL,
  `yr11` int(11) default NULL,
  `yr12` int(11) default NULL,
  `yr13` int(11) default NULL,
  `yr14` int(11) default NULL,
  `yr15` int(11) default NULL,
  `yr16` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id_import` (`id_import`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `xml_electric_bands_up_model`
  ADD CONSTRAINT `xml_electric_bands_up_model_ibfk_1` FOREIGN KEY (`id_import`) REFERENCES `import` (`id`) ON DELETE CASCADE;


-- ADD electricUp and electricDn to xml_kms_bands_model
-- ADD electricUp and electricDn to xml_kms_bands_model
-- ADD electricUp and electricDn to xml_kms_bands_model
-- ADD electricUp and electricDn to xml_kms_bands_model
-- ADD electricUp and electricDn to xml_kms_bands_model

CREATE TABLE IF NOT EXISTS `xml_ucars_links` (
  `id` int(11) NOT NULL auto_increment,
  `id_import` int(11) NOT NULL,
  `maker` char(100) NOT NULL,
  `linkcode` char(20) NOT NULL,
  `codenumber` char(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `linkcode` (`linkcode`,`codenumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `xml_ucomms_links` (
  `id` int(11) NOT NULL auto_increment,
  `id_import` int(11) NOT NULL,
  `maker` char(100) NOT NULL,
  `linkcode` char(20) NOT NULL,
  `codenumber` char(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `linkcode` (`linkcode`,`codenumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
