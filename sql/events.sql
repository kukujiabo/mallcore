DROP TABLE IF EXISTS `event_action_relat`;
CREATE TABLE `event_action_relat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `event_id` int(11) NOT NULL COMMENT '事件id',
  `action_id` int(11) NOT NULL COMMENT '操作id',
  `module` varchar(100) NOT NULL DEFAULT 'all' COMMENT '模块',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `active` int(4) DEFAULT 1 COMMENT '是否启用',
  `operator_id` int(11) NOT NULL COMMENT '操作员id',
  `created_at` timestamp NOT NULL COMMENT '新增时间',
  `updated_at` timestamp NOT NULL COMMENT '更新时间',
  `deleted_at` timestamp NOT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='事件操作关联表';

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `event_code` varchar(100) NOT NULL COMMENT '事件编码',
  `event_name` varchar(100) NOT NULL COMMENT '事件名称',
  `route` varchar(200) NOT NULL COMMENT '请求路径',
  `module` varchar(100) NOT NULL COMMENT '所属模块',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  `operator_id` int(11) NOT NULL COMMENT '操作员id',
  `created_at` timestamp NOT NULL COMMENT '新增时间',
  `updated_at` timestamp NOT NULL COMMENT '更新时间',
  `deleted_at` timestamp NOT NULL COMMENT '删除时间',
  PRIMARY KEY(`id`),
  UNIQUE KEY(`event_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='事件表';

DROP TABLE IF EXISTS `action`;
CREATE TABLE `action` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `action_code` varchar(100) NOT NULL COMMENT '操作编号',
  `action_name` varchar(100) NOT NULL COMMENT '操作名', 
  `service` varchar(100) NOT NULL COMMENT '服务名称',
  `method` varchar(100) NOT NULL COMMENT '方法',
  `default_data` varchar(200) DEFAULT NULL COMMENT '默认参数（json格式）',
  `operator_id` int(11) NOT NULL COMMENT '操作员id',
  `created_at` timestamp NOT NULL COMMENT '新增时间',
  `updated_at` timestamp NOT NULL COMMENT '更新时间',
  `deleted_at` timestamp NOT NULL COMMENT '删除时间',
  PRIMARY KEY(`id`),
  UNIQUE KEY(`action_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='操作表';
