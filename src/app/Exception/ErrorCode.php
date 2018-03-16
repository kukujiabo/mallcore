<?php
namespace App\Exception;

/**
 * 错误码定义
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-22
 */
class ErrorCode {

  /**
   * 公用系统报错
   */
  CONST System = array(

    'QR_CODE_ERR_CODE' => 110101,
    
    'QR_CODE_ERR_MSG' => '二维码图片生成失败',

  );

  /**
   * 用户鉴权报错
   */
  CONST UserSv = array(

    'ACCT_PASS_ERR_CODE' => 210001,
    
    'ACCT_PASS_ERR_MSG' => '账号或密码错误！',

    'NO_LOGIN_CODE' => 210002,

    'NO_LOGIN_MSG' => '未登录的用户！',

    'USER_ADD_RETURN_CODE' => 210003,

    'USER_ADD_RETURN_MSG' => '用户新增失败！',

    'TOKEN_FOUND_CODE' => 210004,

    'TOKEN_FOUND_MSG' => '令牌不能为空',

    'TOKEN_RETURN_CODE' => 210005,

    'TOKEN_RETURN_MSG' => '令牌不存在',

    'USER_EDIT_RETURN_CODE' => 210006,

    'USER_EDIT_RETURN_MSG' => '未做任何更改',

    'USER_UPDATE_RETURN_CODE' => 210007,

    'USER_UPDATE_RETURN_MSG' => '信息保存失败',

    'USER_BINDING_PHONE_RETURN_CODE' => 210008,

    'USER_BINDING_PHONE_RETURN_MSG' => '绑定手机失败',

    'USER_DATA_CACHE_RETURN_CODE' => 210009,

    'USER_DATA_CACHE_RETURN_MSG' => '数据保存失败',

    'USER_GAIN_OPENID_RETURN_CODE' => 210010,

    'USER_GAIN_OPENID_RETURN_MSG' => '小程序用户openid获取失败',

  );

  /**
   * 用户积分获取规则报错
   */
  CONST UserObtainPointsRuleSv = array(

    'FAO_INVALID_CODE' => 200101,

    'FAO_INVALID_MSG' => '规则已失效',

    'FAO_NOT_FOUND_CODE' => 200102,

    'FAO_NOT_FOUND_MSG' => '查询结果为空'

  );

  /**
   * 支付报错
   */
  CONST PaySv = array(
  
    'WECHAT_PREPAY_RETURN_CODE' => 300101,

    'WECHAT_PREPAY_RETURN_MSG' => '微信预支付请求失败！',

    'WECHAT_PAY_CODE' => 300102,

    'WECHAT_PAY_MSG' => '微信支付失败！',

    'NOTIFY_ORDER_NOT_FOUND_CODE' => '300103',

    'NOTIFY_ORDER_NOT_FOUND_MSG' => '微信支付回调订单不存在！'
  
  );

  /**
   * 微信接口调用报错
   * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-01
   */
  CONST WechatSv = array(
  
    'WECHAT_DO_SEND_RETURN_CODE' => 221001,

    'WECHAT_DO_SEND_RETURN_MSG' => '推送失败',
  
    'WECHAT_GET_UNIONID_RETURN_CODE' => 221002,

    'WECHAT_GET_UNIONID_RETURN_MSG' => '获取unionid失败',

    'WECHAT_PUSH_USER_MISSED_CODE' => '221009',

    'WECHAT_PUSH_USER_MISSED_MSG' => '没有可推送的用户'
  
  );

  /**
   * 微信模版消息报错
   */
  CONST WechatTemplateMessageSv = array(
  
    'WECHAT_TEMPLATE_MESSAGE_ID_FAILED_CODE' => 224001,

    'WECHAT_TEMPLATE_MESSAGE_ID_FAILED_MSG' => '查询模版id失败！',

    'WECHAT_TEMPLATE_MESSAGE_NUM_EXCEED_CODE' => 224002,

    'WECHAT_TEMPLATE_MESSAGE_NUM_EXCEED_MSG' => '模版数量达到上限！'
  
  );

