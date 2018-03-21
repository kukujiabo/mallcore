<?php
namespace App\Model;

/**
 * [模型层] 外卖订单
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-09
 */
class OrderTakeOut extends BaseModel {

    protected $_table = 'order_take_out';

    protected $_queryOptionRule = array(

        'id' => 'in',

        'create_time' => 'range',

        'pay_time' => 'range',

        'shipping_time' => 'range',

        'sign_time' => 'range',

        'consign_time' => 'range',
        
        'finish_time' => 'range',

        'order_id' => 'in'

    );  
    
}
