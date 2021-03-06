<?php

namespace App\Model;

/**
 * [模型层] 用户组权限操作
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserGroupJurisdiction extends BaseModel {
    
  protected $_table = 'sys_user_group_jurisdiction';

  protected $_queryOptionRule = array(

    'created_at' => 'range',

    'updated_at' => 'range',

    'deleted_at' => 'range',

  );

}
