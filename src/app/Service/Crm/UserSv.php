<?php 
namespace App\Service\Crm; 

use App\Service\BaseService;
use App\Service\Crm\MemberSv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Pay\PaySv;
use App\Interfaces\Crm\IUser;
use App\Library\Http;
use App\Model\User;
use App\Library\RedisClient;
use Core\Service\CurdSv;
use App\Service\System\ShortMessageSv;
use App\Service\Admin\UserAdminSv;
use App\Service\Admin\UserAdminGroupSv;
use App\Service\Admin\UserGroupSv;
use App\Service\Admin\UserGroupJurisdictionSv;
use App\Service\Admin\UserJurisdictionSv;
use App\Service\System\ModuleSv;
use App\Exception\ErrorCode;
use App\Service\Poss\PosSv;
use App\Service\System\ConfigSv;
use App\Service\Wechat\WechatSv;
use App\Service\Crm\MobileVerifyCodeSv;
use App\Service\Crm\ShareRecordSv;
use App\Service\Crm\ShareAcceptSv;
use App\Exception\UserException;
use App\Service\Crm\MemberWechatSv;
use App\Service\Crm\ChannelSv;
use App\Service\Wechat\WechatUtilsSv;
use App\Service\Wechat\WechatTemplateMessageSv;
use App\Service\Admin\ProviderSv;

/**
 * 用户信息类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-12
 */
class UserSv extends BaseService implements IUser {
  
  use CurdSv;

  /**
   * 1.账号密码授权
   * @param string $username
   * @param string $password
   * @param string $module
   */
  public function acctLogin($username, $password, $module){

    $where['user_name'] = $username;

    $where['user_password'] = MD5($password);

    if ($module == 1) {

        // 前台会员
        $where['is_member'] = 1;

    } else if ($module == 2) {

        // 后台管理员
        $where['is_system'] = 1;

    }

    $info = self::getDetail($where);

    if (empty($info)) {

      throw new UserException(ErrorCode::UserSv['ACCT_PASS_ERR_MSG'], ErrorCode::UserSv['ACCT_PASS_ERR_CODE']);

    }

    if ($module == 2) {

      $info['current_login_time'] = date("Y-m-d H:i:s");

      // 获取后台权限
      $info['jurisdiction'] = self::getAdminJurisdiction($info['uid']);

      $where_admin['uid'] = $where_admin_group['uid'] = $info['uid'];

      // 获取后台管理员信息
      $info_admin = UserAdminSv::findOne($where_admin);

      if ($info_admin) {

        $info = array_merge($info, $info_admin);

      }

      $info['admin_group'] = array();

      // 获取后台管理员关联用户组
      $list_admin_group = UserAdminGroupSv::all($where_admin_group);
      
      if ($list_admin_group) {

        $list_group = array();

        foreach ($list_admin_group as &$v) {

          $where_group['group_id'] = $v['group_id'];

          // 获取后台管理员关联用户组
          $info_group = UserGroupSv::findOne($where_group);
        
          if ($info_group) {

            $list_group[] = $info_group['group_name'];

          }

        }

        unset($v);

        $info['admin_group'] = $list_group;

      }

    }

    if ($info) {

      return self::getToken($info);

    } else {

      return false;

    }

  }

