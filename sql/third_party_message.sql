DROP TABLE IF EXISTS `third_party_message_log`;
CREATE TABLE `third_party_messageg_log` (
  `id` int(11) AUTO_INCREMENT,
  `module` varchar(45) COMMENT '所属模块',
  `action` varchar(45) COMMENT '操作类型',
  `content` text COMMENT '内容',
  `remark` varchar(200) COMMENT '备注',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='第三方消息记录表';

