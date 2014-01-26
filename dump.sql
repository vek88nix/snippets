-- Adminer 3.7.0 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+07:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `snippets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `snippets` (`id`, `date`, `content`, `user_id`) VALUES
(1,	11111,	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. \nLorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. \nlolwut?\nIt has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. \n\nIt was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',	1);

-- 2014-01-26 16:39:46
