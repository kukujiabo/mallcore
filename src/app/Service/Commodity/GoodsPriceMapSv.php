<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 价格体系服务
 * @desc 价格体系服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class GoodsPriceMapSv extends BaseService {

  use CurdSv;

  /**
   * 添加体系规则
   *
   */
  public function addRule($params) {
  
    $params['created_at'] = date('Y-m-d H:i:s');

    return self::add($params);
  
  }


}
