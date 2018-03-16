DROP TABLE IF EXISTS `share_records`;
CREATE TABLE `share_records` (
  `id` int(11) AUTO_INCREMENT,
  `uid` int(10) NOT NULL COMMENT '用户id',
  `openid` varchar(100) NOT NULL COMMENT '微信openid',
  `uni_key` varchar(100) NOT NULL COMMENT '用户uni_key',
  `phone` varchar(11) NOeT NULL COMMENT '用户手机号',
  `share_ticket` varchar(100) NOT NULL  COMMENT '分享组号',
  `share_id` int(11) COMMENT '分享内容id',
  `created_at` datetime,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='用户分享表';
