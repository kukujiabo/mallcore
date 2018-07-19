<?php
namespace App\Service\Commodity;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Service\BaseService;
use Core\Service\CurdSv;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * 价格体系服务
 * @desc 价格体系服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class GoodsPriceMapSv extends BaseService {

  use CurdSv;

  /**
   * 添加体系规则
   *
   */
  public function addRule($params) {
  
    $params['created_at'] = date('Y-m-d H:i:s');

    $skus = json_decode($params['skus'], true);

    $dataSet = array();

    $condition = array(
    
      'goods_id' => $params['goods_id'],

      'city_code' => $params['city_code'],

      'user_level' => $params['user_level']
    
    );

    self::batchRemove($condition);

    foreach($skus as $sku) {
    
      $newPrice = array(
      
        'goods_id' => $params['goods_id'],

        'goods_name' => iconv("UTF-8", "GBK", $params['goods_name']),

        'user_level' => $params['user_level'],

        'city_code' => $params['city_code'],

        'sku_id' => $sku['sku_id'],

        'sku_name' => iconv("UTF-8", "GBK", $sku['sku_name']),

        'level_name' => iconv("UTF-8", "GBK", $params['level_name']),
      
        'city_name' => iconv("UTF-8", "GBK", $params['city_name']),

        'price' => floatval($sku['price']),

        'tax_off_price' => $sku['tax_off_price'],

        'created_at' => date('Y-m-d H:i:s')

      );

      array_push($dataSet, $newPrice);
    
    }

    $good = array(
    
      'goods_id' => $params['goods_id'],

      'user_level' => $params['user_level'],

      'goods_name' => $params['goods_name'],

      'city_code' => $params['city_code'],

      'sku_name' => $params['goods_name'],

      'sku_id' => 0,

      'price' => $params['price'],

      'tax_off_price' => $params['tax_off_price'],

      'created_at' => date('Y-m-d H:i:s'),

      'level_name' => $params['level_name'],
      
      'city_name' => $params['city_name']
    
    );

    $dataSet[] = $good;

    return self::batchAdd($dataSet);
  
  }

  public function edit($params) {

    $update = array(
    
      'price' => $params['price'],

      'tax_off_price' => $params['tax_off_price']
    
    );

    return self::update($params['id'], $update);
  
  }

  public function getList($params) {

    $query = array();

    $params['goods_name'] ? $query['goods_name'] = $params['goods_name'] : '';
    
    $params['sku_name'] ? $query['sku_name'] = $params['sku_name'] : '';
  
    return self::queryList($query, '*', 'created_at desc', $params['page'], $params['page_size']);
  
  }


  public function batchEdit($params) {
  
    $batchData = json_decode($params['data'], true);

    $i = 0;
  
    foreach($batchData as $data) {
    
      $id = $data['id'];

      unset($data['id']);
    
      $i += self::update($id, $data);
    
    }

    return $i;
  
  }

  /**
   * 导出excel
   * @desc 导出excel
   *
   */
  public function exportExcel($conditions) {
  
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Type:application/vnd.ms-excel');

    header('Content-Disposition: attachment;filename="价格数据.xlsx"');
    header('Cache-Control: max-age=0');
      
    $spreadsheet = new Spreadsheet();

    $titles = array(
    
      '产品名称', 
      'sku名称', 
      '等级', 
      '城市名称', 
      '普通价格', 
      '含税价格', 
      '用户等级', 
      '城市代码', 
      '商品代码', 
      'sku代码'
    
    );

    $sheet = $spreadsheet->getActiveSheet();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    foreach($titles as $key => $title) {

      $sheet->setCellValue("{$characters[$key]}1", $title);
    
    }

    $sheet->getColumnDimension('A')->setWidth(30);

    $row = 2;

    $prices = self::all($conditions);

    foreach($prices as $price) {

      $column = 0;

      $valuePrice = array(

        'goods_name' => iconv('GBK', 'UTF-8', $price['goods_name']),

        'sku_name' => iconv('GBK', 'UTF-8', $price['sku_name']),

        'level_name' => iconv('GBK', 'UTF-8', $price['level_name']),

        'city_name' => iconv('GBK', 'UTF-8', $price['city_name']),
      
        'price' => $price['price'],

        'tax_off_price' => $price['tax_off_price'],

        'user_level' => $price['user_level'],

        'city_code' => $price['city_code'],

        'goods_id' => $price['goods_id'],
        
        'sku_id' => $price['sku_id']

      );

      foreach($valuePrice as  $value) {

        $cell = "{$characters[$column]}{$row}";

        $sheet->setCellValue($cell, $value);

        $column++;

      }

      $row++;

    }

    $writer = new Xlsx($spreadsheet);

    $writer->save("php://output");

    exit(0);
  
  }

  /**
   * 导入数据
   *
   */
  public function importData($data) {

    $fileName = time() . '.xlsx';
  
    copy($data["file_path"], API_ROOT . "/public/uploads/" . $fileName );

    $spreadSheet = IOFactory::load(API_ROOT . '/public/uploads/' . $fileName);

    $sheetData = $spreadSheet->getActiveSheet()->toArray(null, true, true, false);

    $i = 0;

    foreach($sheetData as $row) {
    
      $newData = [
      
        'goods_name' => $row[0],
        'sku_name' => $row[1],
        'level_name' => $row[2],
        'city_name' => $row[3],
        'price' => $row[4],
        'tax_off_price' => $row[5],
        'user_level' => $row[6],
        'city_code' => $data['city_code'],
        'goods_id' => $row[8],
        'sku_id' => $row[9]

      ];
    
      $price = self::findOne(array('sku_id' => $newData['sku_id'], 'city_code' => $newData['city_code']));

      if ($price) {
      
        self::remove($price['id']);
      
      }

      self::add($newData);

      $i++;
    
    }

    return $i;
  
  }

}
