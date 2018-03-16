<?php
namespace App\Service\Wechat; 

use App\Exception\WechatException;
use App\Exception\ErrorCode;
use App\Service\Crm\ChannelSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberSv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Crm\MemberWechatSv;
use App\Service\System\ConfigSv;
use App\Service\Poss\PosSv;

/**
 * 微信场景事件处理
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-13
 */
class WechatSceneSv {

  /**
   * 处理微信消息所属场景
   *
   * @param string $openId 
   * @param string $eventKey
   * @param string $event
   *
   * @return 
   */
  public function handleScene($openId, $eventKey, $event) {
  
    /**
     * 1.获取事件场景值
     * 2.根据事件类型选择不同的处理方法
     */
    $sceneId = null;

    if ($eventKey) {

      $scene = explode('qrscene_', $eventKey);

      $sceneId = $scene[1];

    }

    switch ($event) {

      case 'subscribe':

        /**
         * 用户关注事件
         */

        self::eventSubscribe($openId, $sceneId);

        break;

      case 'unsubscribe':

        /**
         * 用户取消事件
         */

        self::eventUnsubscribe($openId, $sceneId);

        break;

      case 'SCAN':

        /**
         * 用户扫码事件
         */

        self::eventScan($openId, $sceneId);

        break;

      case 'text':


        break;

    
    }
  
  }

  /**
   * 处理关注事件
   *
   * @param string $openId
   * @param string $sceneId
   */
  public function eventSubscribe($openId, $sceneId) {
  
    /**
     * 读取公众号配置
     */
    $appid = ConfigSv::getConfigValueByKey('wps_appid');

    $secret = ConfigSv::getConfigValueByKey('wps_appsecret');

    /**
     * 获取用户unionid
     */
    $access_token = WechatUtilsSv::getAccessToken('access_token_rongyi', $appid, $secret);

    $unionResponse = WechatUtilsSv::getUnionid($openId, $access_token);

    $data = array();

    if ($unionResponse) {
    
      $data = array(

        'subscribe' => $unionResponse['subscribe'],

        'nickname' => $unionResponse['nickname'],

        'sex' => $unionResponse['sex'],

        'language' => $unionResponse['language'],

        'city' => $unionResponse['city'],

        'province' => $unionResponse['province'],

        'country' => $unionResponse['country'],

        'subscribe_time' => $unionResponse['subscribe_time'],

        'remark' => $unionResponse['remark'],

        'groupid' => $unionResponse['groupid'],

        'tagid_list' => implode(',', $unionResponse['tagid_list']),

        'unionid' => $unionResponse['unionid'],

        'openid' => $openId

      );
    
    } else {

      /**
       * 无法获取用户unionid则抛出异常
       */
    
      throw new WechatException(

        ErrorCode::WechatSceneSv['WECHAT_GET_UNION_ID_MSG'], 

        ErrorCode::WechatSceneSv['WECHAT_GET_UNION_ID_CODE']
      
      );
    
    }

    /** 
     * 根据openid查询微信会员信息
     */
    $memberWx = MemberWechatSv::findOne(array('openid' => $openId));

    foreach($data as $k => $v) {
    
      if ((!isset($v) && $v != 0) || empty($v)) {

        unset($data[$k]);
      
      }
    
    }

    if ($memberWx) {

      /**
       * 若公众号会员信息已存在（之前关注过，后来取消了），则更新公众号会员信息
       */
    
      $res = MemberWechatSv::update($memberWx['id'], $data);

      /**
       * todo 同步pos重新关注
       */
    
    } else {

      /**
       * 若公众号会员信息不存在，则添加新的公众号会员信息
       */

      /**
       * 获取相关渠道
       * 根据场景值，有效状态，有效期等
       */
      $channel = ChannelSv::getActiveOneByScene($sceneId);
    
      if ($channel) {

        $data['channel'] = $channel['id'];

        $data['channel_type'] = $channel['type'];

      } else {
      
        $data['channel'] = 'auto';

        $data['channel_type'] = 0;
      
      }

      $data['subscribe'] = 1;

      $data['created_at'] = date('Y-m-d H:i:s');

      $res = MemberWechatSv::add($data);

      if ($res) {

        /**
         * 新增公众号会员数据后，查询该公众号会员是否已经是正式会员(已绑定手机号)
         */
        $user = UserSv::findOne(array('wx_unionid' => $data['unionid']));

        if ($user && $user['user_tel']) {

          /**
           * 是正式会员
           */

          // 获取账户信息
          $acct = MemberAccountSv::findOne(array('uid'=>$user['uid']));

          // 获取会员信息
          $member = MemberSv::findOne(array('uid'=>$user['uid']));

          $posUserData['sDocEntry'] = $acct['pos_id'];

          $posUserData['sVIPName'] = $member['member_name'];

          $posUserData['sSex'] = $user['sex'] == 1 ? '先生' : '女士';

          $posUserData['sMobile'] = $user['user_tel'];

          $posUserData['sWXOpenID'] = $openId;
          
          $posUserData['sHealImgURL'] = $user['user_headimg'];

          /**
           * 修改pos会员信息
           */

          PosSv::updateMemberInfo($posUserData);
        
        } else {

          /**
           *  todo 不是正式会员，需要推送一条消息到界面上，提示用户立即绑定手机号
           */
        
        }
      
      
      } else {
      
        /**
         * 新增公众号会员失败
         */
      
      }
    
    }
  
  }

  /**
   * 处理扫码事件
   *
   * @param string $openId
   * @param string $sceneId
   */
  public function eventScan($openId, $sceneId) {
  

  
  
  }

  /**
   * 取消关注事件
   *
   * @param string $openId
   * @param string $sceneId
   */
  public function unsubscribe($openId, $sceneId) {
  
  
  
  }

}
