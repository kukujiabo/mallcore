CREATE TABLE `mini_program` (
  `id` int AUTO_INCREMENT,
  `mini_name` varchar(100) NOT NULL,
  `mini_code` varchar(100) NOT NULL,
  `mini_appid` varchar(100) NOT NULL,
  `mini_secret` varchar(100) NOT NULL,
  `icon` varchar(200),
  `remark` varchar(400),
  `created_at` datetime,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='活动表';
