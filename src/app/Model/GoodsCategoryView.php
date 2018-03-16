<?php
namespace App\Model;

/**
 * [模型层] 商品分类视图
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-13
 */
class GoodsCategoryView extends BaseModel {

    protected $_primaryKey = 'category_id';

    protected $_table = 'v_goods_category_data';

    protected $_queryOptionRule = array(

        'category_id' => 'in'  

    );  
    
}
