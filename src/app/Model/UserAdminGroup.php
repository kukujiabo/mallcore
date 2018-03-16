<?php

namespace App\Model;

/**
 * [模型层] 后台管理员角色关联操作
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserAdminGroup extends BaseModel {
    
  protected $_table = 'sys_user_admin_group';

  protected $_queryOptionRule = array(
    
    'created_at' => 'range',

    'updated_at' => 'range',

    'deleted_at' => 'range',

  );

}
