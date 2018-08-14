<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

class ConstructTypeSv extends BaseService {

  use CurdSv;

  public function create($data) {
  
    $newData = array(
    
      'name' => $data['name'],
    
      'remark' => $data['remark'],

      'created_at' => date('Y-m-d H:i:s')
    
    ); 

    $id = self::add($newData);

    $attrs = json_decode($data['attrs'], true);

    $constructAttributes = array();

    foreach($attrs as $attr) {
    
      $attribute = array(
      
        'construct_id' => $id,

        'attr_val' => $attr['attr_val'],

        'created_at' => date('Y-m-d H:i:s')
      
      );
    
      array_push($constructAttributes, $attribute);

    }

    ConstructAttributeSv::batchAdd($constructAttributes);

    return $id;
  
  }

  public function getAll() {
  
    return self::all(array()); 
  
  }

  public function getDetail() {
  
    $detail = self::findOne($data['id']); 

    $detail['attrs'] = ConstructAttributeSv::all(array( 'construct_id' => $data['id'] ));

    return $detail;
  
  }

  public function updateConstruct($data) {
  
    $updateData = array(
    
      'name' => $data['name'],

      'remark' => $data['remark']

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

    $attributes = ConstructAttributeSv::all(array( 'construct_id' => $data['id'] ));
    
    foreach($attributes as $attribute) {

      if (!in_array($attribute['id'], $attrIds)) {
      
        $updateNum += ConstructAttributeSv::remove($attribute['id']);  
      
      }
    
    }

    foreach($attrs as $attr) {

      if ($attr['id']) {

        $id = $attr['id'];

        unset($attr['id']);
    
        $updateNum += ConstructAttributeSv::update($id, $attr); 

      } else {

        $attr['construct_id'] = $data['id'];
      
        $updateNum += ConstructAttributeSv::add($attr);
      
      }
    
    }

    return $updateNum;
  
  }

  public function removeConstruct() {
  
    $num = self::remove($data['id']);
  
    $num += ConstructAttributeSv::removeAll(array( 'construct_id' => $data['id'] ));

    return $num;
  
  }

}
