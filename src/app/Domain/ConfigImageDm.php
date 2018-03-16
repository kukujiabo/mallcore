<?php
namespace App\Domain;

use App\Service\System\ConfigImageSv;

/**
 * 图片配置处理
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-28
 */
class ConfigImageDm {

  /**
   * 添加图片
   */
  public function addImage($params) {
  
    return ConfigImageSv::addImage($params);
  
  }

  /**
   * 编辑图片
   */
  public function editImage($params) {

    $id = $params['id'];

    unset($params['id']);
  
    return ConfigImageSv::editImage($id, $params);
  
  }

  /**
   * 获取列表
   */
  public function getList($params) {
  
    return ConfigImageSv::getList($params);
  
  }

  /**
   * 删除图片
   */
  public function remove($params) {
  
    return ConfigImageSv::remove($params['id']);
  
  }

}
