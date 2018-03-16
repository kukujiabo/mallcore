create table `wechat_response_message` (
  `id` int auto_increment,
  `from_user` varchar(100) comment '发送人',
  `to_user` varchar(100) comment '接收人',
  `msg_type` int(4) comment '消息类型：1.文本，2.图片',
  `msg_id` int(20) comment '消息id',
  `msg_content` varchar(500) comment '消息类型',
  `media_id` varchar(100) comment '通过素材管理中的接口上传多媒体文件，得到的id。',
  `create_time` int(10) comment '推送消息时间戳',
  `is_received` int(4) comment '1.上行消息，2.下行消息',
  `created_at` datetime,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='活动表';
