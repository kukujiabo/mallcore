<?php
namespace App\Model;

/**
 * [模型层] 商品分类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class GoodsCategory extends BaseModel {

    protected $_primaryKey = 'category_id';

    protected $_queryOptionRule = array(

      'category_id' => 'in',

      'category_name' => 'like'

    );  
    
}
