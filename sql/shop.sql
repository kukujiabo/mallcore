/*
 *
 */
CREATE TABLE `shop` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '店铺索引id',
  `shop_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `shop_type` int(11) NOT NULL COMMENT '店铺类型等级',
  `uid` int(11) NOT NULL COMMENT '会员id',
  `shop_group_id` int(11) NOT NULL COMMENT '店铺分类',
  `shop_company_name` varchar(50) DEFAULT NULL COMMENT '店铺公司名称',
  `province_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '店铺所在省份ID',
  `city_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '店铺所在市ID',
  `shop_address` varchar(100) NOT NULL DEFAULT '' COMMENT '详细地区',
  `shop_zip` varchar(10) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `shop_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '店铺状态，0关闭，1开启，2审核中',
  `shop_close_info` varchar(255) DEFAULT NULL COMMENT '店铺关闭原因',
  `shop_sort` int(11) NOT NULL DEFAULT '0' COMMENT '店铺排序',
  `shop_create_time` datetime DEFAULT NULL COMMENT '店铺时间',
  `shop_end_time` datetime DEFAULT NULL COMMENT '店铺关闭时间',
  `shop_logo` varchar(255) DEFAULT NULL COMMENT '店铺logo',
  `shop_banner` varchar(255) DEFAULT NULL COMMENT '店铺横幅',
  `shop_avatar` varchar(150) DEFAULT NULL COMMENT '店铺头像',
  `shop_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺seo关键字',
  `shop_description` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺seo描述',
  `shop_qq` varchar(50) DEFAULT NULL COMMENT 'QQ',
  `shop_ww` varchar(50) DEFAULT NULL COMMENT '阿里旺旺',
  `shop_phone` varchar(20) DEFAULT NULL COMMENT '商家电话',
  `shop_domain` varchar(50) DEFAULT NULL COMMENT '店铺二级域名',
  `shop_domain_times` tinyint(1) unsigned DEFAULT '0' COMMENT '二级域名修改次数',
  `shop_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐，0为否，1为是，默认为0',
  `shop_credit` int(10) NOT NULL DEFAULT '0' COMMENT '店铺信用',
  `shop_desccredit` float NOT NULL DEFAULT '0' COMMENT '描述相符度分数',
  `shop_servicecredit` float NOT NULL DEFAULT '0' COMMENT '服务态度分数',
  `shop_deliverycredit` float NOT NULL DEFAULT '0' COMMENT '发货速度分数',
  `shop_collect` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺收藏数量',
  `shop_stamp` varchar(200) DEFAULT NULL COMMENT '店铺印章',
  `shop_printdesc` varchar(500) DEFAULT NULL COMMENT '打印订单页面下方说明文字',
  `shop_sales` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺销售额（不计算退款）',
  `shop_account` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺账户余额',
  `shop_cash` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺可提现金额',
  `shop_workingtime` varchar(100) DEFAULT NULL COMMENT '工作时间',
  `live_store_name` varchar(255) DEFAULT NULL COMMENT '商铺名称',
  `live_store_address` varchar(255) DEFAULT NULL COMMENT '商家地址',
  `live_store_tel` varchar(255) DEFAULT NULL COMMENT '商铺电话',
  `live_store_bus` varchar(255) DEFAULT NULL COMMENT '公交线路',
  `shop_vrcode_prefix` char(3) DEFAULT NULL COMMENT '商家兑换码前缀',
  `store_qtian` tinyint(1) DEFAULT '0' COMMENT '7天退换',
  `shop_zhping` tinyint(1) DEFAULT '0' COMMENT '正品保障',
  `shop_erxiaoshi` tinyint(1) DEFAULT '0' COMMENT '两小时发货',
  `shop_tuihuo` tinyint(1) DEFAULT '0' COMMENT '退货承诺',
  `shop_shiyong` tinyint(1) DEFAULT '0' COMMENT '试用中心',
  `shop_shiti` tinyint(1) DEFAULT '0' COMMENT '实体验证',
  `shop_xiaoxie` tinyint(1) DEFAULT '0' COMMENT '消协保证',
  `shop_huodaofk` tinyint(1) DEFAULT '0' COMMENT '货到付款',
  `shop_free_time` varchar(10) DEFAULT NULL COMMENT '商家配送时间',
  `shop_region` varchar(50) DEFAULT NULL COMMENT '店铺默认配送区域',
  `recommend_uid` int(11) NOT NULL DEFAULT '0' COMMENT '推荐招商员用户id',
  `shop_qrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺公众号',
  `shop_platform_commission_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台抽取佣金比率',
  `is_self_support` int(4) DEFAULT 1 COMMENT '是否自营',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='店铺数据表';

CREATE TABLE `shop_account` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_profit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺总营业额',
  `shop_total_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺入账总额',
  `shop_proceeds` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺收益总额',
  `shop_platform_commission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台抽取店铺利润总额',
  `shop_withdraw` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺提现总额',
  `shop_point` int(11) NOT NULL DEFAULT '0' COMMENT '店铺发放的积分总额',
  `shop_point_use` int(11) NOT NULL DEFAULT '0' COMMENT '会员已使用多少积分',
  `active` int(4) NOT NULL DEFAULT 1 COMMNENT '账户是否启用',
  `created_at` int(10) NOT NULL COMMENT '创建时间', 
  `updated_at` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=2340 COMMENT='店铺账户表';

CREATE TABLE `shop_account_money_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) NOT NULL COMMENT '流水号',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID  0标识平台',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '相关金额',
  `account_type` int(11) NOT NULL DEFAULT '1' COMMENT '记录类型',
  `type_alis_id` int(11) NOT NULL COMMENT '相关ID号',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简单描述',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='店铺入账总额的记录表';

CREATE TABLE `shop_account_proceeds_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) NOT NULL COMMENT '流水号',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID  0标识平台',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '相关金额',
  `account_type` int(11) NOT NULL DEFAULT '1' COMMENT '记录类型',
  `type_alis_id` int(11) NOT NULL COMMENT '相关ID号',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简单描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='店铺收益总额的记录表';

CREATE TABLE `shop_account_profit_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) NOT NULL COMMENT '流水号',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID  0标识平台',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '相关金额',
  `account_type` int(11) NOT NULL DEFAULT '1' COMMENT '记录类型',
  `type_alis_id` int(11) NOT NULL COMMENT '相关ID号',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简单描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192 COMMENT='店铺营业额的记录表';

CREATE TABLE `shop_account_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) NOT NULL DEFAULT '' COMMENT '流水号',
  `shop_id` int(11) NOT NULL COMMENT '店铺ID  0标识平台',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '相关金额',
  `account_type` int(11) NOT NULL DEFAULT '1' COMMENT '发生方式',
  `type_alis_id` int(11) NOT NULL COMMENT '相关ID号',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺的可用余额',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '简单描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461 COMMENT='店铺账户记录管理';


CREATE TABLE `shop_order_relat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表索引',
  `shop_id` int(11) NOT NULL COMMENT '店铺id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `module` int(4) NOT NULL DEFAULT 1 COMMENT '订单类型：1.电商订单，2.外卖订单，3.点餐订单，4.服务订单',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注信息',
  `ext_1` varchar(200) DEFAULT NULL COMMENT '备用字段',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 COMMENT='店铺订单关联表';