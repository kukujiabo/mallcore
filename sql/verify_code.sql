DROP TABLE IF EXISTS `mobile_verify_code`;
CREATE TABLE `mobile_verify_code` (
  `id` int AUTO_INCREMENT,
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `code` varchar(6) NOT NULL COMMENT '验证码',
  `status` int DEFAULT 0 COMMENT '状态:0,未使用，1，已使用',
  `send_at` int(10) NOT NULL COMMENT '发送时间',
  `expire_at` int(10) NOT NULL COMMENT '过期时间',
  `created_at` datetime COMMENT '发送时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='用户新增渠道表';
