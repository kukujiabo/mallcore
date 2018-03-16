DROP TABLE IF EXISTS `consumption_records`;
CREATE TABLE `consumption_records` (
  `id` int(11) auto_increment,
  `sn` varchar(100) COMMENT '流水号',
  `seq` varchar(100) NOT NULL COMMENT '消费相关单号',
  `phone` varchar(100) NOT NULL COMMENT '用户手机号',
  `module` varchar(100) NOT NULL COMMENT '模块',
  `title` varchar(100) COMMENT '标题',
  `money` float COMMENT '消费金额',
  `remark` varchar(200)  COMMENT '备注',
  `status` int COMMENT '记录状态',
  `created_at` DATETIME COMMENT '创建时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户消费记录表';
