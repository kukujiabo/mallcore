<?php
namespace App\Model;

/**
 * [模型层] 用户信息
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-15
 */
class MemberIncreaseByDate extends BaseModel {

    protected $_table = 'v_member_increase_by_date';

    protected $_queryOptionRule = array(
        'reg_date' => 'range',
    );

}
