<?php
namespace App\Service\Crm;

use App\Interfaces\Crm\IMemberRecharge;
use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Pay\PaySv;
use App\Exception\PayException;
use App\Exception\ErrorCode;
use PhalApi\Exception\BadRequestException;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Crm\MemberRechargeRuleSv;
use App\Service\Wechat\WechatTemplateMessageSv;
use App\Service\Poss\PosSv;

/**
 * 用户充值操作服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-26
 */ 
class MemberRechargeSv extends BaseService implements IMemberRecharge {

  use CurdSv;

  /**
   * 充值订单标记号
   */
  CONST ORDER_SIGN = '100'; 

  /**
   * 充值标志
   */
  CONST CHARGE_SIGN = 4;

  /** 
   * 充值备注
   */
  CONST CHARGE_MARK = '用户充值';

  /**
   * 生成充值订单号
   */
  public function createOrderNo() {

    $timestamp = time() . '';

    $seq = substr($timestamp, 7, 9) . substr($timestamp, 0, 3) . substr($timestamp, 3, 4);
  
    return MemberRechargeSv::ORDER_SIGN . $seq . rand(1000, 9999);
  
  }

  /**
   * 生成充值订单
   *
   * @param int $uid
   * @param float $money
   * @param int $type
   * @param int $channel
   *
   * @return array $order
   */
  public function createRechargeOrder($uid, $money, $type, $channel = 1, $rid = 0) {

    /**
     * 根据uid获取获取用户充值规则
     */
    if (!$rid) {

      $rule = MemberRechargeRuleSv::calChargeMoneyByRule($uid, $money);

    } else {
    
      $rule = MemberRechargeRuleSv::findOne($rid);

    }

    $order = array(
      'recharge_money' => $money,
      'reward_money' => $rule['reward_money'],
      'uid' => $uid,
      'order_no' => self::createOrderNo(),
      'create_time' => date('Y-m-d H:i:s'),
      'is_pay' => 0,
      'channel' => $channel,
      'status' => 0,
      'type' => $type,
      'rule_code' => $rule['id'],
      'special_type' => $rule['special_type']
    );

    self::add($order);

    return $order;
  
  }


  /**
   * 用户充值
   *
   * @param array $data
   * 
   * @return mixed 
   */ 
  public function doRecharge($data) {

    /**
     * 读取用户信息
     */
    $member = UserSv::getUserByToken($data['token']);

    if ($member) { //缓存用户数据

      /**
       * 生成订单
       */
      $order = self::createRechargeOrder($member['uid'], $data['money'], $data['pay_type'], $data['channel'], $data['rule_id']);

      /**
       * 构造预支付数据
       */
      $payment = array(
        'pay_type' => $data['pay_type'], //由前台传入支付类型
        'out_trade_no' => $order['order_no'],
        'money' => $data['money'],
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'open_id' => $member['wx_openid'],
        'nonce_str' => md5($member['wx_openid'] . time()),
        'device_info' =>  $data['device_info'], //由前台传入设备信息
        'body' => "{$member['nick_name']} 充值 {$data['money']}"
      );

      /**
       * 调用微信预支付
       */
      return PaySv::wechatPayAction($payment);

    } else { //抛出未登录异常
    
      throw new BadRequestException(ErrorCode::PaySv['NO_LOGIN_MSG'], ErrorCode::PaySv['NO_LOGIN_CODE']);
    
    }

  }

  /**
   * 用户充值成功后回调
   *
   * @param string $orderNo
   *
   * @return boolean true/false
   */
  public function rechargeNotify($orderNo) {

    $recharge = self::findByOrderNo($orderNo);

    if (!$recharge) { 

      /**
       * 充值订单不存在则抛出异常
       */

      throw new PayException(
        ErrorCode::PaySv['NOTIFY_ORDER_NOT_FOUND_MSG'],
        ErrorCode::PaySv['NOTIFY_ORDER_NOT_FOUND_CODE'],
        $orderNo
      );
    
    } else if ($recharge['is_pay'] && $recharge['status']) {
    
      /**
       * 充值订单标记已完成则返回
       */

      return;
    
    }

    /**
     * 更新充值记录信息
     */

    self::updateByOrderNo($orderNo, array('is_pay' => 1, 'status' => 1));

    /**
     * 更新用户账户信息
     */
    $uid = $recharge['uid'];
    
    $money = $recharge['recharge_money'] + $recharge['reward_money'];

    // 获取会员账户信息
    $info_member_account = MemberAccountSv::findOne(array('uid'=>$uid));

    $array['sCardID'] = $info_member_account['card_id'];

    $array['iAddValue'] = $recharge['recharge_money'];

    $array['iGiftValue'] = $recharge['reward_money'];

    $array['sMemo'] = '线上微信充值';

    // 余额充值同步到线下
    PosSv::increaseBalance($array);

    MemberAccountSv::addAccountMoney($uid, $money, MemberRechargeSv::CHARGE_SIGN, $orderNo, MemberRechargeSv::CHARGE_MARK);

    /**
     * 临时发送微信消息
     */
    $changeMoney = $recharge['recharge_money'] + $recharge['reward_money'];

    $restMoney = $info_member_account['balance'] + $changeMoney;

    try {

    $register = array(
    
      'short_id' => 'TM00141',

      'card_id' => $info_member_account['card_id'],

      'contents' => "first\$\$您好,您已成功进行会员卡充值！||accountType\$\$微信充值||amount\$\${$changeMoney}||result\$\$成功||remark\$\$ "

    );

    WechatTemplateMessageSv::generalMessage($register);

    } catch (\Exception $e) {
    
    }
  
  }

  /**
   * 根据订单号查找充值记录
   *
   * @param string $orderNo
   *
   * @return mixed $data
   */
  public function findByOrderNo($orderNo) {
  
    return self::findOne(array('order_no' => $orderNo));
  
  }
  
  /**
   * 根据订单号修改充值记录
   *
   * @param string $orderNo
   * @param array $data
   *
   * @return int number
   */
  public function updateByOrderNo($orderNo, $data) {
  
    return self::batchUpdate(array('order_no' => $orderNo), $data);
  
  }

}
