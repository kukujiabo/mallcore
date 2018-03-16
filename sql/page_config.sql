CREATE TABLE `wxpro_page` (
  `id` int AUTO_INCREMENT,
  `page_name` varchar(100) NOT NULL COMMENT '页面名称',
  `page_code` varchar(100) NOT NULL COMMENT '页面编码',
  `page_url` varchar(100) NOT NULL COMMENT '页面路径',
  `module` varchar(50) NOT NULL COMMENT '模块',
  `active` int DEFAULT 1 COMMENT '状态：1，可用；0，禁用',
  `created_at` datetime,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  primary key(`id`),
  unique(`page_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='微信小程序页面';
