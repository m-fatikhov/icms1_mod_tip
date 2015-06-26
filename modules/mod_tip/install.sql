DROP TABLE IF EXISTS `#__mod_tip`;
CREATE TABLE `#__mod_tip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `module_id` int(11) NOT NULL,
  `showtitle` tinyint(3) NOT NULL,
  `published` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `module_id` (`module_id`,`published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
