<?php
namespace App\Model;

/**
 * [模型层] 商品视图
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-13
 */
class Goodsview extends BaseModel {

    protected $_primaryKey = 'goods_id';

    protected $_table = 'v_goods_data';

    protected $_queryOptionRule = array(

      'goods_id' => 'in',

      'goods_name' => 'like',

      'category_id' => 'in',

      'city_code' => 'like'

    );  
    
}
