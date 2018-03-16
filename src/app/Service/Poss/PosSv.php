<?php
namespace App\Service\Poss;

use App\Service\BaseService;
use App\Interfaces\Poss\IPos;
use App\Library\Http;
use App\Service\System\ConfigSv;
use PhalApi\Exception;
use App\Library\RedisClient;
use App\Service\Crm\UserSv;

/**
 * POS接口类
 */
class PosSv extends BaseService implements IPos {

  /**
   * 构造函数
   */
  public function __construct() {

    /**
     * 判断是否登录
     */

    if (!$this->checkLogin()) {
    
      $this->login();
    
    }

  }

  /**
   * 查询redis缓存中记录的pos登录状态
   *
   * @return boolean true/false
   */
  protected function checkLogin() {
  
    $posSession = RedisClient::get('pos', 'session', true);

    if (!$posSession || intval($posSession['expire']) < time()) {

      return false;
    
    } else {
      
      return true;
      
    }
  
  }

  /**
   * 1.pos登录
   * 
   * @param string $sUserId      用户ID
   * @param string $sPassword    密码
   * @param string $sExportType  返回值类型
   * @param string $sCharsetName 返回字符集编码
   */
  protected function login() {

    $data['sUserId'] = ConfigSv::getConfigValueByKey('sUserID');

    $data['sPassword'] = ConfigSv::getConfigValueByKey('sPassword');

    $data['sExportType'] = 'JSON';

    $data['sCharsetName'] = 'UTF-8';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'ABC_Login', $data);

    $info = json_decode($info, true);

    if ($info['Status'] == 1) {

      $posSession = array('expire' => time() + 900 );
    
      RedisClient::set('pos', 'session', $posSession);
    
    }