  /**
   * 获取管理员权限
   */
  public function getAdminJurisdiction($uid) {

      $user_admin_where['uid'] = $user_jurisdiction_where['uid'] = $user_admin_group_where['uid'] = $uid;

      $user_admin_list = UserAdminSv::queryList($user_admin_where, '*', '', 0, 200);

      $user_admin_info = $user_admin_list['list'][0];

      $result = array();

      // 启用
      $user_jurisdiction_where['status'] = $user_admin_group_where['status'] = $user_group_jurisdiction_where['status'] = 1;

      $user_jurisdiction_where['deleted_at'] = $user_admin_group_where['deleted_at'] = $user_group_jurisdiction_where['deleted_at'] = 0;

      // 用户权限关联表（针对单一的权限）
      $user_jurisdiction_list = UserJurisdictionSv::all($user_jurisdiction_where, '', 'module_id');

      // 是否为菜单
      $module_where['is_menu'] = 1;

      $module_where['is_dev'] = 0;

      foreach ($user_jurisdiction_list['list'] as $v) {

          if ($v['module_id']) {

              $module_where['module_id'] = $v['module_id'];

              // 权限详情
              $module_list = ModuleSv::queryList($module_where, 'method', '', 0, 10000);

              $module_info = $module_list['list'][0];

              if ($module_info['method'] && !in_array($module_info['method'], $result)) {

                  $result[] = $module_info['method'];

              }

          }

      }

      // 判断是否有权限
      if (empty($user_admin_info)) {

          return $result;

      }

      // 管理员角色
      $user_admin_group_list = UserAdminGroupSv::queryList($user_admin_group_where, 'group_id', '', 0, 10000);

      foreach ($user_admin_group_list['list'] as $v) {

          if ($v['group_id']) {

              $user_group_jurisdiction_where['group_id'] = $v['group_id'];

              // 角色权限
              $user_group_jurisdiction_list = UserGroupJurisdictionSv::queryList($user_group_jurisdiction_where, 'module_id', '', 0, 10000);

              foreach ($user_group_jurisdiction_list['list'] as $vo) {
              
                  if ($vo['module_id']) {

                      $module_where['module_id'] = $vo['module_id'];

                      // 权限详情
                      $module_list = ModuleSv::queryList($module_where, '*', '', 0, 10000);

                      $info = $module_list['list'][0];

                      if ($info['method'] && !in_array($info['method'], $result)) {

                          $result[] = $info['method'];

                      }

                  }

              }

          }

      }

      return $result;

  }
  
  /**
   * 注销登录
   */
  public function logout($data){

    $info_user = RedisClient::get('member_info', $data['token'], true);

    RedisClient::remove('member_info', $info_user['uid']);

    RedisClient::remove('member_info', $data['token']);

    return true;

  }

  /**
   * 2.微信小程序鉴权，判断用户是否已经注册，
   *   若已注册执行登录，未注册执行注册，登
   *   录返回参数带手机号，注册不带手机号。
   *
   * @param string $openId
   *
   * @return array $info
   * @return string $info.mobile
   * @return string $info.token
   */
  public function miniIdentifyAuth($openId, $unionId, $recommend = '') {

    /**
     * 根据用户openid查询用户是否已注册
     */

    $user = self::findOne(array('wx_openid' => $openId));

    if ($user) {

      /**
       * 用户已注册，返回用户信息
       */
    
      return array(
      
        'mobile' => $user['user_tel'],

        'token' => self::getMemberToken($user['uid'])
      
      );
    
    } else {

      /**
       * 用户未注册，为用户注册
       */
    
      $uid = self::miniRegister($openId, $unionId, $recommend);

      return array(
      
        'mobile' => '',

        'token' => self::getMemberToken($uid)
      
      );
    
    }

  }

  /**
   * 3.微信统一登录
   * @param string $unionId 
   */
  public function wechatUnionIdenfityAuth($unionId){

    $where['wx_unionid'] = $unionId;

    return self::logIn($where);

  }

  /**
   * 4.清除用户登录记录
   * @param string $userId
   */
  public function removeAuthorize($userId){

  }

  /**
   * 5.新增用户
   * @param string $data['username'] 用户名
   * @param string $data['password'] 用户密码
   * @param string $data['type']  1 - admin, 2 - member
   * @param string $data['openId'] 微信openid
   * @param string $data['wx_unionid'] 微信wx_unionid
   * @param string $data['channel'] 渠道
   */
  public function addUser($data) {

    if (!$data['wx_openid'] && !$data['wx_unionid']) {

      $data['user_password'] = MD5($data['user_password']);

    }

    if ($data['type'] == 2) {

      $data['is_member'] = 1;

    } elseif ($data['type'] == 1) {

      $data['is_system'] = 1;

    }

    unset($data['type']);

    $data['reg_time'] = date('Y-m-d H:i:s');

    $data['reg_date'] = date('Y-m-d');

    $uid = 0;

    try{

      $uid = self::add($data);

    } catch (\Exception $e){

      throw new UserException(
        
        ErrorCode::UserSv['USER_ADD_RETURN_MSG'], 
        
        ErrorCode::UserSv['USER_ADD_RETURN_CODE']
      
      );

    }

    $data_h['hidden_identity'] = md5($data['reg_time'].$uid);

    self::update($uid, $data_h);

    return $uid;

  }

