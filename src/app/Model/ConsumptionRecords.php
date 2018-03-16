<?php
namespace App\Model;

/**
 * [模型层] 用户消费记录
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-20
 *
 */
class ConsumptionRecords extends BaseModel {

  protected $_queryOptionRule = array(
    
    'id' => 'in',

    'uid' => 'in',

    'created_at' => 'range',

  );

}
