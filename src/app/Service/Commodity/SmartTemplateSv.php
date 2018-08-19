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
  
    $query = array();

    if ($data['template_name']) {
    
      $query['template_name'] = $data['template_name'];
    
    }   

    return self::queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);
  
  }

  public function getDetail($data) {
  
    $detail = self::findOne($data['id']);
  
    $goods = TemplateGoodsSv::all(array( 'template_id' => $data['id'] ));

    $skuIds = array();

    foreach($goods as $good) {
    
      array_push($skuIds, $good['sku_id']);
    
    }

    $skus = GoodsSkuSv::all(array( 'sku_id' => implode(',', $skuIds)));

    foreach($skus as $key => $sku) {

      foreach($goods as $good) {
    
        if ($sku['sku_id'] == $good['sku_id']) {

          $skus[$key] = array_merge($sku, $good);

        }

      }
    
    }

    $detail['goods'] = $skus;

    return $detail;
  
  }

  public function updateTemplate($data) {

    $id = $data['id'];
  
    $newData = array(
    
      'template_name' => $data['template_name'],

      'layout_ids' => $data['layout_ids'],

      'min_measure' => $data['min_measure'],

      'max_measure' => $data['max_measure'],

      'created_at' => date('Y-m-d H:i:s')
    
    );  

    $updateNum = 0;
  
    $updateNum += self::update($id, $newData);

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

    $oldGoods = TemplateGoodsSv::all(array( 'template_id' => $id ));

    $newIds = array();

    foreach($newGoods as $newGood) {
    
      array_push($newIds, $newGood['sku_id']);
    
    }

    foreach($oldGoods as $oldGood) {
    
      if (!in_array($oldGood['sku_id'], $newIds)) {
      
        $updateNum += TemplateGoodsSv::remove($oldGood['id']); 
      
      } 
    
    }

    foreach($newGoods as $newGood) {
    
      if ($newGood['id']) {

        $id = $newGood['id'];

        unset($newGood['id']);
      
        $updateNum += TemplateGoodsSv::update($id, $newGood);
      
      } else {
      
        $updateNum += TemplateGoodsSv::add($newGood); 
      
      }
    
    }

    return $updateNum;
  
  }

  public function getGoods($data) {
  
    $layoutIds = explode(',', $data['layoutIds']); 
  
    asort($layoutIds);

    $layoutIdsStr = implode($layoutIds);

    $template = self::findOne(array( 'layout_ids' => $layoutIdsStr, 'max_measure' => "eg|{$data['measure']}", 'min_measure' => "el|{$data['measure']}" ));

    return $template;
  
  }

}
