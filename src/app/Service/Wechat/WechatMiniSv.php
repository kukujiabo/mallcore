<?php
namespace App\Service\Wechat;

use App\Service\BaseService;
use Core\Service\CurdSv; 
/**
 * 微信小程序配置服务 
 * @author Meroc Chen <398515393@qq.com> 2017-12-28
 */
class WechatMiniSv extends BaseService {

  use CurdSv;

  /**
   * 查询小程序列表
   *
   * @param array $params
   *
   * @return array $list
   */
  public function getList($params) {
  
    $conditions = array();

    $params['mini_name'] ? $conditions['mini_name'] = $params['mini_name'] : null;

    $params['mini_code'] ? $conditions['mini_code'] = $params['mini_code'] : null;

    $params['mini_appid'] ? $conditions['mini_appid'] = $params['mini_appid'] : null;

    return self::queryList($conditions, $params['fields'], $params['order'], $params['page'], $params['pageSize']);
  
  }

  /**
   * 编辑小程序信息
   *
   * @param array $params
   *
   * @return int num
   */
  public function edit($params) {
  
    return self::update($params['id'], $params);

  }

}
