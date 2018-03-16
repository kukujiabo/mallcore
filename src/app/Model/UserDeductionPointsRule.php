<?php
namespace App\Model;

/**
 * [模型层] 用户消费积分规则
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-18
 */
class UserDeductionPointsRule extends BaseModel {

  protected $_queryOptionRule = array(
    
    'created_at' => 'range',

    'updated_at' => 'range',

  );

}