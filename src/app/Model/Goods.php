<?php
namespace App\Model;

/**
 * [模型层] 商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-13
 */
class Goods extends BaseModel {

    protected $_primaryKey = 'goods_id';

    protected $_queryOptionRule = array(

      'goods_id' => 'in',

      'goods_name' => 'like'

    );  
    
}