  /**
   * 6.更新用户信息
   * @param int $userId 用户的uid
   * @param array $data
   */
  public function updateUser($userId, $data){

    $where['uid'] = $userId;

    return self::batchUpdate($where, $data);

  }

  /**
   * 7.根据token获取前台用户信息
   * @param string $token
   */
  public function getUserByToken($token){

    $data['token'] = $token;

    $data['way'] = 1;

    return self::readToken($data);

  }

  /**
   * 根据token获取后台用户信息
   * @param string $token
   */
  public function getAdminToken($token){

    $data['token'] = $token;

    $data['way'] = 2;

    return self::readToken($data);

  }

  /**
   * 获取token信息
   * @param string $way 1-前台 2-后台
   * @param string $token
   */
  public function readToken($data){

    $way = $data['way'];

    if ($way == 2) {

      $key_name = 'admin_info';

    } else {

      $key_name = 'member_info';

    }

    $token = $data['token'];

    if (!$token) {

      throw new UserException(ErrorCode::UserSv['TOKEN_FOUND_MSG'], ErrorCode::UserSv['TOKEN_FOUND_CODE']);

    }

    $info = RedisClient::get($key_name, $token, true);

    $provider = ProviderSv::findOne(array('account' => $info['user_name']));    

    if ($provider) {
    
      $info['provider_id'] = $provider['id'];
    
    } else {

      $info['provider_id'] = 0;

    }

    if (!$info) {

      throw new UserException(ErrorCode::UserSv['TOKEN_RETURN_MSG'], ErrorCode::UserSv['TOKEN_RETURN_CODE']);

    }

    return $info;

  }

  /**
   * 更新缓存
   */
  public function editRedisClient($token) {

    $info = RedisClient::get('member_info', $token, true);

    $info_user = RedisClient::get('member_info', $info['uid'], true);

    if ($info['is_system'] == 1) {

    } elseif ($info['is_member'] == 1) {

      $where['uid'] = $info['uid'];

      $info_member_account = MemberAccountSv::getDetail($where);

      $info_member = MemberSv::getDetail($where);

      $info = array_merge($info, $info_member_account);

      $info = array_merge($info, $info_member);

    }

    $info['login_time'] = $info_token['login_time'] = time();

    RedisClient::set('member_info', $token, $info);

    $data_token['token'] = $token;

    RedisClient::set('member_info', $info['uid'], $info_token);

  }
  
  /**
   * 获取用户信息
   */
  public function getUser($condition){

    $way = $condition['way'];

    unset($condition['way']);

    if ($way == 1) {

      $info = self::getUserByToken($condition['token']);

    } elseif($way == 2) {

      $info = self::getDetail($condition);

    }

    return $info;

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    $list = User::queryList($condition, $condition['fields'], 'uid desc', 0, 1);
    
    $info = $list[0];

    if ($info && $info['uid'] && $info['reg_time'] && !$info['hidden_identity']) {

      $info['hidden_identity'] = $data_h['hidden_identity'] = md5($info['reg_time'].$info['uid']);

      self::update($info['uid'], $data_h);

    }

    return $info;

  }

  /**
   * 微信code登录
   *
   * @param string $code
   *
   * @return
   */
  public function codeLogin($code, $type, $recommend = '') {
  
    $result = '';

    if ($type == 2) {

      /**
       * 获取公众号openid
       */

      $result = WechatUtilsSv::getPubsOpenId($code);

    } elseif ($type == 3) {

      /**
       * 获取小程序openid
       */

      $result = WechatUtilsSv::getMiniOpenId($code);

    }

    /**
     * 获取用户信息失败时，抛出异常
     */

    if (isset($result['errcode']) && $result['errcode'] > 0) {

      throw new UserException(
        
        ErrorCode::UserSv['USER_GAIN_OPENID_RETURN_MSG'], 
        
        ErrorCode::UserSv['USER_GAIN_OPENID_RETURN_CODE'], 
        
        $result['errmsg']
      
      );

    }

    /**
     * 小程序鉴权，执行登录或注册
     *
     * $auth.mobile
     * $auth.token
     */

    $auth = self::miniIdentifyAuth($result['openid'], $result['unionid'], $recommend);

    $response = array(
    
      'token' => $auth['token'],

      'mobile' => $auth['mobile'],

      'session_key' => $result['session_key'],
    
    );

    return $response;
  
  }

