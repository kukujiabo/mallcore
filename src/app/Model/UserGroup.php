<?php

namespace App\Model;

/**
 * [模型层] 系统用户组操作
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserGroup extends BaseModel {
    
  protected $_table = 'sys_user_group';

  protected $_primaryKey = 'group_id';

  protected $_queryOptionRule = array(
    
    'create_time' => 'range',

    'modify_time' => 'range',

    'deleted_at' => 'range',

  );

}
