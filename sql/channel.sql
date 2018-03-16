DROP TABLE IF EXISTS `member_channel`;
CREATE TABLE `member_channel` (
  `id` int(11) AUTO_INCREMENT,
  `user_key` varchar(100) NOT NULL COMMENT '用户标志',
  `channel` varchar(100) NOT NULL COMMENT '渠道标志',
  `share_key` varchar(100) NOT NULL COMMENT '分享对象标志',
  `module` int NOT NULL COMMENT '渠道类型',
  `remark` varchar(200) COMMENT '备注',
  `created_at` datetime COMMENT '创建时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='用户新增渠道表';

DROP TABLE IF EXISTs `share_record`;
CREATE TABLE `share_record` (
  `id` int(11) AUTO_INCREMENT,
  `user_key` varchar(100) NOT NULL COMMENT '用户标志',
  `target_key` varchar(100) COMMENT '目标标志',
  `module` varchar(100) COMMENT '分享类型',
  `share_ticket` varchar(200) COMMENT '',
  `remark` varchar(200) COMMENT '备注',
  `created_at` datetime COMMENT '创建时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='用户分享表';
