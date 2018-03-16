<?php
namespace App\Service\Crm; 

use App\Service\BaseService;
use App\Interfaces\Crm\IUserPoint;
use App\Service\Crm\UserObtainPointsRuleSv;
use App\Model\UserPoint;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberAccountSv;
use PhalApi\Exception\InternalServerErrorException;
use App\Service\Poss\PosSv;
use App\Exception\PossException;
use App\Exception\ErrorCode;

/**
 * 用户积分操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-09-18
 */
class UserPointSv extends BaseService implements IUserPoint {

  use CurdSv;

  /**
   * 发放积分
   *
   * @param int $rid 发放规则id
   * @param int $uid 会员id
   *
   * @return true/false
   */
  public function grant($rid, $uid) {

    if (IS_POSS) {
    
      return self::posHoldPointGrant($rid, $uid);
    
    } else {
    
      return self::onlineHoldPointGrant($rid, $uid);
    
    }
  
  }

  /**
   * pos管控积分（积分存储定义在pos上时生效）
   */
  protected static function posHoldPointGrant($rid, $uid) {

    $rule = UserObtainPointsRuleSv::findActiveOne($rid);

    $info_member_account = MemberAccountSv::findOne(array('uid'=>$uid));
  
    $array['sAddType'] = $rule['name'];

    $array['sCardID'] = $info_member_account['card_id'];

    $array['iChangeValue'] = $rule['points'];

    $array['sMemo'] = '线上增加积分';

    // 积分获取同步到线下
    $result = json_decode(PosSv::setPoint($array), true);

    if ($result && $result['Status'] == 1) {

      return 1;
    
    } else {
    
      throw new PossException(

        ErrorCode::PossSv['SYNC_POS_POINT_FAILED_MSG'],

        ErrorCode::PossSv['SYNC_POS_POINT_FAILED_CODE'],

        $rid + '|' + $uid
      
      );
    
    }

  }

  /**
   * 线上管控积分（积分存储定义在线上时生效）
   */
  protected static function onlineHoldPointGrant($rid, $uid) {

    $rule = UserObtainPointsRuleSv::findActiveOne($rid);

    /**
     * 指定过期时间
     */
    $expireDate = strtotime($rule['expire_date']) > 0 ? $rule['expire_date'] : date('Y-m-d 23:59:59', time() + intval($rule['duration']) * 24 * 60 * 60);

    /**
     * 构造新的积分实例
     */
    $insertData = array(
      'uid' => $uid,
      'status' => 1,
      'full_points' => $rule['points'],
      'duration' => $rule['duration'],
      'priority' => $rule['priority'],
      'expire_date' => $expireDate,
      'full_points' => $rule['points'],
      'rule_id' => $rule['id'],
      'created_at' => date('Y-m-d H:i:s')
    );

    /**
     * 新增积分实例，并修改用户账户里的积分数值
     */
    self::add($insertData);
  
    return MemberAccountSv::addAccountPoints($uid, $rule['points'], 5, $rid, $rule['name']);

  }

  /**
   * 新增
   */
  public function addPoint ($data) {

    $data['created_at'] = date("Y-m-d H:i:s");

    try{

      return self::add($data);

    } catch (\Exception $e){

      throw new InternalServerErrorException('新增失败', 1);

    }

  }

  /**
   * 编辑
   */
  public function edit($data) {

    if ($data['id']) {
    
      $condition['id'] = $data['id'];

    }

    unset($data['id']);

    return UserPointSv::batchUpdate($condition, $data);
  
  }

  /**
   * 获取列表
   */
  public function getList($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['way']);

    return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);
  
  }

  /**
   * 获取总数
   */
  public function getCount($condition) {
    
    return self::queryCount($condition);

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['way']);
    
    $list = UserPoint::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

    return $list[0];

  }


  /**
   * 1.使用用户积分
   * 
   * @param string $rule       积分使用规则
   * @param string $uid        用户id 
   * @param stromg $point      用户积分
   * @param string $channel    渠道
   * @param string $channelId  渠道id
   * @param string $action     请求操作
   * @param string $objectId   对象id（订单，小游戏）
   *
   * @return boolean true/false
   */
  public function usePoint($rule, $uid, $points, $channel, $channelId, $action, $objectId, $remarks){}

}
