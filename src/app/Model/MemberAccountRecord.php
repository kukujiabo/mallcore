<?php
namespace App\Model;

/**
 * [模型层] 会员账户记录
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-02
 */
class MemberAccountRecord extends BaseModel {

    protected $_table = 'member_account_records';

    protected $_queryOptionRule = array(
        
        'create_time' => 'range',

        'number' => 'range',
        
        'id' => 'in',

    );

}