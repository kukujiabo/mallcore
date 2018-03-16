DROP TABLE IF EXISTS `member_sign`;
CREATE TABLE `member_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `sign_time` int(10) NOT NULL COMMENT '签到时间戳',
  `remark` varchar(100) COMMENT '签到备注',
  `ip_address` int(10) COMMENT '签到ip地址',
  `lat` float COMMENT '纬度',
  `lng` float COMMENT '经度',
  `relat_id` int(10) COMMENT '签到关联id',
  `relat_module` varchar(10) COMMENT '关联模块',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='用户签到表';
