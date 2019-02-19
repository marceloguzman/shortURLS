-- 
-- Table structure for table `shortURLS`
-- 

CREATE TABLE `shorturls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `long_url` varchar(255) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `creator` char(15) NOT NULL,
  `referrals` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `long` (`long_url`),
  KEY `referrals` (`referrals`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `shorturls` AUTO_INCREMENT=100001;