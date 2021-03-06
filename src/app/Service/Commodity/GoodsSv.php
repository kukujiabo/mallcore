<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Service\Crm\UserSv;
use App\Service\Crm\ManagerSv;
use App\Service\Commodity\GoodProviderCosSv;
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
use App\Service\Takeaway\OrderTakeOutSv;
use App\Service\Takeaway\OrderTakeOutGoodsSv;

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

      $img_data = json_decode($params['images'], true);

      $data = array();

      if (!isset($data['picture']) && isset($img_data[0])) {

          $data['picture'] = $img_data[0];

      }

      $data['thumbnail'] = $params['thumbnail'];
      $data['brand_id'] = $params['brand_id'];
      $data['goods_name'] = $params['goods_name'];
      $data['shop_id'] = $params['shop_id'];
      $data['is_sku'] = $params['is_sku'];
      $data['sign'] = $params['sign'];
      $data['signature'] = $params['signature'];
      $data['goods_number'] = $params['goods_number'];
      $data['category_id'] = $params['category_id'];
      $data['state'] = $params['state'];
      $data['price'] = $params['price'];
      $data['max_price'] = $params['max_price'];
      $data['market_price'] = $params['market_price'];
      $data['goods_weight'] = $params['goods_weight'];
      $data['stock'] = $params['stock'];
      $data['introduction'] = $params['introduction'] ? $params['introduction'] : '';
      $data['description'] = $params['description'] ? $params['description'] : '';
      $data['no_code'] = $params['no_code'] ? $params['no_code'] : '';
      $data['sort'] = $params['sort'] ? $params['sort'] : '';
      $data['index_show'] = $params['index_show'];
      $data['cities'] = $params['cities'];

      if ($params['signature']) {
      
        $signatures = explode(' ', $params['signature']);
      
        foreach($signatures as $goodSignature) {
        
          if (!GoodsSignatureSv::findOne(array('signature' => $goodSignature))) {
          
            GoodsSignatureSv::add(array(

              'signature' => $goodSignature, 

              'created_at' => date('Y-m-d H:i:s')

            )); 
          
          }
        
        }
      
      }

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
   * 添加商品（包含SKU）
   */
  public function addSkuGoods($params) {

      $img_data = json_decode($params['images'], true);

      foreach ($img_data as $v) {

        if ($v['is_cover'] == 2) {

          $data['picture'] = $v['img'];

          break;

        }

      }

      if (!isset($data['picture']) && isset($img_data[0])) {

        $data['picture'] = $img_data[0];

      }

      $data['provider_code'] = $params['provider_code'];
      $data['thumbnail'] = $params['thumbnail'];
      $data['goods_name'] = $params['goods_name'];
      $data['is_sku'] = $params['is_sku'];
      $data['shop_id'] = $params['shop_id'];
      $data['goods_number'] = $params['goods_number'];
      $data['category_id'] = $params['category_id'];
      $data['sign'] = $params['sign'];
      $data['signature'] = $params['signature'];
      $data['state'] = $params['state'];
      $data['price'] = $params['price'];
      $data['max_price'] = $params['max_price'];
      $data['market_price'] = $params['market_price'];
      $data['goods_weight'] = $params['goods_weight'];
      $data['stock'] = $params['stock'];
      $data['introduction'] = $params['introduction'];
      $data['description'] = $params['description'];
      $data['brand_id'] = $params['brand_id'] ? $params['brand_id'] : '';
      $data['sort'] = $params['sort'] ? $params['sort'] : '';
      $data['index_show'] = $params['index_show'];
      $data['cities'] = $params['cities'];
      

      if ($params['signature']) {
      
        $signatures = explode(' ', $params['signature']);
      
        foreach($signatures as $goodSignature) {
        
          if (!GoodsSignatureSv::findOne(array('signature' => $goodSignature))) {
          
            GoodsSignatureSv::add(array(

              'signature' => $goodSignature, 

              'created_at' => date('Y-m-d H:i:s')

            )); 
          
          }
        
        }
      
      }

      $params['goods_id'] = $goods_id = self::addGoods($data);

      self::imgDispose($img_data, $goods_id);

      if ($params['is_sku'] == 1) {

        self::attrDispose($params);

      }

      return $goods_id;

  }

  /**
   * 处理商品图片
   */
  public function imgDispose($img_data, $goods_id) {

      GoodsImagesSv::batchUpdate(array('goods_id' => $goods_id, 'status'=> 1), array('status'=>2,'is_cover'=>1));

      foreach ($img_data as $key => $v) {

          $where['goods_id'] = $v['goods_id'] = $goods_id;

          $where['img'] = $v['img'];

          $info_img = GoodsImagesSv::findOne($where);

          if ($info_img) {

              $data = $v;

              $data['id'] = $info_img['id'];

              $data['status'] = 1;

              $data['sort'] = $key;

              $img[$info_img['id']] = GoodsImagesSv::edit($data);

          } else {

              $v['sort'] = $key;

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

      $attribute = json_decode($params['attribute'], true);

      $data_attribute_value_all = array();

      $attribute_array = array();

      GoodsAttributeSv::batchUpdate(array('goods_id'=>$goods_id, 'active'=>1), array('active'=>2));

      GoodsAttributeValueSv::batchUpdate(array('goods_id'=>$goods_id, 'active'=>1), array('active'=>2));

      foreach($attribute as $key => $v) {

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

              $data_attribute['active'] = 1;

              // 添加商品规格
              $attrId = GoodsAttributeSv::addGoodsAttribute($data_attribute);

              $attr_id = $arr['attr']['attr_id'][] = $attrId;

          }

          $attr_array['attr_id'] = $attr_id;

          foreach ($v['attr_value'] as $key => $vo) {
              
              $data_attribute_value = array();

              $data_attribute_value['attr_value'] = $vo;

              $data_attribute_value['attr_id'] = $attr_id;

              $data_attribute_value['goods_id'] = $goods_id;

              $info_goods_attribute_value = GoodsAttributeValueSv::findOne($data_attribute_value);

              if ($info_goods_attribute_value) {

                $data_attribute_value['attr_value_id'] = $attr_value_id = $info_goods_attribute_value['attr_value_id'];

                $data_attribute_value['active'] = 1;

                $data_attribute_value['sort'] = $key + 1;

                // 修改商品规格项
                $arr['attr_value'][$attr_id][$attr_value_id] = GoodsAttributeValueSv::edit($data_attribute_value);

              } else {

                $data_attribute_value['active'] = 1;

                $data_attribute_value['sort'] = $key;

                $data_attribute_value['sort'] = $key + 1;

                  // 添加商品规格项
                $attrValueId = GoodsAttributeValueSv::addGoodsAttributeValue($data_attribute_value);

                $attr_value_id = $arr['attr_value'][$attr_id][] = $attrValueId;

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

          $v['shop_id'] = 0;

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

          $v['attr_value_items_format'] = json_encode($attr_val);

          if ($v['sku_id']) {

              $data_sku = $v;

              $data_sku['active'] = 1;

              $data_sku['cities'] = implode(',', $data_sku['checkList']);

              GoodsSkuSv::edit($data_sku);

              $arr['sku'][$info_sku['sku_id']] = $v['sku_id'];

          } else {

              $v['shop_id'] = 0;

              $v['market_price'] = 0;

              $v['sku_name'] = $v['sku_name'];

              $v['active'] = 1;

              $v['cities'] = implode(',', $v['checkList']);
              
              unset($v['checkList']);

              $skuId = GoodsSkuSv::addGoodsSku($v);

              $arr['sku']['sku_id'][] = $skuId;

          }

      }

      GoodsSkuSv::removeAll(array('goods_id' => $goods_id, 'active' => 2));

      return $arr;

  }

  /**
   * 获取列表
   */
  public function getList($condition) {

    if (isset($condition['category_id'])) {
    
      $categoryId = $condition['category_id'];
    
      $categories = GoodsCategorySv::all(array('pid' => $categoryId));

      if (!empty($categories)) {

        $categoryIds = array();
      
        foreach($categories as $category) {
        
          array_push($categoryIds, $category['category_id']); 
        
        }

        array_push($categoryIds, $categoryId);
      
        $ids = implode(',', $categoryIds);

        $condition['category_id'] = $ids;

      }

    }

    if ($condition['way'] != 2) {

      if ($condition['token']) {
      
        $user = UserSv::getUserByToken($condition['token']);

        $manager = ManagerSv::findOne(array('phone' => $user['user_tel']));

        if ($manager && $manager['pid'] > 0) {
        
          $goodcos = GoodsProviderCosSv::all(array('provider_id' => $manager['pid'], 'sku_id' => 0)); 

          $gids = array();

          foreach($goodcos as $gc) {
          
            array_push($gids, $gc['goods_id']);
          
          }

          $condition['goods_id'] = implode(',', $gids);
        
        }

      }

    }

    unset($condition['way']);

    if ($condition['no_code']) {
    
      $goodsSku = GoodsSkuSv::findOne(array('no_code' => $condition['no_code']));

      unset($condition['no_code']);

      if ($goodsSku) {
      
        $condition['goods_id'] = $goodsSku['goods_id'];
      
      }
    
    }


    if ($condition['city_code']) {
    
      $condition['cities'] = $condition['city_code'];
    
      unset($condition['city_code']);
    
    }

    $goods = GoodsViewSv::getList($condition);

    if ($manager) {

      foreach($goodcos as $gc) {
      
        foreach($goods['list'] as $key => $good) {
        
          if ($gc['goods_id'] == $good['goods_id']) {
          
            $goods['list'][$key]['price'] = $gc['sale_price'];
          
          }
        
        }
      
      }
    
    
    } elseif ($condition['cities'] && $condition['user_level']) {

      foreach($goods['list'] as $key => $good) {
      
        $priceRule = GoodsPriceMapSv::findOne(array(
        
          'goods_id' => $good['goods_id'],

          'city_code' => $condition['cities'],

          'user_level' => $condition['user_level'],

          'sku_id' => 0
        
        ));
      
        if ($priceRule) {
        
          $goods['list'][$key]['price'] = $priceRule['price'];
        
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

    $good = self::findOne($condition);

    if ($condition['city_code'] && $condition['user_level']) {
    
      $priceRule = GoodsPriceMapSv::findOne(array(
      
        'city_code' => $condition['city_code'],
        
        'user_level' => $condition['user_level'],

        'goods_id' => $good['goods_id'],

        'sku_id' => 0
      
      ));

      if ($priceRule) {
      
        $good['price'] = $priceRule['price'];
      
      }
    
    }

    /**
     * 查询品牌
     */
    $good['brand'] = GoodsBrandSv::findOne(array('id' => $good['brand_id']));

    /**
     * 查询分类
     */
    $good['category'] = GoodsCategorySv::findOne(array('category_id' => $good['category_id']));

    /**
     * 查询商品主图
     */
    $good['goods_image'] = GoodsImagesSv::all(array('goods_id' => $good['goods_id'], 'status' => 1 ));


    return $good;

  }

  /**
   * 新增
   */
  public function addGoods($data) {

      $data['create_time'] = date("Y-m-d H:i:s");

      return self::add($data);

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

    if (!$goodsId) {
    
      return false; 

    }

    /**
     * 删除商品主表数据
     */
    self::remove($goodsId, false);

    /**
     * 删除商品sku数据
     */
    GoodsSkuSv::batchRemove(array('goods_id' => $goodsId), false);

    /**
     * 删除商品价格
     */

    GoodsPriceMapSv::batchRemove(array('goods_id' => $goodsId));

    /**
     * 删除商品图片
     */
    GoodsImagesSv::remove(array('goods_id' => $goodsId), false);

    /**
     * 删除商品属性
     */
    GoodsAttributeSv::batchRemove(array( 'goods_id' => $goodsId ), false);

    /**
     * 删除商品属性
     */
    GoodsAttributeValueSv::batchRemove(array( 'goods_id' => $goodsId ), false);
  
  }

  public function getRecommendGoods($data) {
  
    $order = OrderTakeOutSv::findOne(array('sn' => $data['sn']));
  
    $ogds = OrderTakeOutGoodsSv::all(array('order_take_out_id' => $order['id']));

    foreach($ogds as $ogd) {
    
      array_push($goodsId, $ogd['goods_id']);
    
    }

    $ogoods = self::all(array('goods_id' => implode(',', $goodsId)));

    $goodsSign = array();

    foreach($ogoods as $ogood) {
    
      array_push($goodsSign, $ogood['signature']);
    
    }

    $goods = self::all(array('signature' => implode(',', $goodsSign)));

    $returnGoods = array();

    foreach($goods as $key => $good) {
    
      if (!in_array($good['goods_id'], $goodsId)) {
      
        array_push($returnGoods, $good);
      
      }
    
    }
  
    return $returnGoods;

  }

}
