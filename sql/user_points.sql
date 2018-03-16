/**
 * 用户积分实例表
 */
drop table if exists `user_point`;
create table `user_point` (
`id` int(11) not null auto_increment comment '积分实例id',
`uid` int(11) not null comment '所属用户id',
`full_points` int default 0 comment '积分总额',
`rest_points` int default 0 comment '积分剩余额度',
`rule_name` varchar(100) default null comment '规则名称',
`object_id` varchar(100) default null comment '关联对象id',
`channel` int(11) not null comment '渠道id',
`channel_type` int default 1 comment '渠道类型：1 线下门店，2 线上商城',
`status` int default 1 comment '积分实例有效性：1 有效，0 失效',
`start_date` int comment '有效起始日期, 0为立即可用',
`expire_date`  int comment '有效截止日期, 0位长期有效',
`remarks` varchar(200) comment '备注',
`updated_at` timestamp default current_timestamp comment '更新时间', 
`created_at` timestamp default current_timestamp comment '创建时间',
`deleted_at` int default 0,
primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户积分实例表';

/**
 * 积分使用记录
 */
drop table if exists `user_points_log`;
create table `user_points_log` (
`id` int(11) not null auto_increment comment '记录id',
`uid` int(11) not null comment '用户id',
`serial` varchar(100) default null comment '流水号',
`rule_name` varchar(100) default null comment '规则名称',
`channel` int(11) not null comment '渠道id',
`channel_type` int default 1 comment '渠道类型：1 线下门店，2 线上商城',
`action` varchar(200) default null comment '请求操作',
`object_id` varchar(100) default null comment '对应订单id',
`points_amount` int default 0 comment '积分使用总额',
`ins_ids` varchar(200) default null comment '积分实例id',
`remarks` varchar(200) default null comment '备注',
`use_type` int default 1 comment '记录类型：1 消费，2 失效',
`created_time` timestamp default current_timestamp comment '创建时间',
`deleted_at` int default 0,
primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分使用记录';

/**
 * 积分获取规则配置
 */
drop table if exists `user_obtain_points_rule`;
create table `user_obtain_points_rule` (
`id` int(11) not null auto_increment comment '规则id',
`name` varchar(100) comment '规则名称',
`operator` int(11) not null comment '创建人',
`channel_type` int default 1 comment '渠道类型：1 线下门店，2 线上商城',
`channel` int(11) not null comment '渠道id',
`action` varchar(255) not null comment '操作', 
`points` int not null comment '积分额度',
`priority` int unique comment '优先级',
`status` int default 1 comment '状态：1 有效，0 无效',
`start_date` int default 0 comment '开始时间，为0时表示立即开始',
`expire_date` int default 0 comment '结束时间，为0时表示长时间有效',
`created_at` timestamp default current_timestamp comment '创建时间',
`updated_at` timestamp default current_timestamp comment '更新时间',
`deleted_at` int default 0,
primary key(`id`),
unique(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分获取规则配置表';

/**
 * 积分使用规则配置
 */
drop table if exists `user_deduction_points_rule`;
create table `user_deduction_points_rule` (
`id` int(11) not null auto_increment comment '规则id',
`name` varchar(100) comment '规则名称',
`operator` int(11) not null comment '创建人',
`channel_type` int default 0 comment '使用渠道类型：0 全渠道，1 门店，2 线上消费',
`channel` int default 0 comment '使用渠道id: 0 全部，门店id， 线上商城：9999',
`action` varchar(200) default null comment '请求操作',
`use_type` int default 1 comment '使用类型：1 抵扣，2 兑换; 普通消费订单使用抵扣规则，积分商城商品兑换使用兑换规则',
`deduction_type` int default 1 comment '抵扣类型：1 按比例抵扣，2 固定抵扣',
`limit` int default 0 comment '抵扣额度限制，当使用类型为1有效',
`deduction_percent` float default 0.0 comment '抵扣比例，积分与人民币（单位：元）的抵扣比例，抵扣类型为1时有效',
`fixed_amount` int default 0 comment '固定抵扣额度，当抵扣类型为2时有效',
`exchange_percent` float default 0 comment '积分商品价格兑换的比例，比如商品价格位100元，积分最高抵扣50%即最多抵扣50元，具体需要积分结合deduction_percent计算',
`priority` int unique comment '优先级，数字越小，优先级越高，0为最高优先级',
`status` int default 1 comment '规则状态：1 有效，0 无效',
`start_date` int comment '有效期起始日, 0为立即开始',
`expire_date` int comment '有效期截止日, 0为一直有效',
`created_at` timestamp default current_timestamp comment '创建时间',
`updated_at` timestamp default current_timestamp comment '修改时间',
`deleted_at` int default 0,
primary key(`id`),
unique(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分使用规则配置表';
