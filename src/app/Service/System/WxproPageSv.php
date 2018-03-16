<?php
namespace App\Service\System;

use Core\Service\CurdSv;
use App\Service\BaseService;
use App\Interfaces\System\IWxproPage; use App\Service\System\WxproPageConfigSv;

/**
 * 微信小程序页面
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-07
 */
class WxproPageSv extends BaseService implements IWxproPage {

  use CurdSv;

  /**
   * 获取crm微信小程序的页面
   *
   * @param array $data
   *
   * @return array $result
   */
  public function getCrmPage($data) {
  
    $queryOptions = array(
    
      'active' => 1
    
    );

    if ($data['page_code']) {
    
      $queryOptions['page_code'] = $data['page_code'];
    
    }

    return self::all($queryOptions);
  
  }

  /**
   * 获取crm微信小程序的页面和页面配置
   * 
   * @param array $data
   * 
   * @return array $result
   */
  public function getCrmPageBoundConfigs($data) {
  
    $pages = self::getCrmPage($data);
  
    $configs = WxProPageConfigSv::getCrmPageConfigs($data);

    $pageConfigs = array();

    foreach($pages as $page) {
    
      $pageConfigs[$page['page_code']] = $page;
    
    }

    foreach($configs as $config) {

      $code = $config['page_code'];

      if (!$pageConfigs[$code]) {

        continue;
    
      }
    
      is_array($pageConfigs[$code]['configs']) ? null : $pageConfigs[$code]['configs'] = array();

      $pageConfigs[$code]['configs'][$config['attr_code']] = $config;
    
    }

    return $pageConfigs;

  }

  /**
   * 查询页面列表
   *
   * @param array $params
   *
   * @return array $list
   */
  public function getPageList($params) {
  
    return self::all($params); 
  
  }

  /**
   * 新增页面
   *
   * @param array $data
   * @param string $data.mini_code 小程序编码
   * @param string $data.page_name 页面名称
   * @param string $data.page_code 页面编码
   * @param string $data.page_url  页面路径
   * @param string $data.module    所属模块
   * @param int $data.active       有效标志
   *
   * @return int num 添加条数
   */
  public function addPage($data) {

    $data['created_at'] = date('Y-m-d H:i:s');
  
    return self::add($data);
  
  }

}
