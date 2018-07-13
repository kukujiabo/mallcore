<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

class HouseLayoutSv extends BaseService {

  use CurdSv;

  /**
   * 新建布局
   * @desc 新建布局
   *
   * @return int id
   */
  public function create($data) {
  
    $newData = array(
    
      'layout_name' => $data['layout_name'],
      'info' => $data['info'],
      'create_at' => date('Y-m-d H:i:s')
    
    );
  
    return self::add($newData);

  }

  /**
   * 获取全部布局
   *
   * @return array data
   */
  public function getAll($data) {
  
    return self::all(array());
  
  }

}