  /**
   * 用户统一登录
   *
   * @param array $data
   *
   * 微信code登录
   * @param string $data.code
   * @param string $data.type
   *
   * 账号密码登录
   * @param string $data.username
   * @param string $data.password
   * @param string $data.module
   *
   * @return
   */
  public function userLogin($data) {

    if ($data['code'] && $data['type'] != 1) {

      /**
       * 微信code登录
       */

      return self::codeLogin($data['code'], $data['type'], $data['recommend']);

    } elseif (!empty($data['username']) && !empty($data['password'])) {

      /**
       * 账号密码登录
       */

      return self::acctLogin($data['username'], $data['password'], $data['module']);

    }

  }
  
  /**
   * 获取用户列表
   */
  public function queryUserList($condition){
      
    return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

  }

  /**
   * 8.检查用户登录状态 X
   * @param string $token
   */
  public function checkUserloginStatus($token){

    $member_info = RedisClient::get('member_info', $token, true);

    if ($member_info) {

      return true;

    } else {

      return false;

    }

  }

  /**
   * 9.记录用户登录
   * @param string $userId
   * @param string $ip
   */
  public function addLoginLog($userId, $ip){

    $where['uid'] = $userId;

    $data['current_login_ip'] = $ip;

    $data['current_login_time'] = date('Y-m-d H:i:s');

    return self::update($userId, $data);

  }

  /**
   * 10.记录用户操作
   * @param string $userId
   * @param string $ip
   * @param string $action
   * @param string $func
   * @param string $data
   */
  public function addActionLog($userId, $ip, $action, $func, $data){

  }

  /**
   * 11.检查用户操作权限
   * @param string $userId
   * @param string $module_id
   */
  public function checkActionAuth($userId, $module_id){

  }

  /**
   * 12.禁用用户
   * @param string $userId
   */
  public function lockUser($userId){

    $data['user_status'] = 2;

    return sele::update($userId, $data);

  }

  /**
   * 13.解禁用户
   * @param string $userId
   */
  public function unlockUser($userId){

    $data['user_status'] = 1;

    return sele::update($userId, $data);

  }

  /**
   * 14.通过手机号查询用户是否存在
   * @param string $mobile
   */
  public function checkUserExistByMobile($mobile){

    $where['user_tel'] = $mobile;

    return self::getDetail($where);

  }

  /**
   * 15.检查用户是否绑定微信
   * @param string $userId
   */
  public function checkUserBindWechat($userId){

    $where['uid'] = $userId;

    $where['fields'] = 'wx_openid';

    $info = self::getDetail($where);

    if ($info['wx_openid']) {

      return true;

    } else {

      return false;

    }

  }

  /**
   * 更新用户信息
   * @param array $data
   */
  public function updates($data){
    
    $token = $data['token'];

    $way = $data['way'];

    unset($data['uid']);

    unset($data['token']);

    unset($data['way']);

    if ($way == 1 && $token) {

      $user_info = self::getUserByToken($token);

      $uid = $user_info['uid'];

      $user_info = array_merge($user_info, $data);

    }

    $info = self::update($uid, $data);

    if ($info) {

      if ($way == 1) {

        $name = 'member_info';

      } else {

        $name = 'admin_info';

      }

      $info_token = RedisClient::get($name, $uid, true);

      if ($info_token) {

        $info_user = self::getUserByToken($info_token['token']);

        $user_info = array_merge($user_info, $data);

        RedisClient::set($name, $info_token['token'], $user_info);

      }

    }

    return $info;

  }

