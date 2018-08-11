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

      'created_at' => date('Y-m-d H:i:s')
    
    );
  
    $id = self::add($newData);

    $attrs = json_decode($data['attrs'], true);

    $layoutAttrs = array();

    foreach($attrs as $attr) {
    
      $layout = array(
      
        'layout_id' => $id,

        'attr_val' => $attr['attr_val'],

        'num' => $attr['num'],

        'rank' => $attr['rank'],

        'goods' => json_encode($attr['goods']),

        'created_at' => date('Y-m-d H:i:s')
      
      );

      array_push($layoutAttrs, $layout);
    
    } 

    LayoutAttributeSv::batchAdd($layoutAttrs);
    
    return $id;

  }

  /**
   * 获取全部布局
   *
   * @return array data
   */
  public function getAll($data) {
  
    return self::all(array());
  
  }

  /**
   * 获取详情
   *
   */
  public function getDetail($data) {
  
    $detail = self::findOne($data['id']); 

    $attrs = LayoutAttributeSv::all(array( 'layout_id' => $data['id'] ));

    $detail['attrs'] = json_encode($attrs);

    return $detail;
  
  }

}
