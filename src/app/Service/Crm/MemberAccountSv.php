<?php

namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IMemberAccount;
use App\Model\MemberAccount;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use PhalApi\Exception\InternalServerErrorException;
use App\Service\Crm\MemberAccountRecordSv;
use App\Library\RedisClient;
use App\Exception\MemberAccountException;
use App\Exception\ErrorCode;
use App\Service\Crm\MemberRechargeSv;
use App\Service\Poss\PosSv;

/**
 * 会员账户
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-06
 */
class MemberAccountSv extends BaseService implements IMemberAccount {

    use CurdSv;

    /**
     * 添加会员账户
     */
    public function addMemberAccount($data) {

        try{

            return self::add($data);

        } catch (\Exception $e){

            throw new InternalServerErrorException('新增失败', 1);

        }

    }

    /**
     * pos修改卡号同步线上
     */
    public function posUpdateMemberCardId ($params) {

      $where['user_tel'] = $params['mobile'];

      $info_user = UserSv::findOne($where);
      
      if (!$info_user) {

        throw new MemberAccountException(ErrorCode::MemberAccountSv['MINU_ACCT_OFFLINE_MONEY_NO_MEMBER_MSG'], ErrorCode::MemberAccountSv['MINU_ACCT_OFFLINE_MONEY_NO_MEMBER_CODE']);

      }

      $data['uid'] = $info_user['uid'];

      $data['card_id'] = $params['card_id'];

      // 生成新的条形码图片
      $data['bar_code'] = \App\barCode(MemberSv::generatePayCode($info_user['uid'], $data['card_id']), true);

      return self::updates($data);

    }

    /**
     * 更新
     */
    public function updates ($data) {

        if ($data['id']) {

            $condition['id'] = $data['id'];

            unset($data['id']);

        }

        if ($data['uid']) {

            $condition['uid'] = $data['uid'];

            unset($data['uid']);

        }

        if ($data['shop_id']) {

            $condition['shop_id'] = $data['shop_id'];

            unset($data['shop_id']);

        }
        
        $info = MemberAccount::batchUpdate($condition, $data);

        if ($info) {

            if ($condition['uid']) {

                $info_token = RedisClient::get('member_info', $condition['uid'], true);

                if ($info_token) {

                    $info_user = RedisClient::get('member_info', $info_token['token'], true);

                    if ($info_user) {

                        $info_user = array_merge($info_user, $data);

                        if ($info_user) {

                            RedisClient::set('member_info', $info_token['token'], $info_user);

                        }

                    }

                }

            }

            return $info;

        } else {

            return false;

        }

    }

    /**
     * 获取会员数据（poss余额和积分）
     */
    public function getPossDetail($condition) {

      if ($condition['token']) {

        $info_user = UserSv::getUserByToken($condition['token']);

      }

      if ($condition['uid']) {

        $info_user['uid'] = $condition['uid'];

      }

      $info_member_account = self::findOne(array('uid'=>$info_user['uid']));

      if ($info_member_account['card_id']) {

        $info_poss_member = PosSv::getMemberInfo(array('sCardID'=>$info_member_account['card_id']));

        $info_member_account['balance'] = $info_poss_member[0]['卡内余额'];

        $info_member_account['point'] = $info_poss_member[0]['卡内积分'];

      }

      return $info_member_account;

    }

    /**
     * 获取详情
     */
    public function getDetails ($condition) {

        if ($condition['way'] == 1 && $condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['uid'] = $info_user['uid'];

        }

        unset($condition['way']);

        unset($condition['token']);

        $list = MemberAccount::queryList($condition,'*','id desc',0,20);

        $info = $list[0];

        // $imges = API_ROOT . '/qr_code_img/' . $info['card_id_qr_code'];

        if ($info['card_id'] && !$info['card_id_qr_code']) {

          // 生成二维码图片
          $info['card_id_qr_code'] = \App\qrCode($info['card_id'], true);

          if ($info['card_id_qr_code']) {

            self::batchUpdate($info);

          }

        }

        if ($info['card_id'] && !$info['bar_code']) {

          // 生成条形码图片
          $info['bar_code'] = \App\barCode(MemberSv::generatePayCode($info_user['uid']), true);

          if ($info['bar_code']) {

            self::batchUpdate($info);

          }

        }

        return $info;

    }

    /**
     * 新增用户积分
     *
     * @param int $uid
     * @param int $point
     *
     * @return boolean true/false
     */
    public function addPoints($uid, $point) {

      MemberAccount::updateByUid($uid, array('point' => "+{$point}"));

    }

    /**
     * 新增用户余额
     *
     * @param int $uid
     * @param int $money
     *
     * @return boolean true/false
     */
    public function addMoney($uid, $money) {

      return MemberAccount::updateByUid($uid, array('balance' => "+{$money}"));
    
    }

    /** 
     * 扣除用户积分
     *
     * @param int $uid
     * @param int $point
     *
     * @return boolean true/false
     */
    public function minuPoints($uid, $point) {

      /**
       * todo 先判断用户积分是否充足
       */
      $acct = MemberAccount::findByUid($uid);

      if (floatVal($acct['point']) < floatVal($point)) {
      
        return false;

      }

      return MemberAccount::updateByUid($uid, array('point' => "+-{$point}"));

    }