  /**
   * 更换手机号
   */
  public function changePhone($data) {

    /**
     * 获取用户token
     */
  
    $info_user = self::getUserByToken($data['token']);
  
    /**
     * 验证短信，若验证失败会抛出异常
     */

    MobileVerifyCodeSv::checkVerifyCode($data['code'], $data['phone']);

    /**
     * 更新用户信息
     */

    $updateUser = array(

      'user_tel' => $data['phone'],
    
    );

    $num = self::update($info_user['uid'], $updateUser);

    /**
     * 更新缓存
     */

    $info_user['user_tel'] = $data['phone'];

    RedisClient::set('member_info', $data['token'], $info_user);

    /**
     * 判断是否需要同步poss
     */

    return $num;
    
  }


  /**
   * 绑定手机，并查看用户的渠道来源
   */
  public function bindingsPhone ($data) {

    $info_user = self::getUserByToken($data['token']);

    /**
     * 验证短信，若验证失败会抛出异常
     */
    
    MobileVerifyCodeSv::checkVerifyCode($data['code'], $data['phone']);

    /**
     * 甄别会员所属渠道，并返回解密数据
     */

    $unionInfo = self::dispatchChannel($data);

    /**
     * 更新会员信息
     */

    $updateUser = array(

      'wx_unionid' => $unionInfo['unionId'],
    
      'sex' => $unionInfo['gender'] == 1 ? 1 : 2,

      'reference' => $unionInfo['channel_code'],

      'reference_type' => $unionInfo['channel_type'],

      'user_tel' => $data['phone'],

      'user_tel_bind' => 1
    
    );

    $uunum = self::update($info_user['uid'], $updateUser);

    $updateMember = array();

    if ($data['member_name']) {

      $updateMember['member_name'] = $data['member_name'];

      $munum = MemberSv::update($info_user['uid'], $updateMember);

    }

    if ($uunum || $munum) {

      /**
       * 更新缓存数据
       */
      RedisClient::set('member_info', $data['token'], array_merge($info_user, $updateUser, $updateMember));

      /**
       * 更新会员pos信息
       * 只在定义了 IS_POSS 为1的情况下操作
       */

      try {

       $register = array(
        
          'short_id' => 'OPENTM207287351',

          'mobile' => $data['phone'],

          'contents' => "first\$\$恭喜您，成为路每家会员！||keyword1\$\${$data['member_name']}||keyword2\$\${$data['phone']}"

        );

        WechatTemplateMessageSv::generalMessage($register);



      } catch (\Exception $e) {
      

      }

      if (IS_POSS) { 

        $acct = MemberAccountSv::findOne(array('uid'=>$info_user['uid']));

        $possUser = array(

          'sWXOpenId' => "",

          'sVIPName' => $data['member_name'],

          'sCardID' => $acct['card_id'],

          'sTypeID' => 0,

          'sSex' => $unionInfo['sex'] == 1 ? '先生' : '女士',

          'sMobile' => $data['phone'],

          'sWXName' => $info_user['nick_name'],

          'iBirthMon' => 0,

          'iBirthDayA' => 0,

          'sHealImgURL' => $info_user['user_headimg'],

          'sChannel' => $unionInfo['channel_code'],

        );

        /**
         * 新建POSS会员
         */
        $syncUserStatus = PosSv::addUser($possUser);

        $possUserStatus = $syncUserStatus[0];

        if ($possUserStatus['Status'] == 1) {

          /**
           * POSS中存在该手机号，则返回对应的卡号和会员主键
           */
          $payCodes = MemberSv::dynamicPayCode($possUserStatus['CardId']);

          $updateAcct['card_id_qr_code'] = $payCodes['card_id_qr_code'];

          $updateAcct['bar_code'] = $payCodes['bar_code'];

          $updateAcct['pos_id'] = $possUserStatus['Description'];

          $updateAcct['card_id'] = $possUserStatus['CardID'];

          /**
           * 更新POSS会员卡号和主键
           */
          MemberAccountSv::update($acct['id'], $updateAcct);

          /**
           * 将卡号返回前端，更新页面卡号数据
           */

          return array('card_id'=>$possUserStatus['CardID']);

        } else {
        
          /**
           * 不需要更新卡号直接返回true
           */

          $payCodes = MemberSv::dynamicPayCode($acct['card_id']);

          $updateAcct['card_id_qr_code'] = $payCodes['card_id_qr_code'];

          $updateAcct['bar_code'] = $payCodes['bar_code'];

          /**
           * 更新POSS会员卡号和主键
           */
          MemberAccountSv::update($acct['id'], $updateAcct);

          return true;
        
        }

      } else {

        /**
         * 不需要更新POSS直接返回true
         */

        return true;

      }

    } else {

      /**
       * 没有需要更新的用户数据，直接抛出未更新异常
       * 前端应该自行判断缓存数据与用户提交数据是否相同，避免此异常抛出
       */

      throw new UserException(

        ErrorCode::UserSv['USER_BINDING_PHONE_RETURN_MSG'], 

        ErrorCode::UserSv['USER_BINDING_PHONE_RETURN_CODE']

      );

    }

  }

