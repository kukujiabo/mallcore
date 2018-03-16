CREATE TABLE `share_accept` (
  `id` int AUTO_INCREMENT,
  `fans_nickname` varchar(100) COMMENT '粉丝微信昵称',
  `fans_code` varchar(100) COMMENT '粉丝openid',
  `reference_name` varchar(100) COMMENT '推荐人昵称',
  `reference_code` varchar(100) COMMENT '推荐人openId',
  `module` int DEFAULT 1 COMMENT '推荐方式：1，小程序；2，带参二维码',
  `relat_id` int COMMENT '推荐内容id',
  `created_at` datetime,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='粉丝关注纪录';
