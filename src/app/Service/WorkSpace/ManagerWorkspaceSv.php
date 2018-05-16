<?php
namespace App\Service\WorkSpace;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 项目经理关联工地服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class ManagerWorkspaceSv extends BaseService {

  use CurdSv;

  public function addNew($data) {
  
    return self::add($data);  
  
  }

}
