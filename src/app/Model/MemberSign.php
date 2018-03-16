<?php
namespace App\Model;

/**
 * [模型层] 会员签到
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class MemberSign extends BaseModel {


  protected $_queryOptionRule = array(
    
    'id' => 'in',

    'sign_time' => 'range',

  );

}
