<?php
namespace App\Service\Shop;

use App\Service\BaseService;
use App\Interfaces\Shop\IShop;
use App\Model\Shop;
use Core\Service\CurdSv;
use App\Service\System\ConfigSv;
use App\Library\Http;
use PhalApi\Exception;

/**
 * 商铺接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-08
 */
class ShopSv extends BaseService implements IShop {

  use CurdSv;


  /**
   * 添加
   */
  public function addShop($data) {

    try{

      return self::add($data);

    } catch (\Exception $e){

      throw new InternalServerErrorException('新增品牌失败', 100928);

    }

  }

  /**
   * 编辑内容
   */
  public function updateShop($data) {
    
    if ($data['shop_id']) {

      $condition['shop_id'] = $data['shop_id'];

      unset($data['shop_id']);

    }
    
    return Shop::batchUpdate($condition, $data);

  }

  /**
   * 获取详情
   */
  public function getDetail($data) {
    
    return Shop::findOne($data['shop_id']);

  }


  /**
   * 启用规则
   */
  public function enable($condition) {

    $condition['shop_state'] = 1;

    return self::updateShop($condition);

  }

  /**
   * 禁用规则
   */
  public function disable($condition) {
    
    $condition['shop_state'] = 0;
  
    return self::updateShop($condition);

  }

  /**
   * 行政区划（获取全部行政区划数据）
   */
  public function getQqDistrict() {

    $qq_key = ConfigSv::getConfigValueByKey('qq_key');

    $origin_uri = \PhalApi\DI()->config->get('qq.get_administrative_region_uri');

    $origin_uri = str_replace('{KEY}', $qq_key, $origin_uri);

    $result = Http::httpGet($origin_uri);

    $result = json_decode($result, true);

    self::qqVerify($result);

    return $result['result'];

  }

  /**
   * 逆地址解析（坐标位置描述）
   */
  public function getQqAddress($latitude, $longitude) {

    $qq_key = ConfigSv::getConfigValueByKey('qq_key');

    $origin_uri = \PhalApi\DI()->config->get('qq.get_address_uri');

    $origin_uri = str_replace('{LATITUDE}', $latitude, $origin_uri);

    $origin_uri = str_replace('{LONGITUDE}', $longitude, $origin_uri);

    $origin_uri = str_replace('{KEY}', $qq_key, $origin_uri);

    $result = Http::httpGet($origin_uri);

    $result = json_decode($result, true);

    self::qqVerify($result);

    return $result['result'];

  }

  /**
   * 根据地址获取腾选地图坐标
   * @param string address 详细地址
   * @param string type 有参数就不开启返回数据验证 1-不验证 0-验证
   * @return array 详情参考http://lbs.qq.com/webservice_v1/guide-geocoder.html
   */
  public function getQqCoordinate($address, $type = '') {

    $qq_key = ConfigSv::getConfigValueByKey('qq_key');

    $origin_uri = \PhalApi\DI()->config->get('qq.get_coordinate_uri');

    $origin_uri = str_replace('{ADDRESS}', $address, $origin_uri);

    $origin_uri = str_replace('{KEY}', $qq_key, $origin_uri);

    $result = Http::httpGet($origin_uri);

    $result = json_decode($result, true);

    if (!$type) {

      self::qqVerify($result);

    }
    
    return $result['result'];

  }

  /**
   * 获取门店列表
   */
  public function getList ($condition) {

    if ($condition['member_latitude'] && $condition['member_longitude']) {

      $latitude = $condition['member_latitude'];

      $longitude = $condition['member_longitude'];

    } elseif ($condition['address']) {

      $result = self::getQqCoordinate($condition['address']);

      $latitude = $result['location']['lat'];

      $longitude = $result['location']['lng'];

    }

    if ($longitude && $latitude && !$condition['district_id']) {

      $result_address = self::getQqAddress($latitude, $longitude);

      $condition['district_id'] = $result_address['ad_info']['adcode'];

    }

    unset($condition['member_latitude']);
    
    unset($condition['member_longitude']);
    
    unset($condition['address']);

    $list = self::all($condition);

    if ($longitude && $latitude) {

      $ages = array();

      foreach ($list as &$v) {
        
        $ages[] = $v['distance'] = self::getdistance($v['longitude'], $v['latitude'], $longitude, $latitude);

      }

      unset($v);

      array_multisort($ages, SORT_ASC, $list);

    }

    return \App\pageDispose($list, $condition['page'], $condition['page_size']);

  }

  /**
   * 求两个已知经纬度之间的距离,单位为米
   * 
   * @param lng1 $ ,lng2 经度
   * @param lat1 $ ,lat2 纬度
   * @return float 距离，单位米
   */
  public function getdistance($lng1, $lat1, $lng2, $lat2) {

    // 将角度转为狐度
    $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度

    $radLat2 = deg2rad($lat2);

    $radLng1 = deg2rad($lng1);

    $radLng2 = deg2rad($lng2);

    $a = $radLat1 - $radLat2;

    $b = $radLng1 - $radLng2;

    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;

    return $s;

  } 

  /**
   * 验证腾讯请求的返回
   */
  public function qqVerify($data) {

    if ($data['status'] == 310) {

      throw new Exception('请求参数信息有误', 4310);

    } elseif ($data['status'] == 311) {

      throw new Exception('Key格式错误', 4311);

    } elseif ($data['status'] == 306) {

      throw new Exception('请求有护持信息请检查字符串', 4306);

    } elseif ($data['status'] == 110) {

      throw new Exception('请求来源未被授权', 4110);

    } elseif ($data['status'] !== 0) {

      throw new Exception('腾讯地图API请求失败，请重试', 4000);

    }

  }
  

}
