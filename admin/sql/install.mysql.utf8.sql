DROP TABLE IF EXISTS `#__mapfrance_maps`;
DROP TABLE IF EXISTS `#__mapfrance_areas`;
 
CREATE TABLE `#__mapfrance_maps` (
	`id`        INT(11)     NOT NULL AUTO_INCREMENT,
	`name`      VARCHAR(25) NOT NULL,
	`alias`		varchar(255) NOT NULL DEFAULT '',
	`published` tinyint(4) NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
 
INSERT INTO `#__mapfrance_maps` (`name`) VALUES
('France');

CREATE TABLE `#__mapfrance_areas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`map` int(10) UNSIGNED NOT NULL DEFAULT '0',
	`parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
	`lft` int(11) NOT NULL DEFAULT '0',
	`rgt` int(11) NOT NULL DEFAULT '0',
	`level` int(10) UNSIGNED NOT NULL DEFAULT '0',
	`title` varchar(255) NOT NULL,
	`alias` varchar(255) NOT NULL DEFAULT '',
	`access` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
	`path` varchar(255) NOT NULL DEFAULT '',
	`areacolor` varchar(6) NOT NULL DEFAULT '',
	`bordercolor` varchar(6) NOT NULL DEFAULT '',
	`borderwidth` varchar(1) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`),
	KEY `idx_map` (`map`),
	KEY `idx_left_right` (`lft`,`rgt`)
) DEFAULT CHARSET=utf8;

INSERT INTO `#__mapfrance_areas` SET 
	`id` = 1,
	`map` = 0,
	`parent_id` = 0,
	`lft` = 0,
	`rgt` = 1,
	`level` = 0,
	`title` = 'List_Item_Root',
	`path` = '';