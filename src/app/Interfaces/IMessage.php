<?php
namespace App\Interfaces;

/**
 * 短信管理服务
 */
interface IMessage {

  /**
   * 发送短信
   * 
   * @param string $mode    短信模版代码
   * @param array $var      变量数组
   * @param string $content 短信内容
   *
   * @return boolean true/false
   */
  public function send($mode, $var = [], $content = '');

  /**
   * 查询短信发送记录列表
   *
   * @param array $condition              查询条件数组
   * @param int $condition['mobile']      根据发送手机号查询
   * @param int $condition['uid']         发送用户uid
   * @param string $condition['mode']     根据模版代码查询
   * @param string $condition['content']  根据短信内容模糊查询
   * @param int $offset                   偏移量
   * @param int $limit                    条数限制
   *
   * @return array $list
   */
  public function queryList($condition, $offset = 0, $limit = 20);


}
