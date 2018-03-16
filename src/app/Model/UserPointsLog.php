<?php
namespace App\Model;

/**
 * [模型层] 用户消费积分记录
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-21
 */
class UserPointsLog extends BaseModel {

  protected $_queryOptionRule = array(

    'created_time' => 'range',

  );

}