    return $info;

  }
  
  /**
   * 2.pos新增会员
   * 
   * @param array $array
   * @param string $array['sVIPName']   顾客姓名，长度不超过30                                      required
   * @param string $array['sCardID']    会员卡号，通过Get_CardIDByAdd获取                           required
   * @param string $array['sTypeID']    卡类编码，直接传0，默认卡类或可选值域通过Get_CardTypeList获 required
   * @param string $array['sSex']       性别[先生]/[女士]                                           required
   * @param string $array['sMobile']    手机号码，长度11                                            required
   * @param string $array['sWXOpenID']  微信OpenID，长度不超过30
   * @param string $array['sWXName']    微信昵称，长度不超过50
   * @param string $array['iBirthMon']  顾客生日月份值(一年中的第几月)，界面上无此字段传0           required
   * @param string $array['iBirthDayA'] 顾客生日天数值(一月中的第几天)，界面上无此字段传0           required
   * @param string $array['sPhone']     固定电话，仅允许数字，长度不超过20
   * @param string $array['sIDCard']    身份证号码，仅允许数字，长度15或18
   * @param string $array['sAddress']   地址
   * @param string $array['dBirthday']  生日(日期格式:yyyy-MM-dd)
   * @param string $array['sEmail']     邮箱地址
   * @param string $array['sMemo']      备注信息
   * @param string $array['sShpCode']   办理店铺编码(渠道码)
   * @param string $array['sReCardID']  介绍人卡号(推荐码)
   * @param string $array['sHealImgURL']  头像
   * @return string $result['Status']    状态 1=成功 -1=失败
   * @return string $result['Description']  主键
   * @return string $result['CardID']    会员卡号
   */
  protected function addUser($data){

    self::verifyUser($data);

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $data['iBirthMon'] = $data['iBirthMon'] ? $data['iBirthMon'] : 0;

    $data['iBirthDayA'] = $data['iBirthDayA'] ? $data['iBirthDayA'] : 0;

    $data['sWXOpenID'] = $data['sWXOpenID'] ? $data['sWXOpenID'] : '';

    $data['sWXName'] = $data['sWXName'] ? $data['sWXName'] : '';

    $data['sPhone'] = $data['sPhone'] ? $data['sPhone'] : '';

    $data['sIDCard'] = $data['sIDCard'] ? $data['sIDCard'] : '';

    $data['sAddress'] = $data['sAddress'] ? $data['sAddress'] : '';

    $data['dBirthday'] = $data['dBirthday'] ? $data['dBirthday'] : '';

    $data['sEmail'] = $data['sEmail'] ? $data['sEmail'] : '';

    $data['sMemo'] = $data['sMemo'] ? $data['sMemo'] : '';

    $data['sShpCode'] = $data['sShpCode'] ? $data['sShpCode'] : '';

    $data['sReCardID'] = $data['sReCardID'] ? $data['sReCardID'] : '';

    $data['sHealImgURL'] = $data['sHealImgURL'] ? $data['sHealImgURL'] : '';

    $data['sChannel'] = $data['sChannel'] ? $data['sChannel'] : '';

    $result = Http::httpPost($posUrl.'Add_VIP', $data);

    return json_decode($result, true);

  }

  /**
   * 用户信息验证
   */
  private function verifyUser($data) {

    $verification = array();

    if (isset($data['sSex']) && !in_array($data['sSex'], array('先生', '女士'))) {

      throw new Exception('sSex格式不正确', 1310);

    }

    if (isset($data['sIDCard']) && !empty($data['sIDCard'])) {

      $verification['sIDCard'] = 'identity';

    }

    if (isset($data['sEmail']) && !empty($data['sEmail'])) {

      $verification['sEmail'] = 'email';

    }

    if (isset($data['sMobile']) && !empty($data['sMobile'])) {

      $verification['sMobile'] = 'phone';

    }

    if ($verification) {

      \App\Verification($data, $verification);

    }

  }

  /**
   * 3.储值卡充值
   * 
   * @param array $array
   * @param string $array['sCardID']    会员卡号  required
   * @param string $array['iAddValue']  充值金额  required
   * @param string $array['iGiftValue'] 赠送金额  required
   * @param string $array['sMemo']      充值备注  required
   */
  protected function increaseBalance($array){

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'Balance_Add', $array);

    return json_decode($info, true);

  }

  /**
   * 4.获取充值规则
   * 
   */
  protected function getBalanceRules(){

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpGet($posUrl.'Get_BalanceRole');

  }

  /**
   * 5.获取储值卡充值订单状态
   * 
   * @param string $sDocEntry 订单主键
   */
  protected function getBalanceOrderStatus($sDocEntry){

    $post_datas = array();

    $post_datas['sDocEntry'] = isset($sDocEntry) ? $sDocEntry : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpPost($posUrl.'Get_Balance_Order', $post_datas);

  }

  /**
   * 6.获取有效的会员卡号
   * 
   */
  protected function getAvailableCardId(){

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpGet($posUrl.'Get_CardIDByAdd');

  }

  /**
   * 7.获取会员卡种类
   * 
   */
  protected function getCardTypeList(){

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpGet($posUrl.'Get_CardTypeList');

    return json_decode($info, true);

  }

  /**
   * 8.查询会员卡用电子券列表
   * 
   * @param string $sCardID 会员卡号
   * @param string $sStatus 状态，可选值:全部/正常/已使用/已过期
   */
  protected function getCouponList($data){

    $post_datas = array();

    $post_datas['sCardID'] = isset($data['sCardID']) ? $data['sCardID'] : '';

    $post_datas['sStatus'] = isset($data['sStatus']) ? $data['sStatus'] : '';

    return Http::httpPost($posUrl.'Get_CouponList', $post_datas);

  }

  /**
   * 9.获取pos门店列表
   * 
   */
  protected function getShopList($data){

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpGet($posUrl.'Get_ShpList', $data);

    return json_decode($info, true);
    
  }

  /**
   * 10.获取会员的基本信息
   * 
   * @param string $sCardID   会员卡号
   * @param string $sMobile   手机号码
   * @param string $sWXOpenID 微信OpenID
   * 以上三个参数至少传入一个 
   */
  protected function getMemberInfo($data){
    
    if ($data['sMobile']) {

      self::verifyUser($data);

    }

    $post_datas = array();

    $post_datas['sCardID'] = isset($data['sCardID']) ? $data['sCardID'] : '';

    $post_datas['sMobile'] = isset($data['sMobile']) ? $data['sMobile'] : '';

    $post_datas['sWXOpenID'] = isset($data['sWXOpenID']) ? $data['sWXOpenID'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'Get_VIP', $post_datas);

    return json_decode($info, true);

  }

  /**
   * 11.获取会员升级规则
   * 
   */
  protected function getUpgradeInfo(){

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpGet($posUrl.'Get_UpGradeInfor');

    return json_decode($info, true);

  }

  /**
   * 12.查询收银记录明细(通过主键)
   * 
   * @param string $sDocEntry 销售单主键
   */
  protected function getMemberPayHistoryDetail($sDocEntry){

    $post_datas = array();

    $post_datas['sDocEntry'] = isset($sDocEntry) ? $sDocEntry : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'Get_VIPPayHistoryDetail', $post_datas);

    return json_decode($info, true);

  }

  /**
   * 13.查询积分记录
   * 
   * @param string $data.sCardID   会员卡号
   * @param string $data.sMobile   手机号码
   * @param string $data.sWXOpenID 微信OpenID
   * @param string $key 'En'-表示返回英文字段的key 空表示中文
   * 以上三个参数至少传入一个 
   */
  protected function getMemberPointHistory($data, $key){
    
    if ($data['sMobile']) {

      self::verifyUser($data);

    }

    $post_datas = array();

    $post_datas['sCardID'] = isset($data['sCardID']) ? $data['sCardID'] : '';

    $post_datas['sMobile'] = isset($data['sMobile']) ? $data['sMobile'] : '';

    $post_datas['sWXOpenID'] = isset($data['sWXOpenID']) ? $data['sWXOpenID'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl . 'Get_VIPPointHistory' . $key, $post_datas);

    return json_decode($info, true);

  }

  /**
   * 查询余额记录
   * 
   * @param string $data.sCardID   会员卡号
   * @param string $data.sMobile   手机号码
   * @param string $data.sWXOpenID 微信OpenID
   * @param string $key 'En'-表示返回英文字段的key 空表示中文
   * 以上三个参数至少传入一个 
   */
  protected function getMemberBalanceHistory($data, $key){
    
    if ($data['sMobile']) {

      self::verifyUser($data);

    }

    $post_datas = array();

    $post_datas['sCardID'] = isset($data['sCardID']) ? $data['sCardID'] : '';

    $post_datas['sMobile'] = isset($data['sMobile']) ? $data['sMobile'] : '';

    $post_datas['sWXOpenID'] = isset($data['sWXOpenID']) ? $data['sWXOpenID'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl . 'Get_VIPBalanceHistory' . $key, $post_datas);

    return json_decode($info, true);

  }

  /**
   * 查询消费记录(根据主键)
   * 
   * @param string $sDocEntry 主键
   */
  protected function getMemberSaleHistoryByDetail($sDocEntry){

    $post_datas = array();

    $post_datas['sDocEntry'] = $sDocEntry;

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'Get_VIPSaleHistoryByDocEntry', $post_datas);

    return json_decode($info, true);

  }

  /**
   * 14.查询消费记录
   * 
   * @param string $sCardID   会员卡号
   * @param string $sMobile   手机号码
   * @param string $sWXOpenID 微信OpenID
   * 以上三个参数至少传入一个 
   */
  protected function getMemberSaleHistoryList($data, $key){
    
    if ($data['sMobile']) {

      self::verifyUser($data);

    }

    $post_datas = array();

    $post_datas['sCardID'] = isset($data['sCardID']) ? $data['sCardID'] : '';

    $post_datas['sMobile'] = isset($data['sMobile']) ? $data['sMobile'] : '';

    $post_datas['sWXOpenID'] = isset($data['sWXOpenID']) ? $data['sWXOpenID'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'Get_VIPSaleHistory' . $key, $post_datas);

    return json_decode($info, true);

  }

  /**
   * 15.查询消费记录明细
   * 
   * @param string $sDocEntry 销售单主键
   */
  protected function getMemberSaleHistoryDetail($sDocEntry){

    $post_datas = array();

    $post_datas['sDocEntry'] = isset($sDocEntry) ? $sDocEntry : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'Get_VIPSaleHistoryDetail', $post_datas);

    return json_decode($info, true);

  }

  /**
   * 16.设定储值卡充值订单状态
   * 
   * @param string $sDocEntry 订单主键
   * @param string $sStatus   订单状态
   */
  protected function setBalanceOrderStatus($data){

    $post_datas = array();

    $post_datas['sDocEntry'] = isset($data['sDocEntry']) ? $data['sDocEntry'] : '';

    $post_datas['sStatus'] = isset($data['sStatus']) ? $data['sStatus'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpPost($posUrl.'Set_Balance_Order', $post_datas);

  }

  /**
   * 17.设置卡在微信卡包中的状态
   * 
   * @param string $sCardID   卡号
   * @param string $sStatus 微信状态，值域:0-未加入卡包;1-已加入卡包 
   */
  protected function setWXCardStatus($data){

    $post_datas = array();

    $post_datas['sCardID'] = isset($data['sCardID']) ? $data['sCardID'] : '';

    $post_datas['sStatus'] = isset($data['sStatus']) ? $data['sStatus'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpPost($posUrl.'Set_CardStatusByWX', $post_datas);

  }

  /**
   * 18.设置券在微信卡包中的状态
   * 
   * @param string $sCouponNO 券号
   * @param string $sStatus 微信状态，值域:0-未加入卡包;1-已加入卡包 
   */
  protected function setWXCouponStatus($data){

    $post_datas = array();

    $post_datas['sCouponNO'] = isset($data['sCouponNO']) ? $data['sCouponNO'] : '';

    $post_datas['sStatus'] = isset($data['sStatus']) ? $data['sStatus'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpPost($posUrl.'Set_CouponStatusByWX', $post_datas);

  }

  /**
   * 19.积分调整(用于抽奖)
   * 
   * @param string $sAddType     积分调整类型
   * @param string $sCardID      会员卡号
   * @param string $iChangeValue 调整值，增加积分用正数，减少积分用负数
   * @param string $sMemo        调整原因
   */
  protected function setPoint($data){

    $post_datas = array();

    $post_datas['sAddType'] = isset($data['sAddType']) ? $data['sAddType'] : '';

    $post_datas['sCardID'] = isset($data['sCardID']) ? $data['sCardID'] : '';

    $post_datas['iChangeValue'] = isset($data['iChangeValue']) ? $data['iChangeValue'] : '';

    $post_datas['sMemo'] = isset($data['sMemo']) ? $data['sMemo'] : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpPost($posUrl.'Set_Point', $post_datas);

  }



  /**
   * 20.修改会员信息
   * 
   * @param array $array
   * @param string $array['sDocEntry']  主键                         required
   * @param string $array['sVIPName']   顾客姓名，长度不超过30       required
   * @param string $array['sSex']       性别，可选值[先生]/[女士]    required
   * @param string $array['sMobile']    手机号码，仅允许数字，长度11 required
   * @param string $array['sWXName']    微信昵称，长度不超过50
   * @param string $array['iBirthMon']  顾客生日月份值(一年中的第几月)，界面上无此字段传0。 required
   * @param string $array['iBirthDayA'] 顾客生日天数值(一月中的第几天)，界面上无此字段传0。 required
   * @param string $array['sPhone']     固定电话，仅允许数字，长度不超过20
   * @param string $array['sIDCard']    身份证号码，仅允许数字，长度15或18
   * @param string $array['sAddress']   地址
   * @param string $array['dBirthday']  生日(日期格式:yyyy-MM-dd)
   * @param string $array['sEmail']     邮箱地址
   * @param string $array['sMemo']      备注信息
   */
  protected function updateMemberInfo($array){

    self::verifyUser($array);


    $array['sWXName'] = isset($array['sWXName']) ? $array['sWXName'] : UserSv::getNickName($array['sMobile']);

    $array['iBirthMon'] = isset($array['iBirthMon']) ? $array['iBirthMon'] : 0;

    $array['iBirthDayA'] = isset($array['iBirthDayA']) ? $array['iBirthDayA'] : 0;

    $array['sPhone'] = isset($array['sPhone']) ? $array['sPhone'] : '';

    $array['sIDCard'] = isset($array['sIDCard']) ? $array['sIDCard'] : '';

    $array['sAddress'] = isset($array['sAddress']) ? $array['sAddress'] : '';

    $array['dBirthday'] = isset($array['dBirthday']) ? $array['dBirthday'] : '';

    $array['sEmail'] = isset($array['sEmail']) ? $array['sEmail'] : '';

    $array['sMemo'] = isset($array['sMemo']) ? $array['sMemo'] : '';

    $post_datas = $array;

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    $info = Http::httpPost($posUrl.'Update_VIP', $post_datas);

    return $info;

  }

  /**
   * 21.设置券的状态为已用
   * @param string $sCouponNO 券号
   */
  protected function setCouponUsed($sCouponNO){

    $post_datas = array();

    $post_datas['sCouponNO'] = isset($sCouponNO) ? $sCouponNO : '';

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpPost($posUrl.'Use_Coupon', $post_datas);

  }

  /**
   * 22.创建储值卡充值订单
   * @param string $sCardID 会员卡号
   */
  protected function addBalanceOrder($sCardID){

    $post_datas = array();

    $post_datas['sCardID'] = $sCardID;

    $posUrl = ConfigSv::getConfigValueByKey('posUrl');

    return Http::httpPost($posUrl.'Add_Balance_Order', $post_datas);

  }

  /**
   * 获取商品品牌列表
   */
  protected function getBrandList($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return Http::httpPost($posUrlOrder.'Get_BrandList', $data);

  }

  /**
   * 查询客户信息
   */
  protected function getCustom($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return Http::httpPost($posUrlOrder.'Get_CustomHistory', $data);

  }

  /**
   * 查询客户往来帐
   */
  protected function getCustomHistory($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return Http::httpPost($posUrlOrder.'Get_Custom', $data);

  }

  /**
   * 获取商品类别列表
   */
  protected function getGroupList($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return Http::httpPost($posUrlOrder.'Get_GroupList', $data);

  }

  /**
   * 获取商品列表
   */
  protected function getItemList($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return Http::httpPost($posUrlOrder.'Get_ItemList', $data);

  }
  
  /**
   * 获取商品列表(含库存)
   */
  protected function getItemListWithStock($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return PosSv::httpPost($posUrlOrder.'Get_ItemListWithStock', $data);

  }

  /**
   * 获取销售商品列表
   */
  protected function getItemListBySale($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return PosSv::httpPost($posUrlOrder.'Get_ItemListBySale', $data);

  }

  /**
   * 查询客户订单详情
   */
  protected function getOrderDetail($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return PosSv::httpPost($posUrlOrder.'Get_OrderDetail', $data);

  }

  /**
   * 获取门店详细信息
   */
  protected function getShpInfor($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return PosSv::httpPost($posUrlOrder.'Get_ShpInfor', $data);

  }

  /**
   * 商品库存查询
   */
  protected function reportStockQuery($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return PosSv::httpPost($posUrlOrder.'Report_Stock_Query', $data);

  }

  /**
   * 商品库存查询（汇总）
   */
  protected function reportStockQueryTotal($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return PosSv::httpPost($posUrlOrder.'Report_Stock_QueryTotal', $data);

  }

  /**
   * 修改当前用户密码
   */
  protected function setPassword($data){

    $posUrlOrder = ConfigSv::getConfigValueByKey('posUrlOrder');

    return PosSv::httpPost($posUrlOrder.'Set_Password', $data);

  }


}