    /**
     * 扣除用户余额
     *
     * @param int $uid
     * @param int $point
     *
     * @return boolean true/false
     */
    public function minuMoney($uid, $money) {

      /**
       * todo 先判断用户余额是否充足
       */
      $acct = MemberAccount::findByUid($uid);

      if (floatVal($acct['balance']) < floatVal($money)) {
      
        return false;

      }

      $rest = floatVal($acct['balance']) - floatVal($money);
    
      $result = MemberAccount::updateByUid($uid, array('balance' => $rest));


      if ($result) {
      
        return $rest;
      
      } else {
      
        return false;

      }

    }

    /**
     * 用户线下充值
     *
     * @param stirng $mobile
     * @param float $money
     *
     * @return array $data
     */
    public function offlineChargeMoney($mobile, $money, $remark) {

      /**
       * 通过手机号获取会员信息
       */
      $member = MemberSv::findByMobile($mobile);

      /**
       * 构造线下充值订单
       */
      $order =  MemberRechargeSv::createRechargeOrder($member['uid'], $money, 2, 2);

      /**
       * 修改帐户余额，添加记录
       */
      if (self::addAccountMoney($member['uid'], $money, 11, 0, $remark)) {
      
        $acct = MemberAccount::findByUid($member['uid']);

        MemberRechargeSv::updateByOrderNo($order['order_no'], array('status' => 1, 'is_pay' => 1));

        $result = array('orderId' => $order['order_no'], 'balance' => $acct['balance']);

        return $result;
      
      } else {
      
        throw new MemberAccountException();
      
      }
    
    }

    /**
     * 新增用户帐户金额，包含日志，记录操作
     *
     */
    public function addAccountMoney($uid, $money, $from, $dataId, $remark = '') {
    
      /**
       * 修改帐户余额
       */
      self::addMoney($uid, $money);
    
      /**
       * 新增帐户修改记录
       */
      $record = array(
        'uid' => $uid,
        'account_type' => 2,
        'sign' => '1',
        'number' => $money,
        'from_type' => $from,
        'data_id' => $dataId,
        'text' => $remark,
        'create_time' => date('Y-m-d H:i:s')
      );

      return MemberAccountRecordSv::add($record);

    }

    /**
     * 会员线下使用余额消费接口
     *
     * @param string $mobile
     * @param float $money
     * @param string $orderId
     * @param sring $remark
     *
     * @return boolean true/false
     */
    public function offlineUseAccountMoney($mobile, $money, $orderId, $remark = '') {

      $member = MemberSv::findByMobile($mobile);

      if (empty($member)) {
      
        throw new MemberAccountException(
          ErrorCode::MemberAccountSv['MINU_ACCT_OFFLINE_MONEY_NO_MEMBER_MSG'],
          ErrorCode::MemberAccountSv['MINU_ACCT_OFFLINE_MONEY_NO_MEMBER_CODE'],
          $orderId
        );
      
      }
    
      return self::minuAccountMoney($member['uid'], $money, 10, $orderId, $remark);
    
    }

    /**
     * 减少用户帐户积分，包含日志，记录操作
     *
     * @param int $uid
     * @param float $point
     * @param int $from
     * @param string $dataId
     * @param string $remark
     *
     * return boolean true/false
     */
    public function minuAccountPoints($uid, $point, $from, $dataId, $remark = '') {

      $rest;
    
      if ($rest = self::minuPoints($uid, $point)) {

        $record = array(
          'uid' => $uid,
          'account_type' => 1,
          'sign' => -1,
          'number' => $money,
          'from_type' => $from,
          'data_id' => $dataId,
          'text' => $remark,
          'create_time' => date('Y-m-d H:i:s')
        );
      
        MemberAccountRecordSv::add($record);

        return $rest;
      
      } else {
      
        throw new MemberAccountException(
          ErrorCode::MemberAccountSv['MINU_ACCT_POINT_LESS_MSG'],
          ErrorCode::MemberAccountSv['MINU_ACCT_POINT_LESS_CODE'],
          "from: {$from}|dateId: {$dataId}"
        );
      
      }
    
    }

    /**
     * 减少用户帐户金额，包含日志，记录操作
     *
     * @param int $uid
     * @param float $money
     * @param int $from
     * @param string $dataId
     * @param string $remark
     *
     * return boolean true/false
     */
    public function minuAccountMoney($uid, $money, $from, $dataId, $remark = '') {

      $rest;
    
      if ($rest = self::minuMoney($uid, $money)) {

        $record = array(
          'uid' => $uid,
          'account_type' => 2,
          'sign' => -1,
          'number' => $money,
          'from_type' => $from,
          'data_id' => $dataId,
          'text' => $remark,
          'create_time' => date('Y-m-d H:i:s')
        );
      
        MemberAccountRecordSv::add($record);

        return $rest;
      
      } else {
      
        throw new MemberAccountException(
          ErrorCode::MemberAccountSv['MINU_ACCT_MONEY_LESS_MSG'],
          ErrorCode::MemberAccountSv['MINU_ACCT_MONEY_LESS_CODE'],
          "from: {$from}|dateId: {$dataId}"
        );
      
      }
    
    }

    /**
     * 新增用户帐户积分
     *
     * @param int $uid 
     * @param int $point
     * @param int $from
     * @param string $dataId
     * @param string $remark 
     *
     * @return boolean true/false
     */
    public function addAccountPoints($uid, $point, $from, $dataId, $remark = '') {

      self::addPoints($uid, $point);
    
      /**
       * 新增帐户修改记录
       */
      $record = array(
        'uid' => $uid,
        'account_type' => 1,
        'sign' => '1',
        'number' => $point,
        'from_type' => $from,
        'data_id' => $dataId,
        'text' => $remark,
        'create_time' => date('Y-m-d H:i:s')
      );

      return MemberAccountRecordSv::add($record);
    
    }

}
