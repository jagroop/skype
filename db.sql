-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `remind_at` timestamp NULL DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reminders` (`id`, `title`, `description`, `created_at`, `remind_at`, `active`) VALUES
(1, 'Hello',  'testing',  '2018-10-21 14:20:10',  '2018-10-21 14:29:00',  0);

DROP TABLE IF EXISTS `reminder_users`;
CREATE TABLE `reminder_users` (
  `user_id` int(10) unsigned NOT NULL,
  `reminder_id` int(10) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `reminder_id` (`reminder_id`),
  CONSTRAINT `reminder_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reminder_users_ibfk_2` FOREIGN KEY (`reminder_id`) REFERENCES `reminders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reminder_users` (`user_id`, `reminder_id`) VALUES
(1, 1);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `skype` varchar(150) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `name`, `skype`, `active`) VALUES
(1, 'ashish', 'skype', 1),
(2, 'kamlesh',  'skype',  1);

-- 2018-10-21 14:39:43