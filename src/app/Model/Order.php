<?php
namespace App\Model;

/**
 * [模型层] 订单信息
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-09
 */
class Order{

    /**
     * 添加订单
     */
    public static function add($data) {
        $add = \PhalApi\DI()->notorm->orders;
        $add->insert($data);
        return $add->insert_id();
    }
    
}
