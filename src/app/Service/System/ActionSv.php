<?php

namespace App\Service\System;

use App\Service\BaseService;
use App\Interfaces\System\IAction;
use App\Model\Action;
use Core\Service\CurdSv;

/**
 * 系统定义操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class ActionSv extends BaseService implements IAction {

    use CurdSv;

    /**
     * 根据操作路径查找有效的action
     *
     * @param string $operation
     *
     * @return array $action
     */
    public function findActiveOneByOperation($operaiton) {
    
      $actions = Action::all(array('operation' => $operation));

      return $action[0];
    
    }

}
