<?php
namespace App\Service\WorkSpace;

use App\Service\BaseService;
use App\Service\Admin\ProviderSv;
use App\Service\Crm\UserSv;
use Core\Service\CurdSv;

/**
 * 工地服务类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class WorkSpaceSv extends BaseService {

  use CurdSv;

  /**
   * 新增工地数据
   *
   * @param array data
   *
   * @return
   */
  public function addWorkSpace($data) {
  
    $newWorkSpace = array(
      'pid' => $data['pid'],
      'name' => $data['name'],
      'address' => $data['address'],
      'province' => $data['province'],
      'city' => $data['city'],
      'contact' => $data['contact'],
      'phone' => $data['phone'],
      'status' => 1,
      'created_at' => date('Y-m-d H:i:s')
    );

    return self::add($newWorkSpace);
  
  }

  /**
   * 查询工地列表
   *
   * @param array data
   * @param string order
   * @param int page
   * @param int pageSize
   *
   * @return
   */
  public function getList($data, $order, $page, $pageSize) {

    return self::queryList($data, '*', $order, $page, $pageSize);
  
  }

  /**
   *
   */
  public function getAllByMid($data) {
  
    $managerWorkspace = ManagerWorkspaceSv::all(array('mid' => $data['mid']));

    $wids = array();

    foreach($managerWorkspace as $mw) {
    
      array_push($wids, $mw['wid']);
    
    }

    $workspace = self::all(array('id' => implode(',', $wids)));

    foreach($workspace as $key => $value) {
    
      foreach($managerWorkspace as $mw) {
      
        if ($value['id'] = $mw['mid']) {
        
          $workspace[$key]['rest_credit'] = $mw['rest_credit'];
        
        }
      
      } 
    
    }

    return $workspace;
  
  }

}

