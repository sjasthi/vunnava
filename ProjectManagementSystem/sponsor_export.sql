

DROP TABLE IF EXISTS `sponsor`;

CREATE TABLE `sponsor` (
  `sponsor_id` int(11) NOT NULL AUTO_INCREMENT,
  `sponsor_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sponsor_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sponsor_notes` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sponsor_id`),
  UNIQUE KEY `sponsor_id` (`sponsor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

