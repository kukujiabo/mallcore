<?php
namespace App\Model;

/**
 * [模型层] 收货地址信息
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */
class MemberExpressAddress extends BaseModel {

    protected $_table = 'member_express_address';

    protected $_queryOptionRule = array(

        'deleted_at' => 'range',

    );  

}