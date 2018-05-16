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
      'status' => $data['status'],
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

    if ($data['token']) {
    
      $infoUser = UserSv::getUserByToken($data['token']); 

      $provider = ProviderSv::findOne(array('account' => $infoUser['user_name']));

      if ($provider) {
      
         $data['pid'] = $provider['id'];
      
      }
    
    }
  
    return self::queryList($data, '*', $order, $page, $pageSize);
  
  }

}

