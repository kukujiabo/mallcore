CREATE TABLE `wechat_template_message` (
  `id` int auto_increment,
  `short_id` varchar(20) NOT NULL COMMENT '微信消息模版编号',
  `templade_id` varchar(20) NOT NULL COMMENT '微信消息模版id',
  `tmp_name` varchar(30) NOT NULL COMMENT '微信消息模版名称',
  `url` varchar(500) NOT NULL COMMENT '跳转网址',
  `pagepath` varchar(60) DEFAULT NULL COMMENT '跳转小程序页面',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `created_at` datetime NOT NULL COMMENT '创建时间', 
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='微信模版';
