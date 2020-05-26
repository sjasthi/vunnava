
DROP TABLE IF EXISTS `manage`;

CREATE TABLE `manage` (
  `manage_id` int(11) NOT NULL AUTO_INCREMENT,
  `sponsor_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  FOREIGN KEY (`sponsor_id`) references sponsor (`sponsor_id`),
  FOREIGN KEY (`project_id`) references project (`project_id`),
  PRIMARY KEY (`manage_id`),
  UNIQUE KEY `manage_id` (`manage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 



