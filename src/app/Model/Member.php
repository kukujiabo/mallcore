<?php
namespace App\Model;

/**
 * [模型层] 会员
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-13
 */
class Member extends BaseModel {

  protected $_primaryKey = 'uid';

  protected $_queryOptionRule = array(

    'member_name' => 'in'

  );

}
