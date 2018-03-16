DROP TABLE IF EXISTS `order_table`;
CREATE TABLE `order_table` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `code` varchar(100) NOT NULL COMMENT '桌子编码',
  `owner_id` int(11) DEFAULT 0 COMMENT '所有者id',
  `capacity` int(4) default 1 COMMENT '可供就餐人数',
  `location` varchar(100) DEFAULT NULL COMMENT '位置标志',
  `remarks` varchar(200) DEFAULT NULL COMMENT '餐桌备注',
  `orders` int(5) DEFAULT 0 COMMENT '自定义排序，数字越大越靠前',
  `active` int(4) DEFAULT 1 COMMENT '餐桌可用标志',
  `created_at` int(10) COMMENT '创建时间',
  `deleted_at` int(10) COMMENT '删除时间',
  PRIMARY KEY(`id`),
  UNIQUE KEY(`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='餐桌表';

DROP TABLE IF EXISTS `order_table_log`;
CREATE TABLE `order_table_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `user_id` varchar(100) NOT NULL COMMENT '用户id',
  `platform` int(4) NOT NULL COMMENT '顾客使用平台：1.支付宝，2.微信，3.自营app',
  `order_code` varchar(100) DEFAULT NULL COMMENT '下单订单号',
  `created_at` int(10) COMMENT '创建时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='餐桌扫码记录表';

DROP TABLE IF EXISTS `table_order`;
CREATE TABLE `table_order` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `order_id` varchar(100) NOT NULL COMMENT '订单编号',
  `table_code` varchar(100) NOT NULL COMMENT '餐桌编码',
  `user_id` varchar(100) NOT NULL COMMENT '用户标识',
  `platform` varchar(100) NOT NULL COMMENT '下单平台：1.支付宝，2.微信，3.自营app',
  `status` int(4) DEFAULT 0 COMMENT '订单状态：0.未支付，1.已支付，2.已完成，-1.已取消, -2.已退款',
  `remark` varchar(200) DEFAULT NULL COMMENT '订单备注',
  `create_at` int(10) COMMENT '创建时间',
  `updated_at` int(10) COMMENT '修改时间',
  PRIMARY KEY(`id`),
  UNIQUE KEY(`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='餐桌点单订单';

DROP TABLE IF EXISTS `table_order_commodity`;
CREATE TABLE `table_order_commodity` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `order_id` varchar(100) NOT NULL COMMENT '订单编号',
  `table_code` varchar(100) NOT NULL COMMENT '餐桌编码',
  `commodity_id` int(10) NOT NULL COMMENT '商品id',
  `sku_id` int(10) DEFAULT 0 COMMENT '商品SKU id',
  `order_number` int(4) DEFAULT 1 COMMENT '订购数量',
  `single_price` float COMMENT '单价',
  `total_price` float COMMENT '总价',
  `remarks` varchar(200) COMMENT '说明',
  `status` int(4) DEFAULT 0 COMMENT '商品状态：0.已下单，1.已完成，-1.已退订',
  `created_at` int(10) COMMENT '创建时间',
  `updated_at` int(10) COMMENT '更新时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='餐桌点单订单商品';

DROP TABLE IF EXISTS `table_order_discount`;
CREATE TABLE `table_order_discount` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `order_id` varchar(100) NOT NULL COMMENT '订单编号',
  `table_code` varchar(100) NOT NULL COMMENT '餐桌编号',
  `discount_type` int(4) NOT NULL COMMENT '优惠类型：1.活动，2.卡券，3.积分，4.会员折扣',
  `discount_id` int(4) NOT NULL COMMENT '优惠券id',
  `discount_instance_id` int(4) DEFAULT 0 COMMENT '优惠实例id',
  `relat_object_id` int(11) DEFAULT 0 COMMENT '关联实例id',
  `status` int(4) DEFAULT 0 COMMENT '使用状态',
  `created_at` int(10) COMMENT '创建时间',
  `updated_at` int(10) COMMENT '更新时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单使用优惠记录';

DROP TABLE IF EXISTS `table_order_log`;
CREATE TABLE `table_order_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `order_id` varchar(100) NOT NULL COMMENT '订单编号',
  `operator_type` int(4) NOT NULL COMMENT '操作人类型',
  `operator` varchar(100) NOT NULL COMMENT '操作人id',
  `operation` int(4) NOT NULL COMMENT '操作类型',
  `description` varchar(200) COMMENT '操作描述',
  `created_at` int(10) COMMENT '创建时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单操作记录';
