<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Model\NationwideArea;
use App\Service\Shop\ShopSv;
use Core\Service\CurdSv;

/**
 * 全国地区类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class NationwideAreaSv extends BaseService {

  use CurdSv;

  /**
   * 全部的区域
   */
  public function queryList($condition){

    $where = array();

    $fields = 'id,name,active,parent as parent_id,py_short,short,hot';

    if ($condition['type'] == 1) {

      return NationwideArea::getAreaList($where);

    } elseif ($condition['type'] == 2) {

      if ($condition['parent_id']) {
        
        $where['parent'] = $condition['parent_id'];

      } else {
        
        $where['level'] = 1;

      }

      return NationwideArea::queryList($where, $fields, 'id asc', 0, 10000);

    } elseif ($condition['type'] == 3) {

      if ($condition['parent_id']) {
        
        $where['parent'] = $condition['parent_id'];

      } else {
        
        $where['level'] = 2;

      }

      return NationwideArea::queryList($where, $fields, 'id asc', 0, 10000);

    } elseif ($condition['type'] == 4) {

      if ($condition['parent_id']) {
        
        $where['parent'] = $condition['parent_id'];

      } else {
        
        $where['level'] = 3;

      }

      return NationwideArea::queryList($where, $fields, 'id asc', 0, 10000);

    } else {

      return false;

    }

  }

  /**
   * 获得经纬度所在的省市区
   * @param float $latitude 纬度，范围为-90~90，负数表示南纬
   * @param float $longitude 经度，范围为-180~180，负数表示西经
   */
  public function getAddress ($condition) {

    $info_address = ShopSv::getQqAddress($condition['latitude'], $condition['longitude']);

    $info = $info_address['address_component'];

    $info['province_code'] = substr($info_address['ad_info']['adcode'], 0, 2).'0000';

    $info['city_code'] = substr($info_address['ad_info']['adcode'], 0, 4).'00';

    $info['district_code'] = $info_address['ad_info']['adcode'];

    return $info;

  }

  /**
   * 获取所有行政区
   *
   * @return array $unionAreas
   */
  public function cascadeList() {
  
    $provinces = self::queryList(array('type' => 2));

    $cities = self::queryList(array('type' => 3));

    $areas = self::queryList(array('type' => 4));

    $unionAreas = array(

      'provinces' => $provinces,

      'cities' => $cities,
    
      'areas' => $areas

    );

    return $unionAreas;
  
  }

  /**
   * 查询城市
   */
  public function queryCity($condition) {
  
    $condition['level'] = 2;

    $cities = self::all($condition);
     
    return $cities; 
  
  }

}
