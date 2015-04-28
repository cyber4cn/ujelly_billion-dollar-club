CREATE TABLE `wpjb_application` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`job_id` INT(11) UNSIGNED NOT NULL,
`user_id` INT(11) UNSIGNED,
`applied_at` DATETIME NOT NULL,
`title` VARCHAR(120) NOT NULL,
`resume` TEXT NOT NULL,
`email` VARCHAR(120) NOT NULL,
`employer_note` TEXT NOT NULL,
`admin_note` TEXT NOT NULL,
`is_rejected` TINYINT(1) UNSIGNED NOT NULL,
PRIMARY KEY(`id`),
KEY(`job_id`),
KEY(`user_id`)
) ENGINE=InnoDB CHARSET=utf8 ; --

ALTER TABLE `wpjb_application`
  ADD CONSTRAINT `wpjb_application_ibfk_1` FOREIGN KEY (`job_id`)
  REFERENCES `wpjb_job` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ; --

INSERT INTO `wpjb_mail` (`id`, `sent_to`, `sent_when`, `mail_title`, `mail_body`, `mail_from`) VALUES
(9, 3, 'Employer registers', 'Your login and password', 'Username: {$username}\r\nPassword: {$password}\r\n{$login_url}\r\n\r\n\r\n\r\n', 'example@example.com'),
(10, 3, 'Job seeker registers', 'Your login and password', 'Username: {$username}\r\nPassword: {$password}\r\n{$login_url}', 'example@example.com'); --


ALTER TABLE `wpjb_type` ADD `color` VARCHAR( 6 ) NOT NULL ; --