<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

class SmartTemplateSv extends BaseService {

  use CurdSv;

  public function create($data) {
  
    $newData = array(
    
      'template_name' => $data['template_name'],
      'layout_ids' => $data['layout_ids'],
      'min_measure' => $data['min_measure'],
      'max_measure' => $data['max_measure'],
      'created_at' => date('Y-m-d H:i:s')
    
    );  
  
    $id = self::add($newData);

    $goods = json_decode($data['goods'], true);

    $newGoods = [];

    foreach($goods as $good) {
    
      $newGood = array(
      
        'template_id' => $id,

        'sku_id' => $good['goods_id'],

        'num' => $good['num'],

        'cons_id' => $good['consType'],

        'rank' => $good['rank'],

        'created_at' => date('Y-m-d H:i:s')
      
      ); 

      array_push($newGoods, $newGood);
    
    }

    TemplateGoodsSv::batchAdd($newGoods);

    return $id;
  
  }

  public function getList($data) {
  
  
  
  }

}
