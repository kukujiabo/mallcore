CREATE TABLE `member_message` (
  `id` int auto_increment,
  `uid` varchar(11) DEFAULT NULL COMMENT '用户id',
  `msgid` varchar(30) NOT NULL COMMENT '消息编号',
  `module` varchar(60) NOT NULL COMMENT '所属模块',
  `url` varchar(20) DEFAULT NULL COMMENT '跳转链接',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `content` varchar(100) DEFAULT NULL COMMENT '内容',
  `time` datetime DEFAULT NULL COMMENT '消息时间',
  `icon` varchar(100) DEFAULT NULL COMMENT '小程序页面url',
  `ext` varchar(200) DEFAULT NULL COMMENT '内容',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='会员消息';
