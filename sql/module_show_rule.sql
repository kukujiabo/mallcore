CREATE TABLE `sys_module_display_rule` (
  `id` int AUTO_INCREMENT,
  `module_id` int DEFAULT 0 COMMENT '模块id',
  `user_type` int DEFAULT 0 COMMENT '用户类型：0，通用；1，会员；2，员工；3，管理',
  `user_level` int DEFAULT 0 COMMENT '用户等级',
  `active` int DEFAULT 0 COMMENT '当前是否有效：0，有效； 1，无效',
  `show_date_start` date DEFAULT NULL COMMENT '指定显示开始日期',
  `show_date_end` date DEFAULT NULL COMMENT '指定显示结束日期',
  `show_time_start` int DEFAULT 0 COMMENT '指定一天中显示的时间',
  `show_time_end` int DEFAULT 0 COMMENT '指定一天中显示的开始时间',
  `priority` int DEFAULT 0 COMMENT '当同一个模块配置不同规则时，取优先级高的显示',
  `display_order` int DEFAULT 0 COMMENT '显示顺序',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `created_at` datetime,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='模块显示规则表';
