<?php
namespace App\Service\Commodity;

use App\Service\BaseSerivce;
use Core\Service\CurdSv;

/**
 * 商品收藏服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class GoodsFavoriteSv extends BaseService {

  use CurdSv;

  /**
   * 添加收藏
   *
   * @param int gid
   * @param int uid
   *
   * @return int id
   */
  public function addFavorite($gid, $uid) {
  
    $data = array(
    
      'goods_id' => $gid,

      'uid' => $uid,

      'created_at' => date('Y-m-d H:i:s'),

      'updated_at' => date('Y-m-d H:i:s'),
    
    );
  
    return self::add($data);
  
  }


  /**
   * 根据用户id获取列表内容
   *
   * @param int uid
   *
   * @return list
   */
  public function getFavoriteGoodsListByUid($uid) {
  
    $condition = array(
    
      'uid' => 'uid'
    
    );

    $data = self::all($condition, 'id desc');

    if (empty($data)) {
    
      return $data;
    
    }

    $goods = array();

    foreach($data as $good) {
    
      array_push($goods, $good['goods_id']);
    
    }

    $goodsCondition = array(
    
      'goods_id' => implode(',', $goods);
    
    ); 

    return GoodsSv::all($goodsCondition);
  
  }

  public function remove($gid, $uid) {

    $condition = array(
    
      'goods_id' => $gid,

      'uid' => $uid
    
    );
  
    $favorite = self::findOne(arra
  
  
  }

}
