<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Service\Crm\MemberAccountSv;
use App\Service\Poss\PosSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberLevelSv;
use App\Service\Crm\MemberCardSv; 
use App\Interfaces\Crm\IMember;
use App\Model\Member;
use Core\Service\CurdSv;
use App\Service\System\ShortMessageSv;
use App\Service\System\ConfigSv;
use App\Exception\MemberException;
use App\Exception\ErrorCode;
use App\Library\RedisClient;
use App\Exception\PossException;
use App\Model\MemberIncreaseByDate;

/**
 * 会员信息类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-13
 */
class MemberSv extends BaseService implements IMember {

  use CurdSv;

  /**
   * 会员每日新增统计表
   */
  public function memberIncrease($data) {

    return MemberIncreaseByDate::all($data);

  }

  /**
   * 会员信息包含字段
   */

  CONST MEMBER_FIELDS = array(
  
    'member_name', 
    
    'member_level', 
    
    'memo', 
    
    'reference'
  
  );

  /**
   * 用户基本信息包含字段
   */

  CONST USER_FIELDS = array(
  
    'user_name', 
    
    'user_password', 

    'user_headimg', 
    
    'real_name', 
    
    'nick_name', 
    
    'birthday', 
    
    'location', 
    
    'sex'
  
  );

  /**
   * pos用户更新字段mapping
   */
  CONST POS_MAPPING_FIELDS = array(

    'sDocEntry' => 'pos_id',

    'sVIPName' => 'member_name',

    'sSex' => 'sex',

    'sMobile' => 'user_tel',

    'sWXName' => 'nick_name',

    'iBirthMon' => 'birth_month',

    'iBirthDayA' => 'birth_day',

    'sPhone' => 'phone',

    'sIDCard' => 'identity_card_number',

    'sAddress' => 'address',

    'dBirthday' => 'birthday',

    'sEmail' => 'email',

    'sMemo' => 'memo',

    'sWXOpenID' => 'wx_openid',

    'sHealImgURL' => 'user_headimg'
  
  );

  /**
   * 获取用户粉丝列表
   */
  public function getFansList($data) {

    $user_info = UserSv::getUserByToken($data['token']);

    $condition['reference'] = $user_info['hidden_identity'];

    return UserSv::queryList($condition, 'user_headimg,nick_name,reg_time', $data['order'], $data['page'], $data['page_size']);

  }

  /**
   * 添加会员信息
   */
  public function addMember($data) {
    
    if ($data['way'] == 1 && $data['token']) {

      $user_info = UserSv::getUserByToken($data['token']);

      $condition['uid'] = $user_info['uid'];

    }

    unset($data['way']);

    unset($data['token']);

    try{

      return self::add($data);

    } catch (\Exception $e){

      throw new MemberException(ErrorCode::MemberSv['ADD_RETURN_MSG'], ErrorCode::MemberSv['ADD_RETURN_CODE']);

    }

  }

  /**
   * 获取会员列表
   */
  public function getList($condition) {
    
    if ($condition['way'] == 1 && $condition['token']) {

      $user_info = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $user_info['uid'];

    }

    unset($condition['way']);

    unset($condition['token']);

    return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

  }

  /**
   * 获取会员信息
   * @param int $condition['status'] 是否合并会员数据 1-否 2-是
   */
  public function getDetail($condition) {

    $status = $condition['status'];

    unset($condition['status']);
    
    if ($condition['way'] == 1 && $condition['token']) {

      $user_info = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $user_info['uid'];

    }

    unset($condition['way']);

    unset($condition['token']);

    $list = Member::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

    $info = $list[0];

    if ($info && $user_info && $status == 2) {

      $info = array_merge($info, $user_info);

    }

    $memberLevel = MemberLevelSv::findOne($info['member_level']);

    if ($memberLevel) {

      $info = array_merge($info, $memberLevel);

      $info_member_card = MemberCardSv::findOne($memberLevel['card_id']);

      if ($info_member_card) {

        $info['card_url'] = $info_member_card['img_url'];

      }

    }

    return $info;

  }

  /**
   * 获取会员总数
   */
  public function getCount($condition) {

    return self::queryCount($condition);

  }

