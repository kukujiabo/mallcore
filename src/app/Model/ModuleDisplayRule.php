<?php
namespace App\Model;

/**
 * [模型层] 模型展示规则
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-04
 */
class ModuleDisplayRule extends BaseModel {

  protected $_table = 'sys_module_display_rule';

  protected $_queryOptionRule = array(
  
    'user_type' => 'in',

    'user_level' => 'in',

    'module_id' => 'in',

    'mode' => 'in'
  
  );

}
