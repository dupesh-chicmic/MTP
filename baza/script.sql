/*
 * Zmiany ktore nalezy dodac do podstawowej bazy danych
 */

/*
 * zmiany w wersji mobile
 */
INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('100', '1', 'MOBILE_VERSION', 'Mobile Sites', 'Mobile Sites', 'Mobile Sites', 'Mobile Sites', 'Mobile Sites', '1', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999', '0', '0', NULL, '0');
INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('101', '100', 'mob_new_prices', 'New Prices', 'New Prices', 'New Prices', 'New Prices', 'New Prices', '4', '7', NULL, NULL, NULL, 'index.php?r=member/newCars', NULL, NULL, NULL, '998', '0', '1', NULL, '0');
INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('102', '100', 'mob_vrt', 'VRT & Motor Tax Rates', 'VRT & Motor Tax Rates', 'VRT & Motor Tax Rates', 'VRT & Motor Tax Rates', 'VRT & Motor Tax Rates', '4', '7', NULL, NULL, NULL, 'index.php?r=mobile/view&url=vrt_rates', NULL, NULL, NULL, '997', '0', '1', NULL, '0');
INSERT INTO  `mtp`.`en_cms_page` (
`id` ,
`parent_id` ,
`url` ,
`name` ,
`title` ,
`header` ,
`link_name` ,
`keywords` ,
`function` ,
`layout` ,
`template` ,
`seo_visible` ,
`seo_unvisible` ,
`param_1` ,
`param_2` ,
`txt` ,
`button` ,
`order` ,
`editable` ,
`display` ,
`description` ,
`deletable`
)
VALUES (
'103',  '100',  'mob_valuation',  'Vehicle Valuation',  'Vehicle Valuation',  'Vehicle Valuation',  'Vehicle Valuation',  'Vehicle Valuation',  '4',  '7', NULL , NULL , NULL ,  'index.php?r=site/valuation', NULL , NULL , NULL ,  '996',  '0',  '1', NULL ,  '0'
), (
'104',  '100',  'mob_services',  'Serives',  'Services',  'Services',  'Services',  'Services',  '4',  '7', NULL , NULL , NULL ,  'index.php?r=mobile/view&url=services', NULL , NULL , NULL ,  '995',  '0',  '1', NULL ,  '0'
);
INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('105', '100', 'mob_editorials', 'Editorials', 'Editorials', 'Editorials', 'Editorials', 'Editorials', '3', '39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '994', '0', '1', NULL, '0');
INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('106', '100', 'mob_about', 'About', 'About', 'About', 'About', 'About', '4', '7', NULL, NULL, NULL, 'index.php?r=mobile/view&url=about', NULL, NULL, NULL, '993', '0', '1', NULL, '0');
INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('107', '100', 'mob_contact', 'Contact', 'Contact', 'Contact', 'Contact', 'Contact', '2', '17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '991', '0', '1', NULL, '0');
INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('108', '100', 'mob_used_cars', 'Used Cars', 'Used Cars', 'Used Cars', 'Used Cars', 'Used Cars', '4', '7', NULL, NULL, NULL, 'index.php?r=mobile/chooseType', NULL, NULL, NULL, '990', '0', '1', NULL, '0');
--services sub pages
--INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('98', '94', 'mob_products', 'Products', 'Products', 'Products', 'Products', 'Products', '4', '7', NULL, NULL, NULL, 'index.php?r=mobile/view&url=products', NULL, NULL, NULL, '990', '0', '1', NULL, '0');
--INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('99', '94', 'mob_pricing', 'Pricing', 'Pricing', 'Pricing', 'Pricing', 'Pricing', '4', '7', NULL, NULL, NULL, 'index.php?r=mobile/view&url=pricing', NULL, NULL, NULL, '989', '0', '1', NULL, '0');
--INSERT INTO `mtp`.`en_cms_page` (`id`, `parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) VALUES ('100', '94', 'mob_blog', 'Blog', 'Blog', 'Blog', 'Blog', 'Blog', '4', '7', NULL, NULL, NULL, 'index.php?r=mobile/view&url=blog', NULL, NULL, NULL, '988', '0', '1', NULL, '0');

/* zmiana security dla mobile version */
ALTER TABLE  `uzytkownik` CHANGE  `tokens`  `mobile_token` VARCHAR( 50 ) NULL DEFAULT NULL;
UPDATE `uzytkownik` set `mobile_token` = NULL;
ALTER TABLE  `uzytkownik` ADD  `mobile_on` INT( 2 ) NULL DEFAULT  '0' AFTER  `dinkey`;


-- Dodanie pol checks i free_token
ALTER TABLE  `uzytkownik` ADD  `checks` INT( 2 ) NULL DEFAULT  '0' AFTER  `mobile_token`;
ALTER TABLE  `uzytkownik` ADD  `free_tokens` INT NULL DEFAULT  '0' AFTER  `checks`;
-- koniec: Dodanie pol checks i free_token

/*
 * dodanie kolejnych pol yr kms i GRP
 */
ALTER TABLE  `used_cars_model` ADD  `yr8` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP7`;
ALTER TABLE  `used_cars_model` ADD  `kms8` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr8`;
ALTER TABLE  `used_cars_model` ADD  `GRP8` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms8`;

ALTER TABLE  `used_cars_model` ADD  `yr9` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP8`;
ALTER TABLE  `used_cars_model` ADD  `kms9` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr9`;
ALTER TABLE  `used_cars_model` ADD  `GRP9` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms9`;

ALTER TABLE  `used_cars_model` ADD  `yr10` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP9`;
ALTER TABLE  `used_cars_model` ADD  `kms10` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr10`;
ALTER TABLE  `used_cars_model` ADD  `GRP10` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms10`;

ALTER TABLE  `used_cars_model` ADD  `yr11` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP10`;
ALTER TABLE  `used_cars_model` ADD  `kms11` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr11`;
ALTER TABLE  `used_cars_model` ADD  `GRP11` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms11`;

ALTER TABLE  `used_cars_model` ADD  `yr12` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP11`;
ALTER TABLE  `used_cars_model` ADD  `kms12` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr12`;
ALTER TABLE  `used_cars_model` ADD  `GRP12` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms12`;

ALTER TABLE  `used_cars_model` ADD  `yr13` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP12`;
ALTER TABLE  `used_cars_model` ADD  `kms13` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr13`;
ALTER TABLE  `used_cars_model` ADD  `GRP13` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms13`;

ALTER TABLE  `used_cars_model` ADD  `yr14` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP13`;
ALTER TABLE  `used_cars_model` ADD  `kms14` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr14`;
ALTER TABLE  `used_cars_model` ADD  `GRP14` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms14`;

ALTER TABLE  `used_cars_model` ADD  `yr15` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP14`;
ALTER TABLE  `used_cars_model` ADD  `kms15` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr15`;
ALTER TABLE  `used_cars_model` ADD  `GRP15` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms15`;

ALTER TABLE  `used_com_cars_model` ADD  `yr8` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP7`;
ALTER TABLE  `used_com_cars_model` ADD  `kms8` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr8`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP8` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms8`;

ALTER TABLE  `used_com_cars_model` ADD  `yr9` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP8`;
ALTER TABLE  `used_com_cars_model` ADD  `kms9` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr9`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP9` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms9`;

ALTER TABLE  `used_com_cars_model` ADD  `yr10` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP9`;
ALTER TABLE  `used_com_cars_model` ADD  `kms10` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr10`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP10` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms10`;

ALTER TABLE  `used_com_cars_model` ADD  `yr11` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP10`;
ALTER TABLE  `used_com_cars_model` ADD  `kms11` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr11`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP11` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms11`;

ALTER TABLE  `used_com_cars_model` ADD  `yr12` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP11`;
ALTER TABLE  `used_com_cars_model` ADD  `kms12` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr12`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP12` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms12`;

ALTER TABLE  `used_com_cars_model` ADD  `yr13` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP12`;
ALTER TABLE  `used_com_cars_model` ADD  `kms13` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr13`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP13` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms13`;

ALTER TABLE  `used_com_cars_model` ADD  `yr14` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP13`;
ALTER TABLE  `used_com_cars_model` ADD  `kms14` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr14`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP14` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms14`;

ALTER TABLE  `used_com_cars_model` ADD  `yr15` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `GRP14`;
ALTER TABLE  `used_com_cars_model` ADD  `kms15` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `yr15`;
ALTER TABLE  `used_com_cars_model` ADD  `GRP15` CHAR( 100 ) NULL DEFAULT  NULL AFTER  `kms15`;

ALTER TABLE  `xml_dieselbands_model` ADD  `yr10` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr9`;
ALTER TABLE  `xml_dieselbands_model` ADD  `yr11` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr10`;
ALTER TABLE  `xml_dieselbands_model` ADD  `yr12` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr11`;
ALTER TABLE  `xml_dieselbands_model` ADD  `yr13` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr12`;
ALTER TABLE  `xml_dieselbands_model` ADD  `yr14` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr13`;
ALTER TABLE  `xml_dieselbands_model` ADD  `yr15` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr14`;
ALTER TABLE  `xml_dieselbands_model` ADD  `yr16` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr15`;

ALTER TABLE  `xml_dieselbands_up_model` ADD  `yr10` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr9`;
ALTER TABLE  `xml_dieselbands_up_model` ADD  `yr11` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr10`;
ALTER TABLE  `xml_dieselbands_up_model` ADD  `yr12` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr11`;
ALTER TABLE  `xml_dieselbands_up_model` ADD  `yr13` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr12`;
ALTER TABLE  `xml_dieselbands_up_model` ADD  `yr14` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr13`;
ALTER TABLE  `xml_dieselbands_up_model` ADD  `yr15` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr14`;
ALTER TABLE  `xml_dieselbands_up_model` ADD  `yr16` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr15`;

ALTER TABLE  `xml_petrolbands_model` ADD  `yr10` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr9`;
ALTER TABLE  `xml_petrolbands_model` ADD  `yr11` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr10`;
ALTER TABLE  `xml_petrolbands_model` ADD  `yr12` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr11`;
ALTER TABLE  `xml_petrolbands_model` ADD  `yr13` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr12`;
ALTER TABLE  `xml_petrolbands_model` ADD  `yr14` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr13`;
ALTER TABLE  `xml_petrolbands_model` ADD  `yr15` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr14`;
ALTER TABLE  `xml_petrolbands_model` ADD  `yr16` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr15`;

ALTER TABLE  `xml_petrolbands_up_model` ADD  `yr10` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr9`;
ALTER TABLE  `xml_petrolbands_up_model` ADD  `yr11` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr10`;
ALTER TABLE  `xml_petrolbands_up_model` ADD  `yr12` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr11`;
ALTER TABLE  `xml_petrolbands_up_model` ADD  `yr13` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr12`;
ALTER TABLE  `xml_petrolbands_up_model` ADD  `yr14` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr13`;
ALTER TABLE  `xml_petrolbands_up_model` ADD  `yr15` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr14`;
ALTER TABLE  `xml_petrolbands_up_model` ADD  `yr16` INT( 11 ) NULL DEFAULT  NULL AFTER  `yr15`;

RENAME TABLE `xml_kmsbands_model` TO `xml_kms_bands_model` ;
RENAME TABLE `xml_dieselbands_model` TO `xml_diesel_bands_model` ;
RENAME TABLE `xml_dieselbands_up_model` TO `xml_diesel_bands_up_model` ;
RENAME TABLE `xml_petrolbands_model` TO `xml_petrol_bands_model` ;
RENAME TABLE `xml_petrolbands_up_model` TO `xml_petrol_bands_up_model` ;

-- zmiany przy wdrozeniu new cars/comms z nowymi xml
UPDATE `mtp`.`en_cms_page` SET `param_1`='index.php?r=mobile/chooseNewPrices', `function`='1' WHERE `id`='101';
UPDATE `mtp`.`en_cms_page` SET `name` = 'Commercial & 4WD',`title` = 'Commercial & 4WD',`link_name` = 'Commercial & 4WD',`header` = 'Commercial & 4WD' WHERE `name`='Commercial';

/* ---------------------------------------------------------------------------*/
/* ----------------- powyzsze zmiany oddane 31.07.2014 ---------------------- */
/* ----------------------- zmiany oddawac ponizej --------------------------- */
/* ---------------------------------------------------------------------------*/

-- menu: web
INSERT INTO `en_cms_page` (`parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) 
VALUES ('3', 'pay_invoice', 'Pay Invoice', 'Pay Invoice', 'Pay Invoice', 'Pay Invoice', 'Pay Invoice', '4', '7', NULL, NULL, NULL, 'index.php?r=realex/payInvoice', NULL, NULL, NULL, '9', '0', '1', NULL, '0');

-- menu: mobile
INSERT INTO `en_cms_page` (`parent_id`, `url`, `name`, `title`, `header`, `link_name`, `keywords`, `function`, `layout`, `template`, `seo_visible`, `seo_unvisible`, `param_1`, `param_2`, `txt`, `button`, `order`, `editable`, `display`, `description`, `deletable`) 
VALUES ('100', 'pay_invoice', 'Pay Invoice', 'Pay Invoice', 'Pay Invoice', 'Pay Invoice', 'Pay Invoice', '4', '7', NULL, NULL, NULL, 'index.php?r=realex/payInvoice', NULL, NULL, NULL, '9', '0', '1', NULL, '0');


-- uaktualnic strukture aby dzialal realex
DROP TABLE `settings`;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL auto_increment,
  `category` varchar(64) NOT NULL default 'system',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `category_key` (`category`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'merchant ID', 's:20:"motortradepublishers";');
INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'hosted payment page URL', 's:34:"https://hpp.realexpayments.com/pay";');
INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'test hosted payment page URL', 's:42:"https://hpp.sandbox.realexpayments.com/pay";');
INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'shared secret', 's:10:"dhFphqVRPa";');
INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'default currency', 's:3:"EUR";');
INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'account', 's:8:"internet";');
INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'merchant response URL', 's:70:"http://www.mtp.ie/test/index.php?r=qpay/qpayrealex/qpayrealex/response";');
INSERT INTO `settings` (`category`, `key`, `value`) VALUES ('qpay.realex', 'test mode', 'b:1;');

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL auto_increment,
  `no` varchar(20) NOT NULL,
  `total_gross` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `bp_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `no` (`no`),
  KEY `bp_id` (`bp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `invoice_qpay_request` (
  `invoice_id` int(11) NOT NULL,
  `qpay_request_id` int(11) NOT NULL,
  UNIQUE KEY `invoice_id_2` (`invoice_id`,`qpay_request_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `qpay_request_id` (`qpay_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `qpay_method` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `qpay_realex_request` (
  `order_id` int(11) NOT NULL auto_increment,
  `merchant_id` varchar(50) NOT NULL,
  `account` varchar(30) default NULL,
  `currency` char(3) NOT NULL,
  `amount` int(11) NOT NULL,
  `timestamp` char(14) NOT NULL,
  `sha1hash` char(40) NOT NULL,
  `auto_settle_flag` bit(1) default NULL,
  `comment1` varchar(255) NOT NULL,
  `comment2` varchar(255) NOT NULL,
  `return_tss` bit(1) default NULL,
  `shipping_code` varchar(30) default NULL,
  `shipping_co` varchar(50) default NULL,
  `billing_cod` varchar(50) default NULL,
  `cust_num` varchar(50) default NULL,
  `var_ref` varchar(50) default NULL,
  `prod_id` varchar(50) default NULL,
  `hpp_lang` char(2) default NULL,
  `merchant_response_url` varchar(255) default NULL,
  `card_payment_button` varchar(25) default NULL,
  `authcode` varchar(30) default NULL,
  `result` varchar(10) default NULL,
  `message` varchar(255) default NULL,
  `cvnresult` char(3) default NULL,
  `pasref` varchar(30) default NULL,
  `batchid` int(11) default NULL,
  `eci` varchar(30) default NULL,
  `cavv` varchar(30) default NULL,
  `xid` varchar(30) default NULL,
  `tss` varchar(30) default NULL,
  `tss_idnum` varchar(30) default NULL,
  `local_order_id` int(11) default NULL,
  PRIMARY KEY  (`order_id`),
  KEY `local_id` (`local_order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `qpay_request` (
  `id` int(11) NOT NULL auto_increment,
  `method_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `timestamp` datetime default NULL,
  `status` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `method_id` (`method_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `invoice_qpay_request`
  ADD CONSTRAINT `invoice_qpay_request_ibfk_2` FOREIGN KEY (`qpay_request_id`) REFERENCES `qpay_request` (`id`),
  ADD CONSTRAINT `invoice_qpay_request_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`);

ALTER TABLE `qpay_realex_request`
  ADD CONSTRAINT `qpay_realex_request_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `qpay_request` (`id`) ON DELETE CASCADE;

ALTER TABLE `qpay_request`
  ADD CONSTRAINT `qpay_request_ibfk_1` FOREIGN KEY (`method_id`) REFERENCES `qpay_method` (`id`);

-- zmiana kolejnosci wyswietlania w menu WEB
UPDATE `en_cms_page` SET `order`=61 WHERE `parent_id`=70 and id=83; -- archive
UPDATE `en_cms_page` SET `order`=62 WHERE `parent_id`=70 and id=74; -- reports

-- zmiana labelki
UPDATE `en_cms_page` SET `name` = 'Pay Subscription',`title` = 'Pay Subscription',`link_name` = 'Pay Subscription',`header` = 'Pay Subscription' WHERE `name`='Pay Invoice';

-- zmiana kolejnosci wyswietlania w menu MOBILE
UPDATE `en_cms_page` SET `order`=8 WHERE `name`='Pay Subscription' and `parent_id`=100;
UPDATE `en_cms_page` SET `order`=9 WHERE `name`='About' and `parent_id`=100;

UPDATE `en_cms_page` SET `name` = 'VRT & Motor Tax',`title` = 'VRT & Motor Tax',`link_name` = 'VRT & Motor Tax',`header` = 'VRT & Motor Tax' WHERE `name`='VRT rates';

/* ---------------------------------------------------------------------------*/
/* ----------------- powyzsze zmiany oddane 27.08.2014 ---------------------- */
/* ----------------------- zmiany oddawac ponizej --------------------------- */
/* ---------------------------------------------------------------------------*/

-- MOBILE: zmiana labelki Used Cars na Used Values
UPDATE `en_cms_page` SET `name` = 'Used Values',`title` = 'Used Values',`link_name` = 'Used Values',`header` = 'Used Values' WHERE `id`=108 and `name`='Used Cars';

-- DESKTOP: zmiana przekierowania
UPDATE `en_cms_page` SET `param_1` = 'index.php?r=member/newPricesCars' WHERE `id`=65 or `id`=66;
UPDATE `en_cms_page` SET `param_1` = 'index.php?r=member/newPricesComms' WHERE `id`=67;

-- dodanie pol dla licencji cars i comms DESKTOP
ALTER TABLE `uzytkownik` CHANGE lic_start lic_start_cars date DEFAULT NULL;
ALTER TABLE `uzytkownik` CHANGE lic_exp_date lic_exp_cars date DEFAULT NULL;

ALTER TABLE `uzytkownik` ADD `lic_start_comm` date DEFAULT NULL;
ALTER TABLE `uzytkownik` ADD `lic_exp_comm` date DEFAULT NULL;

-- dodanie pol dla licencji cars i comms MOBILE
ALTER TABLE `uzytkownik` ADD `lic_start_cars_mob` date DEFAULT NULL;
ALTER TABLE `uzytkownik` ADD `lic_exp_cars_mob` date DEFAULT NULL;

ALTER TABLE `uzytkownik` ADD `lic_start_comm_mob` date DEFAULT NULL;
ALTER TABLE `uzytkownik` ADD `lic_exp_comm_mob` date DEFAULT NULL;

-- update aktualny licencji start expired do nowych column
UPDATE `uzytkownik` SET `lic_start_comm`= `lic_start_cars`;
UPDATE `uzytkownik` SET `lic_start_cars_mob`= `lic_start_cars`;
UPDATE `uzytkownik` SET `lic_start_comm_mob`= `lic_start_cars`;

UPDATE `uzytkownik` SET `lic_exp_comm`= `lic_exp_cars`;
UPDATE `uzytkownik` SET `lic_exp_cars_mob`= `lic_exp_cars`;
UPDATE `uzytkownik` SET `lic_exp_comm_mob`= `lic_exp_cars`;

-- fix do REALXa
INSERT INTO `qpay_method` (`id` ,`name`) VALUES (NULL ,  'realex');

/* ---------------------------------------------------------------------------*/
/* ----------------- powyzsze zmiany oddane 13.01.2015 ---------------------- */
/* ----------------------- zmiany oddawac ponizej --------------------------- */
/* ---------------------------------------------------------------------------*/

-- dodanie nowych pol do importu z xml
ALTER TABLE  `used_cars_model` ADD  `diff0` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP0`;
ALTER TABLE  `used_cars_model` ADD  `diff1` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP1`;
ALTER TABLE  `used_cars_model` ADD  `diff2` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP2`;
ALTER TABLE  `used_cars_model` ADD  `diff3` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP3`;
ALTER TABLE  `used_cars_model` ADD  `diff4` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP4`;
ALTER TABLE  `used_cars_model` ADD  `diff5` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP5`;
ALTER TABLE  `used_cars_model` ADD  `diff6` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP6`;
ALTER TABLE  `used_cars_model` ADD  `diff7` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP7`;
ALTER TABLE  `used_cars_model` ADD  `diff8` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP8`;
ALTER TABLE  `used_cars_model` ADD  `diff9` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP9`;
ALTER TABLE  `used_cars_model` ADD  `diff10` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP10`;
ALTER TABLE  `used_cars_model` ADD  `diff11` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP11`;
ALTER TABLE  `used_cars_model` ADD  `diff12` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP12`;
ALTER TABLE  `used_cars_model` ADD  `diff13` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP13`;
ALTER TABLE  `used_cars_model` ADD  `diff14` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP14`;
ALTER TABLE  `used_cars_model` ADD  `diff15` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP15`;

ALTER TABLE  `used_com_cars_model` ADD  `diff0` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP0`;
ALTER TABLE  `used_com_cars_model` ADD  `diff1` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP1`;
ALTER TABLE  `used_com_cars_model` ADD  `diff2` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP2`;
ALTER TABLE  `used_com_cars_model` ADD  `diff3` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP3`;
ALTER TABLE  `used_com_cars_model` ADD  `diff4` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP4`;
ALTER TABLE  `used_com_cars_model` ADD  `diff5` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP5`;
ALTER TABLE  `used_com_cars_model` ADD  `diff6` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP6`;
ALTER TABLE  `used_com_cars_model` ADD  `diff7` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP7`;
ALTER TABLE  `used_com_cars_model` ADD  `diff8` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP8`;
ALTER TABLE  `used_com_cars_model` ADD  `diff9` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP9`;
ALTER TABLE  `used_com_cars_model` ADD  `diff10` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP10`;
ALTER TABLE  `used_com_cars_model` ADD  `diff11` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP11`;
ALTER TABLE  `used_com_cars_model` ADD  `diff12` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP12`;
ALTER TABLE  `used_com_cars_model` ADD  `diff13` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP13`;
ALTER TABLE  `used_com_cars_model` ADD  `diff14` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP14`;
ALTER TABLE  `used_com_cars_model` ADD  `diff15` VARCHAR( 255 ) NULL DEFAULT  NULL AFTER  `GRP15`;

/* ---------------------------------------------------------------------------*/
/* ----------------- powyzsze zmiany oddane 23.04.2015 ---------------------- */
/* ----------------------- zmiany oddawac ponizej --------------------------- */
/* ---------------------------------------------------------------------------*/