  /**
   * 微信场景事件报错
   */
  CONST WechatSceneSv = array(
  
    'WECHAT_GET_UNION_ID_CODE' => 223001,

    'WECHAT_GET_UNINO_ID_MSG' => '获取unionid失败！'
  
  );

  /**
   * Poss调用报错
   * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-28
   */
  CONST PossSv = array(
  
    'SYNC_POS_POINT_FAILED_CODE' => 190001,

    'SYNC_POS_POINT_FAILED_MSG' => '积分同步pos失败！',

    'SYNC_POS_MEMBER_INFO_FAILED_CODE' => 190002,

    'SYNC_POS_MEMBER_INFO_FAILED_MSG' => 'pos同步会员信息失败！'

  );

  /**
   * 提领券调用报错
   * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-30
   */
  CONST CouponExchangeSv = array(

    'COUPON_EXCHANGE_ACCT_PASS_RETURN_CODE' => 171001,
    
    'COUPON_EXCHANGE_ACCT_PASS_RETURN_MSG' => '识别码或提领码错误！',

    'COUPON_EXCHANGE_ACCT_PASS_USE_ERR_CODE' => 171002,
    
    'COUPON_EXCHANGE_ACCT_PASS_USE_ERR_MSG' => '本券已被使用！',

    'COUPON_EXCHANGE_ACCT_PASS_ACTIVATE_ERR_CODE' => 171003,
    
    'COUPON_EXCHANGE_ACCT_PASS_ACTIVATE_ERR_MSG' => '本券未激活！',

    'COUPON_EXCHANGE_ACCT_PASS_STOP_ERR_CODE' => 171004,
    
    'COUPON_EXCHANGE_ACCT_PASS_STOP_ERR_MSG' => '本券已停用！',

    'COUPON_EXCHANGE_ACCT_PASS_TIME_END_ERR_CODE' => 171005,
    
    'COUPON_EXCHANGE_ACCT_PASS_TIME_END_ERR_MSG' => '本券已过期！',

    'COUPON_EXCHANGE_ACCT_PASS_START_TIME_ERR_CODE' => 171006,
    
    'COUPON_EXCHANGE_ACCT_PASS_START_TIME_ERR_MSG' => '本券未到兑换日期！',

    'COUPON_EXCHANGE_ACCT_PASS_MEMBER_ERR_CODE' => 171007,
    
    'COUPON_EXCHANGE_ACCT_PASS_MEMBER_ERR_MSG' => '不是您的券！',

    'COUPON_VERIFICATION_RETURN_CODE' => 171008,
    
    'COUPON_VERIFICATION_RETURN_MSG' => '核销失败！',
  
  );

  /**
   * 会员调用报错
   * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-30
   */
  CONST MemberSv = array(
  
    'ADD_PARAM_RETURN_CODE' => 281101,

    'ADD_PARAM_RETURN_MSG' => 'uid不能为空！',
  
    'ADD_RETURN_CODE' => 281102,

    'ADD_RETURN_MSG' => '会员新增失败！',
  
    'ADD_POSS_USER_RETURN_CODE' => 281103,

    'ADD_POSS_USER_RETURN_MSG' => '用户注册POSS会员失败！',
  
    'MINI_APPS_SESSION_KEY_RETURN_CODE' => 281104,

    'MINI_APPS_SESSION_KEY_RETURN_MSG' => '错误的session_key值',
  
    'MINI_APPS_VI_RETURN_CODE' => 281105,

    'MINI_APPS_VI_RETURN_MSG' => '错误的iv值',
  
    'MINI_APPS_DECODE_RETURN_CODE' => 281106,

    'MINI_APPS_DECODE_RETURN_MSG' => '数据解密失败',
  
    'MINI_APPS_APPID_RETURN_CODE' => 281107,

    'MINI_APPS_APPID_RETURN_MSG' => 'appid错误',
  
  );

