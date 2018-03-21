<?php
namespace App\Model;

/**
 * [模型层] 外卖订单地址
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutAddress extends BaseModel {

    protected $_table = 'order_take_out_address';

    protected $_queryOptionRule = array(

      'mobile' => 'like',

      'consigner' => 'like',

      'address' => 'like'

    );  
    
}
