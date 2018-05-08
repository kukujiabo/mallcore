<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 项目经理服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-05-05
 */
class ManagerSv extends BaseService {

  use CurdSv;

  /**
   * 新增项目经理
   * @desc 新增项目经理
   *
   * @param array data
   *
   * @return int id
   */
  public function addManager($data) {
  
    $newManager = array(
      'pid' => $data['pid'],
      'name' => $data['name'],
      'thumbnail' => $data['thumbnail'],
      'phone' => $data['phone'],
      'status' => $data['status'],
      'created_at' => date('Y-m-d H:i:s')
    );

    return self::add($newManager);
  
  }

  /**
   * 获取项目经理列表
   * @desc 获取项目经理列表
   *
   * @param array query
   * @param string order
   * @param int page
   * @param int pageSize
   *
   * @return array list
   */
  public function getList($query, $order, $page, $pageSize) {
  
    return self::queryList($query, '*', $order, $page, $pageSize); 
  
  }

}
