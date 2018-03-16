create table `wechat_response_message_template` (
  `id` int auto_increment,
  `template_name` varchar(100) comment '模版名称',
  `keyword` varchar(100) comment '关键字',


) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='微信自定义回复消息表';
