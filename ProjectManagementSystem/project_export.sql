
DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proposed_start_date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proposed_end_date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actual_start_date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actual_end_date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proposed_by` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `frequency` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_notes` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_image` text COLLATE utf8_unicode_ci NOT NULL,
  `project_image_url` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 



