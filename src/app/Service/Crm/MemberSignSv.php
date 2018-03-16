<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IMemberSign;
use App\Model\MemberSign;
use Core\Service\CurdSv;
use PhalApi\Exception;
use App\Service\Crm\UserSv;
use App\Model\ActionEvent;
use App\Service\Wechat\WechatTemplateMessageSv;

/**
 * 会员签到类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class MemberSignSv extends BaseService implements IMemberSign {

  use CurdSv;

  /**
   * 添加会员签到信息
   */
  public function addMemberSign($data) {

    $info_user = UserSv::getUserByToken($data['token']);

    $data['uid'] = $info_user['uid'];

    unset($data['token']);

    $list = MemberSign::queryList($data, 'sign_time', 'sign_time desc, id desc', 0, 1);

    $today = strtotime(date('Y-m-d'));

    $tomorrow = strtotime(date('Y-m-d') . " +1 day");

    if ($list[0]['sign_time'] >= $today && $list[0]['sign_time'] < $tomorrow) {

      throw new Exception('今天已签到', 2901);

    }

    $data['sign_time'] = time();

    $rs = self::add($data);

    /*****/

    $datetime = date('Y-m-d H:i:s');

    try {

      $register = array(
      
        'short_id' => 'OPENTM405956810',

        'mobile' => $info_user['user_tel'],

        'contents' => "first\$\$今日已签到！||keyword1\$\$连续签到 1 天||keyword2\$\${$datetime}||remark\$\$赠送10积分 "

      );

      WechatTemplateMessageSv::generalMessage($register);

    } catch (\Exception $e) {
    
    
    }

    return $rs;

  }

  /**
   * 获取会员签到列表
   */
  public function getList($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

      unset($condition['token']);

    }

    unset($condition['way']);

    return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

  }

  /**
   * 获取会员签到信息
   */
  public function getDetail($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

      unset($condition['token']);

    }

    unset($condition['way']);

    $list = MemberSign::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

    return $list[0];

  }

  /**
   * 获取会员签到总数
   */
  public function getCount($condition) {

    return self::queryCount($condition);

  }

  /**
   * 修改会员签到信息
   */
  public function edit($data) {

    if ($data['id']) {

      $condition['id'] = $data['id'];

      unset($data['id']);

    }

    return self::batchUpdate($condition, $data);

  }

  /**
   * 获取用户签到奖励规则
   *
   * @param string $token
   *
   * @return 
   */
  public function getSignRewards($token) {
  
    $member = UserSv::getUserByToken($token);

    $rewards = array();
  
    /**
     * 读取签到配置
     */
    $queryOptions = array(

      'operation' => 'App.MemberSign.Add',

      'active' => 1
    
    );

    $actions = ActionEvent::all($queryOptions);

    $points = array();

    $coupons = array();

    foreach($actions as $action) {

      if (!$action['last_long']) {

        $time = time();

        $vstart = strtotime($action['validate_start']);

        $vend = strtotime($action['validate_end']);
      
        if ($vstart['validate_start'] > $time || $vend['validate_end'] > $time) {
        
          continue;
        
        }
      
      }
    
      if ($action['module'] == 'point') {
      
        array_push($points, $action['data']);
      
      }
      if ($action['module'] == 'coupon') {
      
        array_push($coupons, $action['data']);
      
      }
    
    }

    /**
     * 获取积分奖励规则
     */
    $pointRewards = UserObtainPointsRuleSv::getMatchedPointRule($member['member_level'], $points);

    if (is_array($pointRewards)) {

      $rewards = array_merge($rewards, $pointRewards);
    
    }


    /**
     * 获取优惠券奖励规则
     */
    $couponRewards = CouponGrantRuleSv::getMatchedCouponRule($member['member_level'], $coupons);

    if (is_array($couponRewards)) {
    
      $rewards = array_merge($rewards, $couponRewards);
    
    }

    return $rewards;

  }

}
