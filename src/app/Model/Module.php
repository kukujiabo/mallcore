<?php

namespace App\Model;

/**
 * [模型层] 系统模块
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class Module extends BaseModel {

  protected $_table = 'sys_module';
  
  protected $_primaryKey = 'module_id';

  protected $_queryOptionRule = array(

    'module_id' => 'in'
    
  );
  
}
