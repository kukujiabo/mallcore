<?php
namespace App\Model;

/**
 * [模型层] 外卖购物车
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class CartTakeOut extends BaseModel {

    protected $_primaryKey = 'cart_id';

    protected $_queryOptionRule = array(
        
        'cart_id' => 'in',
        
        'goods_id' => 'in',
        
        'num' => 'range',

    );

    protected $_updateOptionRule = array(

        'num' => 'accumulate'

    );
    
}
