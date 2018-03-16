<?php
namespace App\Model;

/**
 * [模型层] 提领券
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-21
 */
class CouponExchange extends BaseModel {


  protected $_queryOptionRule = array(

    'start_time' => 'range',

    'end_time' => 'range',

  );

}
