<?php
namespace App\Domain;

use App\Service\Commodity\GoodsPriceMapSv;

/**
 * 商品价格体系
 */
class GoodsPriceMapDm {

  public function addRule($data) {
  
    return GoodsPriceMapSv::addRule($data);
  
  }

  public function getList($data) {
  
    return GoodsPriceMapSv::getList($data);
  
  }

  public function edit($data) {
  
    return GoodsPriceMapSv::edit($data);
  
  }

  public function batchEdit($data) {
  
    return GoodsPriceMapSv::batchEdit($data);
  
  }

  public function remove($data) {
  
    return GoodsPriceMapSv::remove($data['id']);
  
  }

  public function exportExcel($data) {
  
    return GoodsPriceMapSv::exportExcel($data);
  
  }

  public function importData($data) {

    return GoodsPriceMapSv::importData($data);

  }

  public function syncSkuPriceByGoodsId($data) {
  
    return GoodsPriceMapSv::syncSkuPriceByGoodsId($data);  
  
  }

  public function removeAllPriceItem($data) {
  
    return GoodsPriceMapSv::removeAllPriceItem($data);
  
  }

}
