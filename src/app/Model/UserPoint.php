<?php
namespace App\Model;

/**
 * [模型层] 用户获取的积分记录
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-21
 */
class UserPoint extends BaseModel {

  protected $_queryOptionRule = array(

    'created_time' => 'range',

    'updated_at' => 'range',

  );

}