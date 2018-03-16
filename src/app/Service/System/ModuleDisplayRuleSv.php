<?php
namespace App\Service\System;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Interfaces\System\IModuleDisplayRule;

/**
 * 
 *
 */
class ModuleDisplayRuleSv extends BaseService implements IModuleDisplayRule {

  use CurdSv;

  public function queryDisplayModules($uType, $mode, $uLevel) {
  
    $queryOptions = array(
    
      'user_type' => $uType,

      'mode' => $mode,

      'user_level' => $uLevel,

      'active' => 1
    
    );

    $rules = self::all($queryOptions, 'display_order desc');

    $currentTime = time();

    $inDate = array();

    /**
     * 判断是否在有效期
     */
    foreach($rules as $rule) {
    
      if (
        $rule['show_date_start'] > $currentTime || 
        ($rule['show_date_end'] < $currentTime && $rule['show_date_end'] > 0)
      ) {
      
        continue;
      
      }

      array_push($inDate, $rule);
    
    }

    $hour = date('H');

    $inTime = array();

    /**
     * 判断是否在有效时段
     */
    foreach($inDate as $rule) {

      if (
        ($rule['show_time_start'] == 0 && $rule['show_time_end'] == 0) ||
        ($rule['show_time_start'] <= $hour && $rule['show_time_end'] >= $hour)
      ) {
      
        array_push($inTime, $rule);
      
      }
    
    }
  
    return $inTime;

  }



}
