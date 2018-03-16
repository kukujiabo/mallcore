<?php
namespace App\Service\System;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 图片配置服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-28
 */
class ConfigImageSv extends BaseService {

  use CurdSv;

  /**
   * 添加图片配置
   *
   * @param array data
   *
   * @return int id
   */
  public function addImage($data) {
  
    $data['created_at'] = date('Y-m-d H:i:s');

    $data['updated_at'] = date('Y-m-d H:i:s');

    return self::add($data);
  
  }

  /**
   * 编辑图片配置
   *
   * @param int id
   * @param array data
   *
   * @return int num
   */
  public function editImage($id, $data) {

    $data['updated_at'] = date('Y-m-d H:i:s');

    return self::update($id, $data);
  
  }

  /**
   * 获取图片列表
   *
   * @param array data
   *
   * @return array list
   */
  public function getList($data) {
  
    $options = array();

    if (isset($data['module'])) $options['module'] = $data['module'];

    if (isset($data['type'])) $options['type'] = $data['type'];

    if (isset($data['state'])) $options['state'] = $data['state'];

    return self::all($options, 'display_order desc');
  
  }

}
