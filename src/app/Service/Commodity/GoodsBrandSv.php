<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 商品品牌服务类
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-26
 */
class GoodsBrandSv extends BaseService {

  use CurdSv;

  /**
   * 添加品牌
   *
   * @param array $data
   *
   * @return int id
   */
  public function addBrand($data) {

    $data['brand_name'] = iconv('UTF-8', 'GBK', $data['brand_name']);

    $data['created_at'] = date('Y-m-d H:i:s');

    $data['introduction'] = addslashes($data['introduction']);

    return self::add($data);
  
  }

  /**
   * 更新品牌
   *
   * @param int id
   * @param array data
   *
   * @return int num
   */
  public function updateBrand($id, $data) {

    if ($data['brand_name']) {
    
      $data['brand_name'] = iconv('UTF-8', 'GBK', $data['brand_name']);
    
    }
  
    return self::update($id, $data);
  
  }

  /**
   * 查询品牌列表
   *
   * @param string brandName
   * @param string brandCode
   * @param int all
   * @param int page
   * @param int pageSize
   *
   * @return array list
   */
  public function listQuery($brandName, $brandCode, $status, $index, $all = 0, $page = 1, $pageSize = 20) {

    $options = array();

    if (isset($brandName)) $options['brand_name'] = $brandName;

    if (isset($brandCode)) $options['brand_code'] = $brandCode;

    if (isset($status)) $options['brand_state'] = $status;

    if (isset($index)) $options['index_show'] = $index;

    if (!$all) {
    
      return self::queryList($options, '*', 'id desc', $page, $pageSize);
    
    } else {
    
      return self::all($options);
    
    }
  
  }

  /**
   * 删除品牌
   *
   * @param int id
   *
   * @return boolean true/false
   */
  public function removeBrand($id) {
  
    return self::remove($id);
  
  }

}
