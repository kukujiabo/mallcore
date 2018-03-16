CREATE TABLE `member_card` (
  `id` int AUTO_INCREMENT,
  `card_name` varchar(100) NOT NULL COMMENT '卡片名称',
  `card_code` varchar(100) NOT NULL COMMENT '卡片编码',
  `card_seq` varchar(10) NOT NULL COMMENT '卡号开头数字',
  `img_url` varchar(200) NOT NULL COMMENT '卡片地址',
  `card_type` int DEFAULT 1 COMMENT '卡片类型：1，通用卡片，2，指定卡片',
  `created_at` datetime,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  primary key(`id`),
  unique(`card_name`),
  unique(`card_seq`),
  unique(`card_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='会员卡';
