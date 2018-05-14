create table `manager` (
  `id` int auto_increment,
  `uid` int comment '用户id',
  `mname` varchar(100) comment '项目经理名称',
  `provider_id` int comment '供应商id',
  `phone` varchar(11) comment '手机号',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp comment '更新时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='项目经理表';
