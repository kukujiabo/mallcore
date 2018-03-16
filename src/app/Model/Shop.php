<?php
namespace App\Model;

/**
 * [模型层] 门店（店铺）
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-08
 */
class Shop extends BaseModel {

    protected $_primaryKey = 'shop_id';

    protected $_queryOptionRule = array(

        'shop_id' => 'in',

    );

}
