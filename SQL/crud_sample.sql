
CREATE DATABASE IF NOT EXISTS `crud_sample_laravel` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `crud_sample_laravel`;


CREATE TABLE IF NOT EXISTS `crud_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` text,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `slug_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `slug_key` (`slug_key`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (1, 'test title a', 'test description a', '2017-08-10 19:05:21', '2016-08-10 19:05:22', 'test-slug-a');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (2, 'test title b', 'test description b', '2016-08-10 19:06:21', '2015-08-10 20:06:22', 'test-slug-b');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (3, 'test title c', 'test description c', '2016-08-10 19:06:21', '2015-08-10 21:07:22', 'test-slug-c');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (4, 'test title d', 'test description d', '2015-08-10 19:06:21', '2015-08-10 22:08:22', 'test-slug-d');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (5, 'test title e', 'test description e', '2016-08-10 19:06:21', '2014-08-10 23:09:22', 'test-slug-e');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (6, 'test title f', 'test description f', '2017-08-10 19:06:21', '2016-08-10 00:10:22', 'test-slug-f');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (7, 'test title g', 'test description g', '2016-08-10 19:06:21', '2016-08-10 01:11:22', 'test-slug-g');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (8, 'test title h', 'test description h', '2016-08-10 19:06:21', '2016-08-10 02:12:22', 'test-slug-h');
INSERT INTO `crud_content` (`id`, `title`, `description`, `created_on`, `modified_on`, `slug_key`) VALUES (9, 'test title i', 'test description i', '2013-08-10 19:06:21', '2016-08-10 03:13:22', 'test-slug-i');