  /**
   * 根据微信openid注册
   *
   * @param string $openId
   */
  public function miniRegister($openId, $unionId = '', $recommend = '')  {

    /**
     * 添加用户信息（openid, unionid, is_member, is_system ）
     */

    $time = date('Y-m-d H:i:s');

    $date = date('Y-m-d');

    $key = time() . '';
  
    $newUser = array(

      'uid' => substr($key, 3, 7) . rand(10,99),
    
      'wx_openid' => $openId,

      'wx_unionid' => $unionId,

      'is_member' => 1,

      'is_system' => 0,

      'reg_time' => $time,

      'reg_date' => $date,

      'hidden_identity' => self::createSecretKey($openId, 'mini')
    
    );

    if ($recommend) {
    
      $newUser['reference'] = $recommend;
    
    }

    self::add($newUser);

    $uid = $newUser['uid'];

    /**
     * 添加会员信息
     */

    $member = array(
    
      'uid' => $uid,

      'reg_time' => $time,

      'member_level' => 1,

      'memo' => 'mini register'
    
    );

    MemberSv::add($member);

    /**
     * 添加账户信息
     */

    $account = array( 

      'id' => rand(100000000, 99999999),
      
      'uid' => $uid,
    
      'created_at' => date('Y-m-d H:i:s')
    
    );

    MemberAccountSv::add($account);

    return $uid;
  
  }

  /**
   * 第三方登录/注册
   */
  public function logIn ($data) {

    $info = self::getDetail(array( 'wx_openid' => $data['wx_openid'] ));

    if (!$info) {

      /**
       * 用户不存在时，添加用户信息
       */

      $data['type'] = 2;

      // 添加用户
      $info['uid'] = self::addUser($data);

      $data_member['uid'] = $data_member_account['uid'] = $info['uid'];

      $data_member['member_name'] = '';

      $data_member['reg_time'] = $data_member_account['created_at'] = date("Y-m-d H:i:s");

      $data_member['memo'] = 'wps register';

      $data_member['member_level'] = 1;

      // 添加会员
      MemberSv::addMember($data_member);

      if ($data['shop_id']) {

        $data_member_account['shop_id'] = $data['shop_id'];

      }

      $data_member_account['id'] = rand(100000000, 999999999);

      // 添加会员账户
      MemberAccountSv::addMemberAccount($data_member_account);

      $info = self::getDetail($where);

    }

    if (!$info['user_tel']) {
      
      $info['user_tel'] = '';

    }

    $result['mobile'] = $info['user_tel'];

    $result['token'] = self::getToken($info);

    return $result;

  }

  /**
   * 获取会员令牌
   *
   * @param int $uid
   *
   * @return
   */
  public function getMemberToken($uid) {
  
    $user = self::findOne($uid);

    return self::getToken($user);
  
  }

