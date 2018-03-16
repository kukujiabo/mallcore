<?php
namespace App\Service\Crm;

use App\Interfaces\Crm\IMemberCard;
use App\Service\BaseService;
use App\Model\MemberCard;
use Core\Service\CurdSv;

/**
 * 会员卡接口服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-08
 */
class MemberCardSv extends BaseService implements IMemberCard {

  use CurdSv; 

  /**
   * 查询列表
   *
   * @param array $data
   *
   * @return array $list
   */
  public function getList($data) {
  
    $condition = array(
    
      'id' => $data['id'],

      'card_name' => $data['card_name'],

      'card_code' => $data['card_code'],

      'card_seq' => $data['card_seq'],

      'card_type' => $data['card_type']
    
    );

    return self::queryList($condition, '*', 'id desc', $data['page'], $data['page_size']);
  
  }

  /**
   * 添加
   */
  public function addMemberCard($data){

    $data['created_at'] = date("Y-m-d H:i:s");

    return self::add($data);

  }

  /**
   * 修改
   */
  public function edit($data){

    $id = $data['id'];

    unset($data['id']);

    return self::update($id, $data);

  }

}