  /**
   * 用户帐户类型报错
   */
  CONST MemberAccountSv = array(
  
    'MINU_ACCT_MONEY_LESS_CODE' => '401001',

    'MINU_ACCT_MONEY_LESS_MSG' => '会员余额不足',
  
    'MINU_ACCT_POINT_LESS_CODE' => '401003',

    'MINU_ACCT_POINT_LESS_MSG' => '会员积分不足',

    'MINU_ACCT_OFFLINE_MONEY_NO_MEMBER_CODE' => '401002',
  
    'MINU_ACCT_OFFLINE_MONEY_NO_MEMBER_MSG' => '未找到会员',

  );

  CONST MobileVerifyCodeSv = array(
  
    'VERIFY_CODE_DURATION_CODE' => '501001',

    'CODE_EXPIRE_CODE' => '501002',

    'CODE_EXPIRE_MSG' => '验证码已失效！'
  
  
  );

  /**
   * 访问接口权限异常
   */
  CONST Auth = array(
  
    'TOKEN_MISSED_CODE' => '601001',

    'TOKEN_MISSED_MSG' => 'token缺失',

    'TOKEN_EXPIRED_CODE' => '601002',

    'TOKEN_EXPIRED_MSG' => '用户未登陆'
  
  );

  /**
   * 外卖订单报错
   */
  CONST OrderTakeOutSv = array(
  
    'ORDER_ERR_CODE' => '610001',

    'ORDER_ERR_MSG' => '订单不存在！',
  
    'ORDER_PAY_STATUS_ERR_CODE' => '610002',

    'ORDER_PAY_STATUS_ERR_MSG' => '已支付的订单！',
  
    'ORDER_PAY_MONEY_ERR_CODE' => '610003',

    'ORDER_PAY_MONEY_ERR_MSG' => '订单金额为0，不需要支付！',
  
    'ORDER_CANCEL_ERR_CODE' => '610004',

    'ORDER_CANCEL_ERR_MSG' => '订单已取消！',
  
    'ORDER_USE_BALANCE_POS_ERR_CODE' => '610005',

    'ORDER_USE_BALANCE_POS_ERR_MSG' => 'pos使用余额失败',
  
  );

  CONST WxproPageConfigSv = array(
  
    'UPDATE_ERR_CODE' => '710001',
  
    'UPDATE_ERR_MSG' => '更新失败！'
  
  );

  /**
   * 微信菜单操作异常
   */
  CONST WechatMenuSv = array(
  
    'MENU_CREATE_FAIL_CODE' => '230001',

    'MENU_CREATE_FAIL_MSG' => '菜单创建失败',

    'MENU_CREATE_RESPONSE_PARSE_CODE' => '230002',
  
    'MENU_CREATE_RESPONSE_PARSE_MSG' => '菜单创建返回消息解析失败',

  );

  /**
   * 优惠券操作异常
   */
  CONST CouponSv = array(
  
    'COUPON_INVALID_CODE' => '801001',

    'COUPON_INVALID_MSG' => '优惠券不存在或已失效！',

    'COUPON_WRONG_STORE_CODE' => '801002',

    'COUPON_WRONG_STORE_MSG' => '该优惠券不能在此门店使用！',

    'COUPON_MONEY_UNSATI_CODE' => '801003',

    'COUPON_MONEY_UNSATI_MSG' => '消费金额不满足！',

    'COUPON_USE_FAILED_CODE' => '801004',

    'COUPON_USE_FAILED_MSG' => '优惠券核销失败！',

    'COUPON_EXPIRED_CODE' => '801005',

    'COUPON_EXPIRED_MSG' => '优惠券已过期！',

    'COUPON_NOT_START_CODE' => '801006',
  
    'COUPON_NOT_START_MSG' => '优惠活动尚未开始！',

  );

  /**
   * 活动异常操作
   */
  CONST ActivitySv = array(

    'ACTIVITY_CREATE_FAILED_CODE' => '900001',

    'ACTIVITY_CREATE_FAILED_MSG' => '创建活动失败！'
  
  );

  /**
   * 商品分类异常
   */
  CONST GoodsCategoryException = array (
  
    'GOOD_CATEGORY_HAS_GOODS_CODE' => '111101',
  
    'GOOD_CATEGORY_HAS_GOODS_MSG' => '商品分类下有商品，不可删除'
  
  );


}