  /**
   * 修改会员信息
   *
   * @modify by Meroc Chen <398515393@qq.com> 2018-01-01
   * 
   * 修改内容：更新会员信息成功后，同步缓存的工作由会员接口自行维护，而不是调用UserSv来维护,
   *           因此不需要判断需要更新的缓存集合是member_info 还是 admin_info，这样更新不同模
   *           块用户的逻辑不会互相干扰.
   */
  public function edit($data) {

    if ($data['uid'] && $data['way'] == 2) {

      $uid = $data['uid'];
    
    } else if ($data['token']) {

      /**
       * 通过token获取缓存会员数据，获取数据失败会抛出异常
       */

      $user = UserSv::getUserByToken($data['token']);

      $uid = $user['uid'];

    }


    /**
     * 修改会员信息包括 会员基本信息（member）和 用户基本信息（user），需要分别处理
     * 1. 修改member
     * 2. 修改user
     */

    /**
     * 开启事务处理
     */ 

    /**
     * 更新会员信息
     */

    $memberUpdate = array();

    foreach(MemberSv::MEMBER_FIELDS as $field) {

      (isset($data[$field]) && !empty($data[$field])) ? $memberUpdate[$field] = $data[$field] : null;

    }

    if ($memberUpdate['member_name']) {
    
      $memberUpdate['member_name'] = iconv('UTF-8', 'GBK', $memberUpdate['member_name']);
    
    }

    $mupdate = 0;
  
    !empty($memberUpdate) ? $mupdate = self::update($uid, $memberUpdate) : null;


    /**
     * 更新用户基本信息
     */

    $userUpdate = array();

    foreach(MemberSv::USER_FIELDS as $field) {
    
      (isset($data[$field]) && !empty($data[$field])) ? $userUpdate[$field] = $data[$field] : null;
    
    }

    $uupdate = 0;

    !empty($userUpdate) ? $uupdate = UserSv::update($uid, $userUpdate) : null;

    /**
     * 判断是否有更新
     */

    if ($mupdate || $uupdate) {

      /**
       * 更新数据缓存
       */

      $updated = array_merge($user, $userUpdate, $memberUpdate);

      $updated['uid'] = $uid;
      
      //RedisClient::set('member_info', $data['token'], $updated);

      return $uupdate ? $uupdate : $mupdate;
    
    } else {
    
      return 0;
    
    }

  }

  /**
   * 会员登录
   */
  public function login($data) {

    $data['type'] = 3;
    
    $data['module'] = 1;
    
    return UserSv::userLogin($data);

  }

  /**
   * 小程序注册
   */
  public function register($data) {

    // 获取解密后的明文
    $info_user_wechat = self::decryptData($data);

    $info_user = UserSv::getUserByToken($data['token']);

    $result['status'] = true;

    if ($info_user_wechat['purePhoneNumber']) {

      $result['phone'] = $info_user_wechat['purePhoneNumber'];

      $data_user['user_tel'] = $info_user_wechat['purePhoneNumber'];

      $data_user['user_tel_bind'] = 1;

    }

    $data_user['nick_name'] = $data['nickName'];
    
    $data_user['user_headimg'] = $data['avatarUrl'];

    $data_user['sex'] = $data['gender'];

    $data_user['location'] = '';

    if ($data['country']) {

      $data_user['location'] .= $data['country'] . ' ';

    }

    if ($data['province']) {

      $data_user['location'] .= $data['province'] . ' ';

    }

    if ($data['city']) {

      $data_user['location'] .= $data['city'];

    }

    $sVIPName = '微信会员';

    if ($data['member_name']) {

      $data_member['member_name'] = $data_user['real_name'] = $sVIPName = $data['member_name'];

      $data_member['uid'] = $info_user['uid'];

      self::edit($data_member);

    }

    UserSv::update($info_user['uid'], $data_user);

    if (IS_POSS === 1 && $info_user_wechat['purePhoneNumber']) {

      $where_poss_member['sMobile'] = $info_user_wechat['purePhoneNumber'];

      $info_poss_member = PosSv::getMemberInfo($where_poss_member);

      if (!$info_poss_member['sCardID']) {

        // 顾客姓名，长度不超过30
        $data_poss['sVIPName'] = $sVIPName;

        // 获取会员卡号
        $data_poss['sCardID'] = $info_use['card_id'];

        // 获取会员卡类
        // "卡类编码": 1,
        // "卡类名称": "95折会员卡"

        // "卡类编码": 2,
        // "卡类名称": "90折会员卡"

        // "卡类编码": 3,
        // "卡类名称": "积分卡"

        // "卡类编码": 4,
        // "卡类名称": "储值卡"
        $data_poss['sTypeID'] = 4;

        if ($data['gender'] == 2) {

          $sex_name = '女士';

        } else {

          $sex_name = '先生';

        }

        $data_poss['sSex'] = $sex_name;

        $data_poss['sMobile'] = $info_user_wechat['purePhoneNumber'];

        $data_poss['sWXOpenID'] = $info_user['wx_openid'];

        $data_poss['sWXName'] = $data['nickName'];

        $data_poss['iBirthMon'] = '0';
        
        $data_poss['iBirthDayA'] = '0';

        $data_poss['sPhone'] = '';

        $data_poss['sIDCard'] = '';

        $data_poss['sAddress'] = '';

        $data_poss['dBirthday'] = '';

        $data_poss['sEmail'] = '';

        $data_poss['sMemo'] = '';

        $data_poss['sShpCode']  = '';

        $data_poss['sReCardID'] = '';
        
        // 同步添加poss会员
        $info_poss_user = PosSv::addUser($data_poss);

        if ($info_poss_user['Status'] == -1) {

          throw new MemberException(ErrorCode::MemberSv['ADD_POSS_USER_RETURN_MSG'], ErrorCode::MemberSv['ADDADD_POSS_USER_RETURN_CODE'], $info_poss_user['Status'].'|'.$info_poss_user['Description']);

        }

      }

    }

    return $result;

  }

