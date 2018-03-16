DROP TABLE IF EXISTS `member_recharge_rules`;
CREATE TABLE `member_recharge_rules` (
  `id` int(11) AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '充值规则名称',
  `money` decimal(10, 2) DEFAULT 0.00 COMMENT '指定充值金额', 
  `min_money` decimal(10, 2) DEFAULT 0.00 COMMENT '最低充值金额', 
  `reward_money` decimal(10, 2) DEFAULT 0.00 COMMENT '奖励金',
  `reward_percentage` float DEFAULT 0.0 COMMENT '奖励百分比',
  `reward_type` int DEFAULT 0 COMMENT '奖励类型：0，无奖励；1，奖励金；2，百分比',
  `operator_key` varchar(100) NOT NULL COMMENT '操作员编号',
  `start_date` int(10) COMMENT '规则有效期开始时间戳',
  `end_date` int(10) COMMENT '规则有效期结束时间戳',
  `active` int DEFAULT 1 COMMENT '规则状态：0，有效；1，失效',
  `priority` int DEFAULT 0 COMMENT '优先级',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='用户充值规则表';
