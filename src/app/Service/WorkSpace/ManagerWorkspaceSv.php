<?php
namespace App\Service\WorkSpace;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Crm\ManagerSv;

/**
 * 项目经理关联工地服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class ManagerWorkspaceSv extends BaseService {

  use CurdSv;

  public function addNew($data) {

    $data['created_at'] = date('Y-m-d H:i:s');
  
    return self::add($data);  
  
  }

  public function getList($data) {

    $page = $data['page'];
    $pageSize = $data['page_size'];
    $order = $data['order'];
  
    unset($data['page']);
    unset($data['page_size']);
    unset($data['order']);

    $list = self::queryList($data, '*', $order, $page, $pageSize);

    foreach($list['list'] as $key => $item) {
    
      $manager = ManagerSv::findOne($item['mid']);
      
      $workspace = WorkSpaceSv::findOne($item['wid']);

      $list['list'][$key]['mname'] = $manager['name'];
      $list['list'][$key]['wname'] = $workspace['name'];
    
    }

    return $list;
  
  }


}
