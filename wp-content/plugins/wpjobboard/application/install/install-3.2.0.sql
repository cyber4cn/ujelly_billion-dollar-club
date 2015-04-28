CREATE TABLE `wpjb_job_search` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`job_id` INT(11) UNSIGNED NOT NULL,
`title` VARCHAR(120) NOT NULL,
`description` TEXT NOT NULL,
`company` VARCHAR(120) NOT NULL,
`location` VARCHAR(200) NOT NULL,
PRIMARY KEY(`id`),
UNIQUE(`job_id`),
FULLTEXT KEY `search` (`title`, `description`, `location`, `company`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8; --

CREATE TABLE `wpjb_employer` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id` INT(11) UNSIGNED NOT NULL COMMENT 'foreign key wp_users.id',
`company_name` VARCHAR(120) NOT NULL DEFAULT "",
`company_website` VARCHAR(120) NOT NULL DEFAULT "",
`company_info` TEXT NOT NULL DEFAULT "",
`company_logo_ext` CHAR(5) NOT NULL DEFAULT "",
`company_location` VARCHAR(250) NOT NULL DEFAULT "",
`jobs_posted` INT(11) UNSIGNED NOT NULL DEFAULT 0,
`is_public` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
`is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0: inactive; 1: active; 2: requesting; 3: decline; 4:full-access',
`access_until` DATE NOT NULL DEFAULT '0000-00-00',
PRIMARY KEY(`id`),
KEY(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8; --

ALTER TABLE `wpjb_job`
    ADD `stat_views` INT(11) UNSIGNED NOT NULL DEFAULT '0',
    ADD `stat_unique` INT(11) UNSIGNED NOT NULL DEFAULT '0',
    ADD `stat_apply` INT(11) UNSIGNED NOT NULL DEFAULT '0',
    ADD `employer_id` INT(11) UNSIGNED NULL DEFAULT NULL; --

ALTER TABLE `wpjb_job` ADD INDEX ( `employer_id` ); --
UPDATE `wpjb_job` SET `employer_id` = NULL; --

ALTER TABLE `wpjb_job` ADD FOREIGN KEY (`employer_id`)
    REFERENCES `wpjb_employer`(`id`)
    ON DELETE SET NULL ON UPDATE NO ACTION ; --



CREATE TABLE `wpjb_resume`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id` INT(11) UNSIGNED NOT NULL,
`category_id` INT(11) UNSIGNED NOT NULL,
`title` VARCHAR(120) NOT NULL DEFAULT'' COMMENT "Professional Headline",
`firstname` VARCHAR(80) NOT NULL DEFAULT '',
`lastname` VARCHAR(80) NOT NULL DEFAULT '',
`headline` TEXT NOT NULL DEFAULT '',
`experience` TEXT NOT NULL DEFAULT '',
`education` TEXT NOT NULL DEFAULT '',
`country` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
`address` VARCHAR(250) NOT NULL DEFAULT '',
`email` VARCHAR(120) NOT NULL DEFAULT '',
`phone` VARCHAR(40) NOT NULL DEFAULT '',
`website` VARCHAR(120) NOT NULL DEFAULT '',
`is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
`is_approved` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
`degree` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
`years_experience` TINYINT(2) UNSIGNED NOT NULL DEFAULT 0,
`created_at` DATETIME NOT NULL,
`updated_at` DATETIME NOT NULL,
`image_ext` VARCHAR(5) NOT NULL DEFAULT '',
PRIMARY KEY(`id`),
KEY(`user_id`),
FULLTEXT KEY `search` (`title`, `headline`),
FULLTEXT KEY `search_extended` (`title`, `headline`, `experience`, `education`),
FULLTEXT KEY `address` (`address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8; --

ALTER TABLE `wpjb_payment` DROP FOREIGN KEY `wpjb_payment_ibfk_1` ; --
ALTER TABLE `wpjb_payment` CHANGE `job_id` `object_id` INT( 11 ) UNSIGNED NOT NULL ; --
ALTER TABLE `wpjb_payment` 
    ADD `user_id` INT(11) UNSIGNED DEFAULT NULL COMMENT 'foreign key: wp_users.ID' AFTER `id`,
    ADD `object_type` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1:job; 2:resumes' AFTER `object_id`,
    ADD `payment_sum` float(10,2) unsigned NOT NULL,
    ADD `payment_paid` float(10,2) unsigned NOT NULL,
    ADD `payment_currency` smallint(5) unsigned NOT NULL; --

ALTER TABLE `wpjb_payment` ADD INDEX ( `object_id` ) ; --
ALTER TABLE `wpjb_payment` DROP INDEX `job_id` ; --

CREATE TABLE `wpjb_resumes_access`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`employer_id` INT(11) UNSIGNED NOT NULL,
`created_at` DATETIME NOT NULL,
`extend` SMALLINT(5) NOT NULL,
PRIMARY KEY(`id`),
KEY(`employer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

ALTER TABLE `wpjb_resumes_access` ADD FOREIGN KEY (`employer_id`) REFERENCES `wpjb_employer`(`id`) ON DELETE CASCADE ; --
