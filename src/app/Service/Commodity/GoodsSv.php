<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Interfaces\Commodity\IGoods;
use App\Model\Goods;
use Core\Service\CurdSv;
use PhalApi\Exception;
use App\Service\Commodity\GoodsImagesSv;
use App\Service\Commodity\GoodsAttributeSv;
use App\Service\Commodity\GoodsAttributeValueSv;
use App\Service\Commodity\GoodsSkuSv;
use App\Service\Commodity\GoodsViewSv;
use App\Service\Commodity\GoodsBrandSv; 

/**
 * 商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-13
 */
class GoodsSv extends BaseService implements IGoods {

  use CurdSv;

  /**
   * 获取商品库存
   */
  public function getGoodsStock($data) {

      $where['goods_id'] = $data['goods_id'];

      if ($data['sku_id']) {

          $where['sku_id'] = $data['sku_id'];

          $info = GoodsSkuSv::findOne($where);

      } else {

          $info = self::findOne($where);

      }

      if (!$info) {

          throw new Exception("未找到商品", 810201);
          
      }

      return array('stock'=>$info['stock']);

  }

  /**
   * 编辑商品（包含SUK）
   */
  public function editSkuGoods($params) {

      // 商品图片
      $img_data = json_decode($params['images'], true);

      foreach ($img_data as $v) {

          if ($v['is_cover'] == 2) {

              // 商品主图
              $data['picture'] = $v['img'];

              break;

          }

      }

      // 未设置主图默认用第一张
      if (!isset($data['picture']) && isset($img_data[0])) {

          $data['picture'] = $img_data[0];

      }

      $data['thumbnail'] = $params['thumbnail'];
      $data['goods_name'] = $params['goods_name'];
      $data['shop_id'] = $params['shop_id'];
      $data['is_sku'] = $params['is_sku'];
      $data['goods_number'] = $params['goods_number'];
      $data['category_id'] = $params['category_id'];
      $data['state'] = $params['state'];
      $data['price'] = $params['price'];
      $data['market_price'] = $params['market_price'];
      $data['goods_weight'] = $params['goods_weight'];
      $data['stock'] = $params['stock'];
      $data['introduction'] = $params['introduction'] ? $params['introduction'] : '';
      $data['description'] = $params['description'] ? $params['description'] : '';
      $data['no_code'] = $params['no_code'] ? $params['no_code'] : '';
      $data['sort'] = $params['sort'] ? $params['sort'] : '';
      $data['index_show'] = $params['index_show'];

      // 添加商品主数据
      $goods_id = $params['goods_id'];

      $arr['goods'] = self::update($params['goods_id'], $data);

      // 处理商品图片
      $arr['img'] = self::imgDispose($img_data, $goods_id);

      // 多规格商品添加sku商品
      if ($params['is_sku'] == 1) {

          $arr['goods_attr'] = self::attrDispose($params);

      }

      return $arr;

  }

  /**
   * 添加商品（包含SUK）
   */
  public function addSkuGoods($params) {

      // 商品图片
      $img_data = json_decode($params['images'], true);

      foreach ($img_data as $v) {

          if ($v['is_cover'] == 2) {

              // 商品主图
              $data['picture'] = $v['img'];

              break;

          }

      }

      // 未设置主图默认用第一张
      if (!isset($data['picture']) && isset($img_data[0])) {

          $data['picture'] = $img_data[0];

      }

      $data['thumbnail'] = $params['thumbnail'];
      $data['goods_name'] = $params['goods_name'];
      $data['is_sku'] = $params['is_sku'];
      $data['shop_id'] = $params['shop_id'];
      $data['goods_number'] = $params['goods_number'];
      $data['category_id'] = $params['category_id'];
      $data['state'] = $params['state'];
      $data['price'] = $params['price'];
      $data['market_price'] = $params['market_price'];
      $data['goods_weight'] = $params['goods_weight'];
      $data['stock'] = $params['stock'];
      $data['introduction'] = $params['introduction'] ? $params['introduction'] : '';
      $data['description'] = $params['description'] ? $params['description'] : '';
      $data['brand_id'] = $params['brand_id'] ? $params['brand_id'] : '';
      $data['sort'] = $params['sort'] ? $params['sort'] : '';
      $data['index_show'] = $params['index_show'];

      // 添加商品主数据
      $params['goods_id'] = $goods_id = self::addGoods($data);

      // 处理商品图片
      self::imgDispose($img_data, $goods_id);

      // 多规格商品添加sku商品
      if ($params['is_sku'] == 1) {

          self::attrDispose($params);

      }

      return $goods_id;

  }

