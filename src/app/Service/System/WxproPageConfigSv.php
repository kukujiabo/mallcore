<?php
namespace App\Service\System;

use App\Interfaces\System\IWxproPageConfig;
use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Exception\WxproPageConfigException;
use App\Exception\ErrorCode;

/**
 * 微信小程序页面配置服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-07
 */
class WxproPageConfigSv extends BaseService implements IWxproPageConfig {

  use CurdSv;

  /**
   * 返回crm小程序页面配置项
   *
   * @param array $data
   * 
   * @return array $result
   */
  public function getCrmPageConfigs($data) {

    $queryOptions = array(
    
      'module' => 'wxpro_crm',

      'active' => 1
    
    );

    $fields = array('page_code', 'attr_name', 'value', 'value_text', 'value_type');

    $result = self::all($queryOptions, implode(',', $fields));

    return $result;
  
  }

  /**
   * 修改页面配置信息
   *
   * @param array $data
   *
   * @return array $result
   */
  public function updatePageConfigs($data) {
  
    $id = $data['id'];

    $update = array();

    $data['type'] == 2 ? $update['value_text'] = $data['content'] : $update['value'] = $data['content'];

    if(self::update($id, $update)) {

      return self::findOne($id);
    
    } else {
    
      throw new WxproPageConfigException(
        ErrorCode::WxproPageConfigSv['UPDATE_ERR_MSG'],
        ErrorCode::WxproPageConfigSv['UPDATE_ERR_CODE'],
        $id
      );
    
    }
  
  }

}
