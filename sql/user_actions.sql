/**
 * 用户行为表
 */
 CREATE TABLE `user_action` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '行为id',
`name` varchar(100) NOT NULL COMMENT '行为名称',
`user_level` int(4) NOT NULL COMMENT '用户等级',
`uri` varchar(200) NOT NULL COMMENT '请求路径',
`active` int(4) DEFAULT 1 COMMENT '是否启用',
`created_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
primary key(`id`),
unique(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分使用规则配置表';
