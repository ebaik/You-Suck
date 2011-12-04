DROP TABLE IF EXISTS `users`; 
CREATE TABLE `users` 
( 
`id` int(11) NOT NULL auto_increment, 
`fullname` varchar(32) NOT NULL,  
`username` varchar(32) NOT NULL UNIQUE,
`password` varchar(32) NOT NULL,
`email` varchar(32) NOT NULL UNIQUE,
`domain` varchar(32) default NULL, 
`zip` char(5) NOT NULL,
`city` varchar(32) NOT NULL,
`state` varchar(32) NOT NULL,
`country` varchar(32) NOT NULL,
`address` varchar(32) NOT NULL,
`phone` char(12) default NULL,
PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` 
(
`id` int(11) NOT NULL auto_increment,
`company_name` varchar(100) NOT NULL,
`phone_number` varchar(20) NOT NULL,
`industry`  varchar(100) NOT NULL,
`number_of_complaint` int default 0,
PRIMARY KEY(`id`)
);

DROP TABLE IF EXISTS 	`posts`;
CREATE TABLE `posts` 
(
`id` int(11) NOT NULL auto_increment,
`text` varchar(300) NOT NULL,
`user_id` int,
`company_id` int,
PRIMARY KEY(`id`)
);
