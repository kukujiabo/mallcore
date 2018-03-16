/**
 * 1.优惠券实例表
 */
DROP TABLE IF EXISTS `coupon`;
CREATE TABLE `ns_coupon` (
`coupon_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券id',
`coupon_type_id` int(11) NOT NULL COMMENT '优惠券类型id',
`shop_id` varchar(200) NOT NULL COMMENT '店铺Id',
`coupon_code` varchar(255) NOT NULL DEFAULT '' COMMENT '优惠券编码',
`uid` int(11) NOT NULL DEFAULT '0' COMMENT '领用人',
`use_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券使用订单id',
`create_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建订单id(优惠券只有是完成订单发放的优惠券时才有值)',
`money` decimal(10,2) NOT NULL COMMENT '面额',
`fetch_time` datetime DEFAULT NULL COMMENT '领取时间',
`use_time` datetime DEFAULT NULL COMMENT '使用时间',
`state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '优惠券状态 0未领用 1已领用（未使用） 2已使用 3已过期',
`start_time` datetime DEFAULT NULL COMMENT '有效期开始时间',
`end_time` datetime DEFAULT NULL COMMENT '有效期结束时间',
`get_type` int(11) NOT NULL DEFAULT '0' COMMENT '获取方式1订单2.首页领取',
`wx_bind` int(4) DEFAULT '0' COMMENT '是否绑定了微信卡券',
PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='优惠券表';

/**
 * 2.优惠券商品关联表
 */
DROP TABLE IF EXISTS `coupon_goods`;
CREATE TABLE `ns_coupon_goods` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`coupon_type_id` int(11) NOT NULL COMMENT '优惠券类型id',
`goods_id` int(11) NOT NULL COMMENT '商品id',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=606 COMMENT='优惠券使用商品表';

/**
 * 3.优惠券表
 */
DROP TABLE IF EXISTS `coupon_type`;
CREATE TABLE `ns_coupon_type` (
`coupon_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券类型Id',
`shop_id` varchar(200) NOT NULL DEFAULT '1' COMMENT '店铺ID，为0则表示所有门店',
`operator_id` int(11) DEFAULT NULL,
`deduction_type` int(4) DEFAULT '1' COMMENT '抵扣类型：1 折扣，2 现金',
`coupon_name` varchar(50) DEFAULT '' COMMENT '优惠券名称',
`money` decimal(10,2) NOT NULL COMMENT '发放面额',
`percentage` float NOT NULL DEFAULT '0' COMMENT '折扣',
`count` int(11) NOT NULL COMMENT '发放数量，0为无限制\n',
`max_fetch` int(11) NOT NULL DEFAULT '0' COMMENT '每人最大领取个数 0无限制',
`at_least` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '满多少元使用 0代表无限制',
`need_user_level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '领取人会员等级',
`range_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '使用范围0部分产品使用 1全场产品使用',
`start_time` datetime DEFAULT NULL COMMENT '有效日期开始时间',
`end_time` datetime DEFAULT NULL COMMENT '有效日期结束时间',
`need_bind` int(4) DEFAULT '0' COMMENT '是否需要绑定用户',
`status` int(4) DEFAULT '1' COMMENT '状态：1 可用，2 失效',
`create_time` datetime DEFAULT NULL COMMENT '创建时间',
`update_time` datetime DEFAULT NULL COMMENT '修改时间',
`is_show` int(11) NOT NULL DEFAULT '0' COMMENT '是否允许首页显示0不显示1显示',
PRIMARY KEY (`coupon_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1365 COMMENT='优惠券类型表';


/**
* 4.优惠券使用日志
*/
DROP TABLE IF EXISTS `coupon_use_log`;
CREATE TABLE `coupon_use_log` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
`uid` int(11) DEFAULT 0 COMMENT '用户id',
`coupon_id` int(11) NOT NULL COMMENT '优惠券id',
`money` float DEFAULT 0 COMMENT '优惠券面额',
`percentage` float DEFAULT 0 COMMENT '优惠券折扣',
`channel_type` int(11) NOT NULL COMMENT '渠道类型',
`channel` int(11) NOT NULL COMMENT '渠道id',
`order_id` int(11) NOT NULL COMMENT '订单id',
`created_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户积分实例表';

/**
* 5.优惠券发放日志
*/
DROP TABLE IF EXISTS `coupon_grant_log`;
CREATE TABLE `coupon_grant_log` (
`id` int(11) NOT NULL  AUTO_INCREMENT COMMENT '日志id',
`uid` int(11) NOT NULL COMMENT '用户id',
`operator_id` int(11) NOT NULL COMMENT '操作员id',
`coupon_id` int(11) NOT NULL COMMENT '优惠券id',
`channel_type` int(11) NOT NULL COMMENT '渠道类型',
`channel` int(11) NOT NULL COMMENT '渠道id',
`rule_id` int(11) COMMENT '优惠券发放规则',
`action` varchar(100) COMMENT '操作uri',
`created_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户积分实例表';

/**
* 6.优惠券发放规则
*/
DROP TABLE IF EXISTS `coupon_grant_rule`;
CREATE TABLE `coupon_grant_rule` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '规则id',
`name` varchar(100) NOT NULL COMMENT '规则名称',
`operator_id` int(11) NOT NULL COMMENT '操作员id',
`event_id` int(11) NOT NULL COMMENT '事件id',
`channel_type` int(11) NOT NULL COMMENT '渠道类型',
`channel` int(11) NOT NULL COMMENT '渠道id',
`coupon_id` int(11) NOT NULL COMMENT '优惠券id',
`grant_total_num` int(11) NOT NULL COMMENT '发放总量，为0时不限制',
`grant_individual_num` int(11) NOT NULL COMMENT '个人领取数量，为0不限制',
`remarks` varchar(200) DEFAULT NULL COMMENT '备注',
`start_date` int(10) DEFAULT 0 COMMENT '开始时间，为0立即开始',
`end_date` int(10) DEFAULT 0 COMMENT '结束时间，为0长期有效',
`status` int(4) DEFAULT 1 COMMENT '规则状态：1 有效，0 无效',
`created_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
`updated_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
`deleted_at` int DEFAULT 0,
primary key(`id`),
unique(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户积分实例表';

/**
* todo 优惠券面额随机生成
*/