  /**
   * 处理商品图片
   */
  public function imgDispose($img_data, $goods_id) {

      // 把所有商品图片改为无效
      GoodsImagesSv::batchUpdate(array('goods_id' => $goods_id, 'status'=> 1), array('status'=>2,'is_cover'=>1));

      foreach ($img_data as $v) {

          $where['goods_id'] = $v['goods_id'] = $goods_id;

          $where['img'] = $v['img'];

          $info_img = GoodsImagesSv::findOne($where);

          if ($info_img) {

              $data = $v;

              $data['id'] = $info_img['id'];

              $data['status'] = 1;

              // 更新商品图片
              $img[$info_img['id']] = GoodsImagesSv::edit($data);

          } else {

              $v['id'] = rand(10000000, 999999999);

              // 添加商品图片
              $img[] = GoodsImagesSv::addData($v);

          }

      }

      return $img;

  }

  /**
   * 处理sku商品
   */
  public function attrDispose($params) {

      $goods_id = $params['goods_id'];

      // 商品sku属性
      $attribute = json_decode($params['attribute'], true);

      $data_attribute_value_all = array();

      $attribute_array = array();

      GoodsAttributeSv::batchUpdate(array('goods_id'=>$goods_id, 'active'=>1), array('active'=>2));

      GoodsAttributeValueSv::batchUpdate(array('goods_id'=>$goods_id, 'active'=>1), array('active'=>2));

      foreach($attribute as $v) {

          $attr_array = array();

          $data_attribute = array();

          $data_attribute['goods_id'] = $goods_id;

          $data_attribute['attr_value'] = $v['attr_name'];

          $info_goods_attribute = GoodsAttributeSv::findOne($data_attribute);

          if ($info_goods_attribute) {

              $data_attribute['attr_id'] = $attr_id = $info_goods_attribute['attr_id'];

              $data_attribute['active'] = 1;

              // 修改商品规格
              $arr['attr'][$attr_id] = GoodsAttributeSv::edit($data_attribute);

          } else {

              $data_attribute['attr_id'] = rand(100000000, 999999999);

              // 添加商品规格
              $attr_id = $arr['attr']['attr_id'][] = GoodsAttributeSv::addGoodsAttribute($data_attribute);

          }

          $attr_array['attr_id'] = $attr_id;

          foreach ($v['attr_value'] as $vo) {
              
              $data_attribute_value = array();

              $data_attribute_value['attr_value'] = $vo;

              $data_attribute_value['attr_id'] = $attr_id;

              $data_attribute_value['goods_id'] = $goods_id;

              $info_goods_attribute_value = GoodsAttributeValueSv::findOne($data_attribute_value);

              if ($info_goods_attribute_value) {

                  $data_attribute_value['attr_value_id'] = $attr_value_id = $info_goods_attribute_value['attr_value_id'];

                  $data_attribute_value['active'] = 1;

                  // 修改商品规格项
                  $arr['attr_value'][$attr_id][$attr_value_id] = GoodsAttributeValueSv::edit($data_attribute_value);

              } else {

                  $data_attribute_value['attr_value_id'] = rand(100000000, 999999999);

                  // 添加商品规格项
                  $attr_value_id = $arr['attr_value'][$attr_id][] = GoodsAttributeValueSv::addGoodsAttributeValue($data_attribute_value);

              }

              $attr_array['attr_val'][$vo] = $attr_value_id;

          }

          $attribute_array[$v['attr_name']] = $attr_array;

      }

      // sku商品
      $goods_sku = json_decode($params['goods_sku'], true);

      $data_sku_all = array();

      GoodsSkuSv::batchUpdate(array('goods_id'=>$goods_id, 'active'=>1), array('active'=>2));

      foreach($goods_sku as $v) {

          if ($v['sku_name'] == '') {

              continue;

          }

          $v['shop_id'] = $params['shop_id'];

          $attr_val = array();

          foreach ($v['sku'] as $vo) {

              $data_attr = array();

              $data_attr['attr_id'] = $attribute_array[$vo['attr_id']]['attr_id'];

              $data_attr['attr_val'] = $attribute_array[$vo['attr_id']]['attr_val'][$vo['attr_val']];

              $data_attr['attrKey'] = $vo['attr_id'];

              $data_attr['attrValue'] = $vo['attr_val'];

              $attr_val[] = $data_attr;

          }

          unset($v['sku']);

          $where_sku['goods_id'] = $v['goods_id'] = $goods_id;

          if ($v['attr_value_items']) {

              $where_sku['attr_value_items'] = $v['attr_value_items'];

          }


          $where_sku['attr_value_items_format'] = $v['attr_value_items_format'] = json_encode($attr_val);

          $info_sku = GoodsSkuSv::findOne($where_sku);

          if ($info_sku) {

              $data_sku = $v;

              $data_sku['sku_id'] = $info_sku['sku_id'];

              $data_sku['active'] = 1;

              $arr['sku'][$info_sku['sku_id']] = GoodsSkuSv::edit($data_sku);

          } else {

              $v['sku_id'] = rand(100000000, 999999999);

              $v['shop_id'] = 0;

              $v['market_price'] = 0;

              $arr['sku']['sku_id'][] = GoodsSkuSv::addGoodsSku($v);

          }

      }

      return $arr;

  }

