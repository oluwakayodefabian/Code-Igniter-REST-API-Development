DATABASE NAME : ci_rest_api

CREATE TABLE `students` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(150) DEFAULT NULL,
 `email` varchar(255) DEFAULT NULL,
 `phone_no` int(11) DEFAULT NULL,
 `course` varchar(150) DEFAULT NULL,
 `status` int(11) DEFAULT 1,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4


CREATE TABLE `staffs` (
 `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
 `first_name` varchar(150) NOT NULL,
 `surname` varchar(150) NOT NULL,
 `phone_no` varchar(100) NOT NULL,
 `role` varchar(100) NOT NULL,
 `course_being_taught` varchar(100) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8