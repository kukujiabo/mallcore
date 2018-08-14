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

    $detail['attrs'] = LayoutAttributeSv::all(array( 'layout_id' => $data['id'] ));

    return $detail;
  
  }

  public function updateLayout($data) {
  
    $updateData = array(
    
      'layout_name' => $data['layout_name'],

      'info' => $data['info'],

      'created_at' => date('Y-m-d H:i:s')
    
    );

    $updateNum = 0;

    $updateNum += self::update($data['id'], $updateData);

    $attrIds = array();

    $attrs = json_decode($data['attrs'], true);

    foreach($attrs as $attr) {

      if ($attr['id']) {
    
        array_push($attrIds, $attr['id']);

      }
    
    }

    $attributes = LayoutAttributeSv::all(array( 'layout_id' => $data['id'] ));

    $oldIds = array();
    
    foreach($attributes as $attribute) {

      if (!in_array($attribute['id'], $attrIds)) {
      
        $updateNum += LayoutAttributeSv::remove($attribute['id']);  
      
      }
    
    }

    foreach($attrs as $attr) {

      if ($attr['id']) {

        $id = $attr['id'];

        unset($attr['id']);
    
        $updateNum += LayoutAttributeSv::update($id, $attr); 

      } else {

        $attr['layout_id'] = $data['id'];
      
        $updateNum += LayoutAttributeSv::add($attr);
      
      }
    
    }

    return $updateNum;
  
  }

  public function removeLayout($data) {
  
    $num = self::remove($data['id']);
  
    $num += LayoutAttributeSv::removeAll(array( 'layout_id' => $data['id'] ));

    return $num;
  
  }

}
