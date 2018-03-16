<?php namespace App\Service\Crm;

use App\Interfaces\Crm\IShareRecord;
use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Library\RedisClient;
use App\Model\ShareRecord;
use App\Library\WxBizDataCrypt;

/**
 * 分享记录
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-20
 */
class ShareRecordSv extends BaseService {

  use CurdSv;

  /**
   * 新增分享记录
   *
   * @param array $data
   *
   * @author Meroc Chen <398515393@qq.com> 2017-11-20
   */
  public function add($data) {
  
    $member = RedisClient::get('member_info', $data['token'], true);

    $module = $data['module'];

    $newData = array(
    
      'user_key' => $member['hidden_identity'],

      'openid' => $member['wx_openid'],

      'module' => $module,

      'share_ticket' => $data['shareTicket'],

      'session_key' => $data['sessionKey'],

      'ext_2' => $data['iv'],

      'remark' => $data['remark'],

      'ext_1' => $data['encodeData'],

      'created_at' => date("Y-m-d H:i:s"),

      'share_code' => $data['share_code']
    
    );

    return ShareRecord::add($newData);
  
  }

  /**
   * 获取用户分享实例代码
   *
   * @param string $shareCode
   *
   * @return string $userkey
   */
  public function getShareEntityCode($shareCode) {
  
    return self::findOne(array('share_code' => $shareCode));
  
  }

}
