<?php
namespace App\Model;

/**
 * [模型层] 会员账户
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-06
 */
class MemberAccount extends BaseModel {

  protected $_queryOptionRule = array(
    'point' => 'range',
    'balance' => 'range',
    'coin' => 'range',
    'member_cunsum' => 'range',
    'member_sum_point' => 'range',
    'card_id' => 'in'
  );

  protected $_updateOptionRule = array(
    'point' => 'accumulate',
    'balance' => 'accumulate'
  );

  /**
   * 根据用户id更新用户账户信息
   *
   * @param int $uid
   * @param int $data
   *
   * @return boolean true/false
   */
  protected function updateByUid($uid, $data) {
  
    $acct = self::number(array('uid' => $uid));

    if (!$acct) {
    
      self::add(array('uid' => $uid, 'created_at' => date('Y-m-d H:i:s')));

    }

    return self::batchUpdate(array('uid' => $uid), $data);
  
  }

  /**
   * 根据用户id获取帐户信息
   *
   * @param int $uid
   *
   * @return array $data
   */
  protected function findByUid($uid) {
  
    $acct = self::all(array('uid' => $uid ));
  
    if (empty($acct)) {
    
      return null;
    
    }

    return $acct[0];

  }


}
