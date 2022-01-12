<?php
include('default.php');
$sql = "INSERT INTO `users`(`user_email`, `user_pass`) VALUES (
    '".$_GET['email']."',
    '".password_hash($_GET['pw'],PASSWORD_DEFAULT)."'
    )";
    if(mysqli_query($conn,$sql)){
        $last_id = mysqli_insert_id($conn);
       $sql = "INSERT INTO `instances`(`instance_name`, `instance_expired-in`, `user_id`, `offer_id`, `instance_subdomain`) VALUES (
            '".substr(uniqid(),7)."',
            '".$_GET['expired']."',
            '".$last_id."',
            '".$_GET['offer']."',
            '".$_GET['sdomain']."'
            )";
            if(mysqli_query($conn,$sql)){


$conn_create = new mysqli("localhost","phpmyadmin","Damian#3");
$sql =" CREATE DATABASE IF NOT EXISTS `_in.".$_GET['sdomain']."` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; ";
if(mysqli_query($conn_create,$sql)){
$sql .=" CREATE TABLE `absent` (
  `abs_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `abs_status` int(11) DEFAULT NULL,
  `abs_mod` int(11) DEFAULT NULL,
  `abs_from` date NOT NULL,
  `abs_to` date NOT NULL,
  `abs_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `accepted_days` (
  `accept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accept_date` date NOT NULL,
  `accept_hours` varchar(5) NOT NULL,
  `accept_mod` int(11) NOT NULL,
  `accept_occured` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accept_calculated-from` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `accept_comment` text NOT NULL,
  `accept_type` int(1) NOT NULL,
  `addtime_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `accepted_months` (
  `accept_m_id` int(11) NOT NULL,
  `accept_m_user_id` int(11) NOT NULL,
  `accept_month` date NOT NULL,
  `accept_m_hours` time NOT NULL,
  `accept_m_calculated_from` text NOT NULL,
  `accept_m_code` text NOT NULL,
  `accept_m_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `add_time` (
  `addtime_id` int(11) NOT NULL,
  `accept_id` int(11) NOT NULL,
  `addtime_time` text NOT NULL,
  `addtime_accept_mod` int(11) NOT NULL,
  `znak` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `con_accepted_ip` (
  `con_accept_ip_id` int(11) NOT NULL,
  `con_accept_ip_ip` text NOT NULL,
  `accepted_ip_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `con_system_nav_custom` (
  `nav_id` int(11) NOT NULL,
  `nav_subject` text NOT NULL,
  `nav_sort` int(11) NOT NULL,
  `nav_href` text NOT NULL,
  `nav_icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `con_variables` (
  `con_id` int(11) NOT NULL,
  `con_name` text NOT NULL,
  `con_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `log_value` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_type` int(11) NOT NULL,
  `log_occured` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `records_new` (
  `record_id` int(11) NOT NULL,
  `record_event` varchar(30) NOT NULL,
  `record_date` date NOT NULL,
  `record_in_time` time NOT NULL,
  `record_out_time` time DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `record_in_create` int(11) NOT NULL,
  `record_comment` text NOT NULL,
  `record_out_create` int(11) DEFAULT NULL,
  `record_in_remote` int(11) DEFAULT NULL,
  `record_out_remote` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_cookie` varchar(100) NOT NULL,
  `user_privilage` int(1) NOT NULL DEFAULT '0',
  `user_status` int(1) NOT NULL DEFAULT '0',
  `user_name` varchar(50) NOT NULL,
  `user_last-device` text NOT NULL,
  `user_last-edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_remote_work` int(11) NOT NULL DEFAULT '0',
  `user_abs_prv` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .=" CREATE TABLE `user_session` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(100) NOT NULL,
  `session_active` tinyint(1) NOT NULL,
  `session_expired_in` datetime NOT NULL,
  `user_id_hash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";

$sql .= "ALTER  TABLE `absent`
  ADD PRIMARY KEY (`abs_id`); ";

$sql .= "ALTER  TABLE `accepted_days`
  ADD PRIMARY KEY (`accept_id`),
  ADD KEY `accept_id` (`accept_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `addtime_id` (`addtime_id`),
  ADD KEY `accept_mod` (`accept_mod`); ";

$sql .= "ALTER  TABLE `accepted_months`
  ADD PRIMARY KEY (`accept_m_id`),
  ADD KEY `accept_m_user_id` (`accept_m_user_id`); ";

$sql .= "ALTER  TABLE `add_time`
  ADD PRIMARY KEY (`addtime_id`),
  ADD KEY `addtime_id` (`addtime_id`),
  ADD KEY `accept_mod` (`addtime_accept_mod`),
  ADD KEY `accept_id` (`accept_id`); ";

$sql .= "ALTER  TABLE `con_accepted_ip`
  ADD PRIMARY KEY (`con_accept_ip_id`),
  ADD KEY `con_accept_ip_id` (`con_accept_ip_id`); ";

$sql .= "ALTER  TABLE `con_system_nav`
  ADD PRIMARY KEY (`nav_id`); ";

$sql .= "ALTER  TABLE `con_system_nav_custom`
  ADD PRIMARY KEY (`nav_id`); ";

$sql .= "ALTER  TABLE `con_system_nav_group`
  ADD PRIMARY KEY (`group_id`); ";

$sql .= "ALTER  TABLE `con_variables`
  ADD PRIMARY KEY (`con_id`); ";

$sql .= "ALTER  TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`); ";

$sql .= "ALTER  TABLE `records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `user_id` (`user_id`); ";

$sql .= "ALTER  TABLE `records_new`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `record_in_create` (`record_in_create`),
  ADD KEY `record_out_create` (`record_out_create`); ";

$sql .= "ALTER  TABLE `users`
  ADD PRIMARY KEY (`user_id`); ";

$sql .= "ALTER  TABLE `user_session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`); ";

$sql .= "ALTER  TABLE `absent`
  MODIFY `abs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `accepted_days`
  MODIFY `accept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `accepted_months`
  MODIFY `accept_m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `add_time`
  MODIFY `addtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `con_accepted_ip`
  MODIFY `con_accept_ip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `con_system_nav_custom`
  MODIFY `nav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `con_variables`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `records_new`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `user_session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; ";

$sql .= "ALTER  TABLE `accepted_days`
  ADD CONSTRAINT `accepted_days_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `accepted_days_ibfk_2` FOREIGN KEY (`accept_mod`) REFERENCES `users` (`user_id`); ";

$sql .= "ALTER  TABLE `accepted_months`
  ADD CONSTRAINT `accepted_months_ibfk_1` FOREIGN KEY (`accept_m_user_id`) REFERENCES `users` (`user_id`); ";

$sql .= "ALTER  TABLE `add_time`
  ADD CONSTRAINT `add_time_ibfk_2` FOREIGN KEY (`addtime_accept_mod`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `add_time_ibfk_3` FOREIGN KEY (`accept_id`) REFERENCES `accepted_days` (`accept_id`); ";

$sql .= "ALTER  TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`); ";

$sql .= "ALTER  TABLE `records_new`
  ADD CONSTRAINT `records_new_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `records_new_ibfk_2` FOREIGN KEY (`record_in_create`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `records_new_ibfk_3` FOREIGN KEY (`record_out_create`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE; ";

$sql .= "ALTER  TABLE `user_session`
  ADD CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`); ";
$conn_new = new mysqli("localhost","phpmyadmin","Damian#3","_in.".$_GET['sdomain']);
echo '{"ans":"1"}';
// if(mysqli_multi_query($conn_new,$sql)){
//     mysqli_close($link);
// }
            }
            } 
    }
?> 