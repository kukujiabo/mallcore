<?php
namespace App\Model;

/**
 * [模型层] 外卖订单商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-09
 */
class OrderTakeOutGoods extends BaseModel {

    protected $_table = 'order_take_out_goods';

    protected $_queryOptionRule = array(

      'id' => 'in',

      'order_take_out_id' => 'in',

      'goods_name' => 'like',

      'sku_name' => 'like',

      'goods_id' => 'in',

      'goods_money' => 'range',
      
      'created_at' => 'range'

    );  
    
}
