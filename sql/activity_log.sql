CREATE TABLE `activity_member_logs` (
`id` int auto_increment,
`uid` int NOT NULL COMMENT '用户id',
`activity_code` varchar(50) NOT NULL COMMENT '活动代码',
`module` varchar(50) NOT NULL COMMENT '模块',
`object` varchar(50) NOT NULL COMMENT '对象id',
`created_at` varchar(50) NOT NULL COMMENT '参与事件',
primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='用户活动表';