  /**
   * 检验数据的真实性，并且获取解密后的明文.
   * @param string $encryptedData 加密的用户数据
   * @param string $iv 与用户数据一同返回的初始向量
   * @param string $session_key 会话密钥
   * @param string $appid 小程序appid
   * @param array
   */
  public function decryptData($data) {

    $encryptedData = $data['encryptedData'];

    $iv = $data['iv'];

    if (!$data['appid']) {

      $appid = ConfigSv::getConfigValueByKey('ruixuan_mini_appId');

    } else {

      $appid = $data['appid'];

    }

    $session_key = $data['session_key'];

    if (strlen($session_key) != 24) {

      throw new MemberException(ErrorCode::MemberSv['MINI_APPS_SESSION_KEY_RETURN_MSG'], ErrorCode::MemberSv['MINI_APPS_SESSION_KEY_RETURN_CODE']);

    }

    $aesKey = base64_decode($session_key);

        
    if (strlen($iv) != 24) {

      throw new MemberException(ErrorCode::MemberSv['MINI_APPS_VI_RETURN_MSG'], ErrorCode::MemberSv['MINI_APPS_VI_RETURN_CODE']);

    }

    $aesIV = base64_decode($iv);

    $aesCipher = base64_decode($encryptedData);

    $result = openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

    $dataObj=json_decode( $result );

    if ( $dataObj == NULL ) {

      throw new MemberException(ErrorCode::MemberSv['MINI_APPS_DECODE_RETURN_MSG'], ErrorCode::MemberSv['MINI_APPS_DECODE_RETURN_CODE']);

    }
    if ( $dataObj->watermark->appid != $appid ) {

      throw new MemberException(ErrorCode::MemberSv['MINI_APPS_APPID_RETURN_MSG'], ErrorCode::MemberSv['MINI_APPS_APPID_RETURN_CODE']);

    }

    return json_decode( $result, true );

  }

  public function findByUid($uid) {
  
    $member = self::all(array('uid' => $uid));

    return $member[0];
  
  }

  /**
   * 根据手机号查找会员信息
   *
   * @param string $mobile
   *
   * @return array $user
   */
  public function findByMobile($mobile) {
  
    $user = UserSv::findByMobile($mobile);

    if (empty($user)) {

      return null;
    
    }

    $member = self::findByUid($user['uid']);

    if (empty($member)) {
    
      return null;

    }

    return array_merge($member, $user);
  
  }

  /**
   * 更新支付码
   *
   * @param array $data
   * @param string $data[].token 用户令牌
   *
   * @return array
   */
  public function updatePayCode($data) {
  
    $user = UserSv::getUserByToken($data['token']);

    $codes = self::dynamicPayCode($user['uid']);

    $acct = MemberAccountSv::findOne(array('uid' => $user['uid']));

    /**
     * 更新用户账户的动态支付码
     */

    MemberAccountSv::update(

      $acct['id'],

      array(

        'card_id_qr_code' => $codes['card_id_qr_code'], 

        'bar_code' => $codes['bar_code']
      
      )

    );

    return $codes;
  
  }

  /**
   * 动态生成会员支付码（包括二维码，条形码）
   *
   * @param int $uid
   *
   * @return array 
   */
  public function dynamicPayCode($uid) {

    $info_member_account = MemberAccountSv::findOne(array('uid'=>$uid));

    $payCode = self::generatePayCode($uid);

    $info = array(
    
      'valid_time' => 300,
    
      'card_id_qr_code' => \App\qrCode($payCode, true),

      'bar_code' => \App\barCode($payCode, 2, 66, array(1,1,1), true),

      'pay_code' => $payCode

    );

    return $info;

  }

  public static function generatePayCode($uid, $card_id = '') {

    $tms = str_replace(array('-', ':', ' '), '', date('Y-m-d H:i:s'));

    if (!$card_id) {

      $info_member_account = MemberAccountSv::findOne(array('uid'=>$uid));

      $card_id = $info_member_account['card_id'];

    }

    $code = $card_id . substr($tms, 4, 8);

    $clen = strlen($code);

    $tmpCode = '';

    for($i = 0; $i < $clen; $i++) {
    
      $dec = $code[$i];

      switch($dec) {
      
        case '1':

          $tmpCode .= '3';

        break;

        case '2':

          $tmpCode .= '5';

        break;
      
        case '3':
      
          $tmpCode .= '9';

        break;

        case '4':

          $tmpCode .= '0';

        break;

        case '5':

          $tmpCode .= '8';

        break;

        case '6':

          $tmpCode .= '4';

        break;

        case '7':

          $tmpCode .= '7';

        break;

        case '8':

          $tmpCode .= '6';

        break;

        case '9':

          $tmpCode .= '1';

        break;

        case '0':

          $tmpCode .= '2';

        break;

      }
    
    }

    $tmpCode = strrev($tmpCode);

    $newCode = '';

    for($k = 0; $k < $clen; $k+=2) {
    
      $newCode .= $tmpCode[$k + 1] . $tmpCode[$k];
    
    }

    return $newCode;
  
  }

  /**
   * 计算会员增长数量
   *
   */
  public function caculateNewMembersByDate($data) {
  

  
  }

}
