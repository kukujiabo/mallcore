<?php
namespace App\Model;

/**
 * [模型层] 用户信息
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-14
 */
class User extends BaseModel {

    protected $_table = 'users';

    protected $_primaryKey = 'uid';

    protected $_queryOptionRule = array(
        'birthday' => 'range',
        'reg_time' => 'range',
        'real_name' => 'like',
        'nick_name' => 'like',
        'uid' => 'in',
        'user_tel' => 'in'
    );

}
