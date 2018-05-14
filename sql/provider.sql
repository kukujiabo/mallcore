create table `provider` (
  `id` int auto_increment,
  `pname` varchar(100) comment '供应商名称',
  `address` varchar(200) comment '供应商地址',
  `contact` varchar(50) comment '供应商联系人',
  `phone` varchar(50) comment '联系人电话',
  `provice` varchar(6) comment '所属省份',
  `city` varchar(6) comment '所属城市',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='供应商表';
