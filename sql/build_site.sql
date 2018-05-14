create table `build_site` (
  `id` int auto_increment,
  `bname` varchar(100) comment '工地名称',
  `provider_id` int comment '供应商id',
  `manager_id` int comment '项目经理id',
  `b_address` varchar(200) comment '工地地址',
  `min_credit` int comment '使用最大额度',
  `max_credit` int comment '使用最小额度',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='工地表';