  /**
   * 获取用户令牌
   *
   * @param array $data
   */
  public function getToken($data, $token = '') {

    if ($data['is_system'] == 1) {

        $key_name = 'admin_info';

    } else {

        $key_name = 'member_info';

    }

    $info_user = RedisClient::get($key_name, $data['uid'], true);

    $overtime_time = ConfigSv::getConfigValueByKey('overtime_time');

    $time = time();

    if (!empty($info_user['token']) && $info_user['login_time'] > $time - $overtime_time) {

      $data['login_time'] = $info_user['login_time'];

      RedisClient::set($key_name, $info_user['token'], $data);

      return $info_user['token'];

    } elseif (isset($info_user['token']) && $info_user['token']) {

      RedisClient::remove($key_name, $info_user['token']);

    }

    if (!$token) {

      $token = MD5($data['uid'].$time);

    }

    try {

      $data['login_time'] = $data_token['login_time'] = $time;

      RedisClient::set($key_name, $token, $data);

      $data_token['token'] = $token;

      RedisClient::set($key_name, $data['uid'], $data_token);

    } catch (\Exception $e){

      throw new UserException(ErrorCode::UserSv['USER_DATA_CACHE_RETURN_MSG'], ErrorCode::UserSv['USER_DATA_CACHE_RETURN_CODE']);

    }

    return $token;

  }

  /** 
   * 根据手机号查找
   *
   * @param string mobile
   *
   * @return array $user
   */
  public function findByMobile($mobile) {
  
    $user = self::all(array('user_tel' => $mobile));

    return $user[0];
  
  }

  /**
   * 甄别会员渠道，仅在用户第一次绑定手机号时甄别
   *
   * @param array $data
   */
  public function dispatchChannel($data) {

    /**
     * 先判断用户是否已标记渠道
     */
    $user = self::findOne($user['uid']);
  
    /**
     * 获取用户的unionid，只有小程序第一次绑定手机号时，会提交加密字段
     */
    if ($data['encryptedData']) {

      /**
       * 当用户授权小程序获取用户信息时，才可获取用户加密数据
       */
      $unionInfo = MemberSv::decryptData($data);

      $memberWechat = MemberWechatSv::findOne(array('unionid' => $unionInfo['unionId']));

      $unionInfo['channel_code'] = 'auto';
      
      $unionInfo['channel_type'] = 0;

      if ($memberWechat) {

        /**
         * 用户已经关注公众号，从公众号关注用户中提取渠道
         */
        $entity = ChannelSv::getChannelEntity($memberWechat['channel']);

        $unionInfo['wechat_openid'] = $memberWechat['openid'];

        $unionInfo['channel_code'] = $entity['hidden_identity'];

        $unionInfo['channel_type'] = 1;
         
        /**
         * 渠道业绩增加1
         */
        ChannelSv::increaseNumber($memberWechat['channel']);

      } elseif ($data['share_code']) {
      
        /**
         * 用户通过小程序推荐进入，从分享码中提取渠道
         */
      
        $entity = ShareRecordSv::getShareEntityCode($data['share_code']);

        $unionInfo['channel_code'] = $entity['user_key'];

        $unionInfo['channel_type'] = 2;

        /**
         * 添加小程序推荐关注记录
         */
        $shareAccept['share_code'] = $data['share_code'];

        $shareAccept['created_at'] = date("Y-m-d H:i:s");

        $shareAccept['reference_code'] = $entity['openid'];
        
        $shareAccept['reference_name'] = $entity['nick_name'];

        $shareAccept['fans_code'] = $user['wx_openid'];

        $shareAccpet['fans_nickname'] = $user['nick_name'];

        ShareAcceptSv::add($shareAccept);

        /**
         * 触发分享活动
         */
        ActivitySv::shareActivity($data['share_code']);

      }

      return $unionInfo;

    } else {
    
      /**
       * 用户拒绝授权加密信息
       */
    
    }
  
  }

  /**
   * 生成用户唯一密钥
   *
   * @param string $key
   * @param string $type
   *
   * @return
   */
  protected static function createSecretKey($key, $type) {
  
    return md5($key . $type . time());
  
  }

  /**
   * 手机号获取微信昵称
   *
   * @param string $mobile
   *
   * @return
   */
  public function getNickName($mobile) {
  
    $user = UserSv::findOne(array('user_tel' => $mobile));

    return $user['nick_name'];
  
  }

}
