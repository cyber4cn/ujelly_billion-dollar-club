CREATE TABLE IF NOT EXISTS `wpjb_category`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`slug` VARCHAR(120) NOT NULL,
`title` VARCHAR(250) NOT NULL,
`description` TEXT NOT NULL,
PRIMARY KEY (`id`),
UNIQUE (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_type`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`slug` VARCHAR(120) NOT NULL,
`title` VARCHAR(250) NOT NULL,
`description` TEXT NOT NULL,
PRIMARY KEY (`id`),
UNIQUE (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_mail` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `sent_to` tinyint(1) unsigned NOT NULL COMMENT '1:admin; 2:job poster; 3: other',
  `sent_when` varchar(120) NOT NULL,
  `mail_title` varchar(120) NOT NULL,
  `mail_body` text NOT NULL,
  `mail_from` varchar(120) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ; --

CREATE TABLE IF NOT EXISTS `wpjb_listing`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(120) NOT NULL,
`price` FLOAT(10,2) NOT NULL,
`currency` TINYINT(3) UNSIGNED NOT NULL,
`visible` SMALLINT(5) UNSIGNED NOT NULL,
`is_featured` TINYINT(1) UNSIGNED NOT NULL,
`is_active` TINYINT(1) UNSIGNED NOT NULL,
PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_discount`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(120) NOT NULL,
`code` VARCHAR(20) NOT NULL,
`discount` DECIMAL(10,2) UNSIGNED NOT NULL,
`type` TINYINT(1) UNSIGNED NOT NULL COMMENT '1=%; 2=$',
`currency` TINYINT(3) UNSIGNED NOT NULL,
`expires_at` DATE NOT NULL,
`is_active` TINYINT(1) UNSIGNED NOT NULL,
PRIMARY KEY(`id`),
UNIQUE(`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_additional_field`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`type` TINYINT(1) UNSIGNED NOT NULL COMMENT '1:text; 3:ckbox; 4:select; 6:textarea',
`is_active` TINYINT(1) UNSIGNED NOT NULL,
`is_required` TINYINT(1) UNSIGNED NOT NULL,
`validator` VARCHAR(120) NOT NULL,
`label` VARCHAR(120) NOT NULL,
`hint` VARCHAR(250) NOT NULL,
`default_value` VARCHAR(120),
PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_field_option`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`field_id` INT(11) UNSIGNED NOT NULL,
`value` VARCHAR(120) NOT NULL,
PRIMARY KEY(`id`),
KEY(`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_field_value`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`field_id` INT(11) UNSIGNED NOT NULL,
`job_id` INT(11) UNSIGNED NOT NULL,
`value` TEXT NOT NULL,
PRIMARY KEY(`id`),
KEY(`field_id`),
KEY(`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_job`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`company_name` VARCHAR(120) NOT NULL,
`company_website` VARCHAR(240) NOT NULL,
`company_email` VARCHAR(240) NOT NULL,
`company_logo_ext` CHAR(5) NOT NULL DEFAULT '',

`job_type` INT(11) UNSIGNED NOT NULL,
`job_category` INT(11) UNSIGNED NOT NULL,
`job_source` TINYINT(3) UNSIGNED NOT NULL COMMENT '1:native; 2:admin; 3:external',

`job_country` SMALLINT(5) UNSIGNED NOT NULL,
`job_state` VARCHAR(40) NOT NULL DEFAULT '',
`job_zip_code` VARCHAR(20) NOT NULL DEFAULT '',
`job_location` VARCHAR(120) NOT NULL,
`job_limit_to_country` TINYINT(1) UNSIGNED NOT NULL,

`job_title` VARCHAR(120) NOT NULL,
`job_slug` VARCHAR(120) NOT NULL,
`job_visible` SMALLINT(5) UNSIGNED NOT NULL,
`job_created_at` DATETIME NOT NULL,
`job_modified_at` DATETIME NOT NULL,
`job_description` TEXT NOT NULL,
`is_approved` TINYINT(1) UNSIGNED NOT NULL,
`is_active` TINYINT(1) UNSIGNED NOT NULL,
`is_filled` TINYINT(1) UNSIGNED NOT NULL,
`is_featured` TINYINT(1) UNSIGNED NOT NULL,

`payment_sum` FLOAT(10,2) UNSIGNED NOT NULL,
`payment_paid` FLOAT(10,2) UNSIGNED NOT NULL,
`payment_currency` SMALLINT(5) UNSIGNED NOT NULL,
`payment_discount` FLOAT(10,2) UNSIGNED NOT NULL,

PRIMARY KEY(`id`),
KEY(`is_approved`, `is_active`, `job_created_at`, `job_visible`),
KEY(`job_category`),
KEY(`job_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_career_builder_log`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`did` VARCHAR(40) NOT NULL,
PRIMARY KEY(`id`),
UNIQUE(`did`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_alert` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `keyword` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `is_active` (`is_active`),
  KEY `is_active_2` (`is_active`,`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

CREATE TABLE IF NOT EXISTS `wpjb_payment` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `job_id` INT(11) unsigned NOT NULL,
  `engine` VARCHAR(40) NOT NULL,
  `external_id` VARCHAR(80) NOT NULL,
  `is_valid` TINYINT(1) NOT NULL,
  `message` VARCHAR(120) NOT NULL,
  `made_at` DATETIME NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE `job_id` (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; --

ALTER IGNORE TABLE `wpjb_field_value`
    ADD FOREIGN KEY ( `field_id` )
        REFERENCES `wpjb_additional_field` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE; --

ALTER IGNORE TABLE `wpjb_field_option` ADD FOREIGN KEY ( `field_id` )
    REFERENCES `wpjb_additional_field` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE ; --

ALTER IGNORE TABLE `wpjb_payment` ADD FOREIGN KEY ( `job_id` )
    REFERENCES `wpjb_job` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE ; --

INSERT IGNORE INTO  `wpjb_mail` (`id`, `sent_to`, `sent_when`, `mail_title`, `mail_body`, `mail_from`) VALUES
(1, 1, 'Sent to Admin when job is added to database (but not yet payed) ', 'New Job has been posted.', 'New job titled "{$position_title}" ({$id}) has been posted in {$category}.\r\n\r\nBuyer ({$company} {$email}) selected {$listing_type} which costs {$price}.\r\n\r\nAdded discount {$discount}.', ''),
(2, 1, 'Sent when PayPal confirms that payment was received ', 'Payment Received.', 'You have received payment {$paid} from {$company} ({$email}) for listing {$id},\r\n\r\nThis listing is currently {$active}.', ''),
(3, 2, 'Sent when client finishes posting FREE job ', 'Your job listing has been saved.', 'Hello,\r\nyour job listing titled "{$position_title}" has been saved.\r\n\r\nIt''s current status is {$active}.\r\n\r\nOnce activated by administrator your listing will be visible at:\r\n{$url}\r\n\r\nListing will be visible for {$visible} and will expire on {$expiration}\r\n\r\nBest Regards\r\nJob Board Support', ''),
(4, 2, 'Sent when client finishes posting PAID job ', 'Your job listing has been saved.', 'Hello,\r\nyour job listing titled "{$position_title}" has been saved.\r\n\r\nIt''s current status is {$active}.\r\n\r\nOnce activated by administrator your listing will be visible at:\r\n{$url}\r\n\r\nBest Regards\r\nJob Board Support', ''),
(5, 2, 'Sent to client to inform him that his listing will expire soon ', 'Listing will expire soon.', 'Hello,\r\nyour job listing titled "{$position_title}" has been saved.\r\n\r\nIt''s current status is {$active}.\r\n\r\nOnce activated by administrator your listing will be visible at:\r\n{$url}\r\n\r\nBest Regards\r\nJob Board Support', ''),
(6, 2, 'When applicant applies for job', 'Application for: {$position_title}', 'Application for position: {$position_title}\r\nApplicant E-mail: {$applicant_email}\r\n----------------------------------------\r\n{$applicant_cv}', ''),
(7, 3, 'Alert is sent to subscriber who created alert', 'Job Board Alert', 'Hello,\r\njob board alert was triggered because someone posted a job that matched your keyword: "{$alert_keyword}".\r\n\r\nYou can view the job at: {$url}\r\n\r\nIf you wish to no longer receive email alerts for this keyword click following link: {$alert_unsubscribe_url}\r\n\r\nBest Regards\r\nJob Board Team', ''); --

INSERT INTO `wpjb_category` (`id`, `slug`, `title`, `description`) VALUES
(1, 'default', 'Default', ''); --

INSERT INTO `wpjb_type` (`id`, `slug`, `title`, `description`) VALUES
(1, 'full-time', 'Full-Time', ''),
(2, 'part-time', 'Part-time', ''),
(3, 'contractor', 'Contractor', ''),
(4, 'intern', 'Intern', ''),
(5, 'seasonal-temp', 'Seasonal/Temp', ''); --

INSERT INTO `wpjb_listing` (`id`, `title`, `price`, `currency`, `visible`, `is_featured`, `is_active`) VALUES
(1, 'Premium', 20.00, 18, 30, 1, 1),
(2, 'Free', 0.00, 18, 30, 0, 1); --