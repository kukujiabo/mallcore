<?php

namespace App\Model;

/**
 * [模型层] 后台管理员操作
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserAdmin extends BaseModel {
    
  protected $_table = 'sys_user_admin';

  protected $_primaryKey = 'uid';

  protected $_queryOptionRule = array(
    
    'created_at' => 'range',

    'updated_at' => 'range',

  );

}
