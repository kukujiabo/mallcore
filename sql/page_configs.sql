CREATE TABLE `page_config` (
`id` int AUTO_INCREMENT,
`page` varchar(100) NOT NULL COMMENT '页面名称',
`page_code` varchar(100) NOT NULL COMMENT '页面编码',
`attr_name` varchar(100) NOT NULL COMMENT '属性名称',
`value` varchar(100)  COMMENT '属性值：当属性值长度较短时有效',
`value_text` text COMMENT '当属性值长度较大时有效',
`value_type` int COMMENT '属性值类型：1，字符串；2.大型文本； 3，图片；4，单项，5，多选',
`created_at` datetime COMMENT '创建时间',
`updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户消费记录表';
