<?php

namespace App\Service\System;

use App\Service\BaseService;
use App\Service\Crm\UserSv;
use App\Interfaces\System\IModule;
use App\Model\Module;
use Core\Service\CurdSv;

/**
 * 系统模块接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class ModuleSv extends BaseService implements IModule {

  use CurdSv;

  /**
   * 获取crm前台展示模块
   * 1. 用户类型
   * 2. 用户等级
   * 3. 当日时间
   * 4. 固定日期
   *
   * @param array $data
   *
   * @return 
   */
  public function crmModList($data) {

    $member = UserSv::getUserByToken($data['token']);

    $rules = ModuleDisplayRuleSv::queryDisplayModules('0', 'crm_client', $member['member_level']);

    $rids = array();

    foreach($rules as $rule) {
    
      array_push($rids, $rule['module_id']);
     
    }

    $queryOptions = array(
    
      'module_id' => implode(',', $rids),

      'module' => 'crm_client'
    
    );

    $modules = self::all($queryOptions, '');

    foreach($modules as $key => $module) {
    
      foreach($rids as $key => $rid) {
      
        if ($module['module_id'] == $rid) {
        
          $rids[$key] = $module;
        
        }
      
      }
    
    }

    return $rids;
  
  }
  
}
