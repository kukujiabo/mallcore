<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Interfaces\Crm\IMemberLevel;

/**
 * 会员等级服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-07
 */
class MemberLevelSv extends BaseService implements IMemberLevel {

  use CurdSv;

  /**
   * 新增会员等级
   *
   * @param array $data
   *
   * @return int id
   */
  public function addLevel($data) {
  
    $newLevel = array(
      'level_name' => $data['level_name'],
      'icon' => $data['icon'],
      'card_url' => $data['card_url'],
      'level_num' => $data['level_num'],
      'state' => $data['state'],
      'desc' => $data['desc'],
      'create_time' => date('Y-m-d H:i:s')
    );
  
    return self::add($newLevel);
  
  }


}
