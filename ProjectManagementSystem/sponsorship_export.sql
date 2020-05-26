
DROP TABLE IF EXISTS `sponsorship`;

CREATE TABLE `sponsorship` (
  `sponsorship_id` int(11) NOT NULL AUTO_INCREMENT,
  `sponsor_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `sponsorship_status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sponsorship_details` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sponsorship_notes` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sponsorship_image` text COLLATE utf8_unicode_ci NOT NULL,
  FOREIGN KEY (`sponsor_id`) references sponsor (`sponsor_id`),
  FOREIGN KEY (`project_id`) references project (`project_id`),
  PRIMARY KEY (`sponsorship_id`),
  UNIQUE KEY `sponsorship_id` (`sponsorship_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 