  /**
   * 获取列表
   */
  public function getList($condition) {

    $goods = GoodsViewSv::getList($condition);

    if ($condition['city_code'] && $condition['user_level']) {

      foreach($goods as $good) {
      
        $priceRule = GoodsPriceMapSv::findOne(array(
        
          'goods_id' => $good['goods_id'],

          'city_code' => $condition['city_code'],

          'user_level' => $condition['user_level'],

          'sku_id' => 0
        
        ));
      
        if ($priceRule) {
        
          $goods['price'] = $priceRule['price'];
        
        }
        
      }

    }

    return $goods;
      
  }

  /**
   * 获取数量
   */
  public function getCount($condition) {

      return self::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetails($condition) {

      return self::findOne($condition);

  }

  /**
   * 新增
   */
  public function addGoods($data) {

      $data['goods_id'] = time();

      $data['create_time'] = date("Y-m-d H:i:s");

      self::add($data);

      return $data['goods_id'];

  }

  /**
   * 编辑
   */
  public function updates($data) {

      if ($data['goods_id']) {

          $condition['goods_id'] = $data['goods_id'];

          unset($data['goods_id']);

      }

      return self::batchUpdate($condition, $data);

  }

  /**
   * 验证商品
   * @param int $data['goods_id'] 商品id
   * @param int $data['quantity'] 购买数量
   */
  public function verifyGoods($data){

      $where_goods['goods_id'] = $data['goods_id'];

      $info_goods = self::getDetails($where_goods);

      if (!$info_goods) {

          throw new Exception('goods_id 错误，查不到商品数据', 9002);
          
      }

      if ($info_goods['state'] == 0) {

          throw new Exception('商品'.$info_goods['goods_name'].'已下架', 9003);

      }

      if ($info_goods['state'] == 10) {

          throw new Exception('商品'.$info_goods['goods_name'].'违规已被禁售', 9004);

      }

      self::compare($data['quantity'], $info_goods['stock'],$info_goods['goods_name']);

      return $info_goods;

  }

  /**
   * 比较商品库存
   * @param int $quantity 购买数量
   * @param int $stock 库存
   * @param int $goods_name 商品名称
   */
  public function compare ($quantity, $stock, $goods_name = '') {

      if ($quantity > $stock) {

          throw new Exception('商品' . $goods_name . '库存不足', 9005);

      }

      return true;

  }

  /**
   * 删除商品
   *
   * @param array $data
   * @param int $data.goods_id
   *
   * @return int $num
   */
  public function delGoods($data) {
  
    $goodsId = $data['goods_id'];

    /**
     * 删除商品主表数据
     */
    self::remove($goodsId, false);

    /**
     * 删除商品sku数据
     */
    GoodsSkuSv::remove($goodsId, false);

    /**
     * 删除商品图片
     */
    GoodsImagesSv::remove($goodsId, false);

    /**
     * 删除商品属性
     */
    GoodsAttributeSv::batchRemove(array( 'goods_id' => $goodsId ), false);

    /**
     * 删除商品属性
     */
    GoodsAttributeValueSv::batchRemove(array( 'goods_id' => $goodsId ), false);
  
  }

}
