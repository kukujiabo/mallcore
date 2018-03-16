<?php
namespace App\Service\Pay;

use App\Service\BaseService;
use App\Interfaces\Pay\IPay;
use App\Model\Pay;
use App\Library\Http;
use Core\Service\CurdSv;
use PhalApi\Exception;
use App\Service\System\ConfigSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberAccountRecordSv;
use App\Service\ThirdPartyApi\Notify\ThirdPartyMessageLogSv;
use Wechat\WechatPay;
use App\Exception\PayException;
use App\Exception\ErrorCode;
use Wechat\Lib\Tools;


/**
 * 微信统一支付类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-01
 */
class PaySv extends BaseService implements IPay {

    use CurdSv;

    /**
     * 微信支付回调处理类
     */
    protected $wechatPay;

    /**
     * 微信支付appId;
     */
    protected $appId;

    /**
     * 微信支付密钥
     */
    protected $appSecret;

    /**
     * 商户号
     */
    protected $mchId;

    /**
     * 支付密钥
     */
    protected $partnerKey;

    /**
     * 支付币种
     */
    CONST FEE_TYPE = 'CNY';

    /**
     * 微信支付签名算法
     */
    CONST SIGN_TYPE = 'MD5';

    /**
     * 回调处理数组
     */
    protected static $orderNoProcessor = array(
    
      '100' => array("\\App\\Service\\Crm\\MemberRechargeSv", "rechargeNotify"), //充值订单通知处理
    
      '200' => array("\\App\\Service\\Takeaway\\OrderTakeOutSv", "orderTakeOutNotify"), //外卖订单通知处理
    
    );

    /**
     * 构造函数
     */
    public function __construct() {

      $this->appId = ConfigSv::getConfigValueByKey('ruixuan_mini_appId');

      $this->appSecret = ConfigSv::getConfigValueByKey('ruixuan_mini_secret');

      $this->mchId = ConfigSv::getConfigValueByKey('ruixuan_mini_mch_id');

      $this->partnerKey = ConfigSv::getConfigValueByKey('ruixuan_mini_pay_key');
    
      $wechatConfig = array(
        'appid' => $this->appId,
        'mch_id' => $this->mchId,
        'partnerkey' => $this->partnerKey
      );

      $this->wechatPay = new WechatPay($wechatConfig);

    }

    /**
     * 微信支付回调通知
     *
     * @param string $data
     *
     * $return 
     */
    public function wechatPayNotify($data) {

      /**
       * 先对原始返回的原始数据进行保存
       */
      $insertData = array(
        'module' => 'wechat',
        'action' => 'pay_notify',
        'content' => $data,
        'remark' => '微信支付通知消息',
        'status' => 0,
        'created_at' => date('Y-m-d H:i:s')
      );
    
      $tid = ThirdPartyMessageLogSv::add($insertData);

      $self = self::inst( __CLASS__ );

      /**
       * 将微信返回消息解析成数组
       * 包含验证签名
       */
      $notifyArr = $self->wechatPay->getNotify();

      if (!$notifyArr) { //解析返回数据错误！

        throw new PayException(
          ErrorCode::PaySv['WECHAT_PAY_RETURN_MSG'], 
          ErrorCode::PaySv['WECHAT_PAY_RETURN_CODE'], 
          $notifyArr->wechatPay->err_msg
        );
      
      }

      if (
        array_key_exists("return_code", $notifyArr) 
        && array_key_exists("result_code", $notifyArr) 
        && $notifyArr["return_code"] == "SUCCESS"
        && $notifyArr["result_code"] == "SUCCESS"
      ) { //微信支付成功

        /**
         * 处理相关订单
         */
        $self->processOrder($notifyArr['out_trade_no']);
  
        /**
         * 返回成功
         */
        $echoResult = array(
          'return_code' => 'SUCCESS',
          'return_msg' => 'OK'       
        );

        ThirdPartyMessageLogSv::update($tid, array('status' => 1));

        $self->wechatPay->replyXml($echoResult);

      } else { //微信支付失败
      
        throw new PayException(
          ErrorCode::PaySv['WECHAT_PAY_RETURN_MSG'], 
          ErrorCode::PaySv['WECHAT_PAY_RETURN_CODE'], 
          $notifyArr['out_trade_no'] . '|' . $notifyArr['return_msg']
        );
      
      }
    
    }
    
    /**
     * 微信支付统一调用
     * @param array $data
     * @param type $data['openid'] 用户openid
     * @param type $data['money'] 支付金额
     * @param type $data['order_sn'] 订单号
     * @param type $data['ip_address'] 用户ip地址
     */
    public function wechatPayAction($data){

        /**
         * 获取PaySv实例
         */
        $self = self::inst( __CLASS__ );

        /**
         * 设置支付appid和商户号
         */
        $request = array();
        $request['appid'] = $self->appId;
        $request['mch_id'] = $self->mchId;

        /**
         * 根据不同的支付类型进行不同的操作
         */
        switch($data['pay_type']){
            case 1:
                $request['spbill_create_ip'] = \PhalApi\DI()->config->get('wechat.WECHAT_PAY_IP');
                $request['product_id']       = $data['order_sn']; //商品id 为 NATIVE 时，必传
                $request['trade_type']       = 'NATIVE';
                $type = 1;
                break;
            case 2:
                $request['spbill_create_ip'] = $data['ip_address'];
                $request['openid']           = $data['open_id'];
                $request['trade_type']       = 'JSAPI';
                $type = 2;
                break;
            case 3:
                $request['spbill_create_ip'] = $data['ip_address'];
                $request['trade_type']       = 'APP';
                $type = 1;
                break;
            default:
                throw new Exception('支付类型错误！', 60);
                break;
        }

        /**
         * 获取当前时间
         */
        $nowdate = date('YmdHis');

        /**
         * 设置支付超时时间
         */
        $payDeadLine = date('YmdHis', (strtotime($nowdate) + \PhalApi\DI()->config->get('wechat.WECHATPAY_EXPIRE')));

        /**
         * 构建支付请求数组
         */
        $request['device_info']   = $data['device_info'];
        $request['nonce_str']     = $data['nonce_str'];
        $request['body']          = $data['body']; //商品或支付简要描述
        $request['detail']        = $data['detail']; //商品名称明细列表 可不传
        $request['attach']        = $data['pay_type'].$data['openid']; //附加数据 可不传 用于标记订单类型 1-普通订单 2-充值订单
        $request['out_trade_no']  = $data['out_trade_no'];
        $request['fee_type']      = PaySv::FEE_TYPE;
        $request['total_fee']     = round($data['money']*100); //支付金额
        $request['time_start']    = $nowdate;
        $request['time_expire']   = $payDeadLine;
        $request['notify_url']    = \PhalApi\DI()->config->get('wechat.WECHAT_PAY_NOTIFY_URL');

        foreach($request as $key => $val) {
        
          if (empty($val)) {

            unset($request[$key]);
          
          }
        
        }

        /**
         * 获取请求url
         */
        $postUrl = \PhalApi\DI()->config->get('wechat.WECHAT_UNIFIED_PAY');

        /**
         * 请求支付
         */
        $response = $self->wechatPay->getArrayResult($request, $postUrl);


        /**
         * 处理微信支付返回请求
         */
        if ($response['result_code'] != 'SUCCESS') {

          throw new PayException(
            $response['err_code_des'], 
            ErrorCode::PaySv['WECHAT_PREPAY_RETURN_CODE'], 
            $data['out_trade_no'] . '|' . $response['return_msg']
          );

        }elseif($response['return_code'] == 'SUCCESS' && $response['return_msg'] == 'OK'){

            $nextPay = array();

            switch($data['pay_type']) {
            
              case 1:

                $nextPay['code_url'] = $response['code_url'];

                break;
              case 2:

                $nextPay['appId'] = $self->appId;
                $nextPay['timeStamp'] = time();
                $nextPay['nonceStr'] = $data['nonce_str'];
                $nextPay['package'] =  "prepay_id={$response['prepay_id']}";
                $nextPay['signType'] = PaySv::SIGN_TYPE;
                $nextPay['paySign'] = Tools::getPaySign($nextPay, $self->partnerKey);
                $nextPay['timestamp'] = $nextPay['timeStamp'];

                break;
            
            }

            return $nextPay;

        } else {

          /**
           * 预支付请求失败抛出异常
           * 并将微信返回数据序列化存入日志
           */
          throw new PayException(
            ErrorCode::PaySv['WECHAT_PREPAY_RETURN_MSG'],
            ErrorCode::PaySv['WECHAT_PREPAY_RETURN_CODE'], 
            $data['out_trade_no'] . '|' . $response['return_msg']
          );

        }

    }
    
    /**
     * 生成支付签名
     * @param array $data
     * @param int $type 1-微信APP 2-微信浏览器 3-支付宝
     */
    private static function _createPaySign(array $data, $type = 1){
        foreach($data as $key => $val){
            if($val == '' || $val == NULL){
                unset($data['$key']);
            }
        }
        ksort($data);
        switch ($type){
            case 1:
               $data['key'] = ConfigSv::getConfigValueByKey('ruixuan_mini_pay_key');
                break;
            case 2:
               $data['key'] = ConfigSv::getConfigValueByKey('ruixuan_mini_pay_key');
                break;
            case 3:
                break;
        }
        $key_str = self::_createPayFormat($data);
        if($type == 1 || $type == 2){
            return strtoupper(md5($key_str));
        }else{
            return md5($key_str);
        }
    }
    
    /**
     * 组装支付签名的字符串
     * @param array $data
     */
    private static function _createPayFormat(array $data){

        $result_str = '';

        foreach($data as $key=>$val){

            $result_str .= $key.'='.$val.'&';

        }

        $result_str = substr($result_str, 0, strlen($result_str) - 1);

        return $result_str;

    }

    
    /**
     * 创建微信支付XML
     * @param type $arr
     * @return string
     */
    public static function _createXml($arr) {

        $xml = "<xml>";

        foreach ($arr as $key => $val) {

            if (is_numeric($val)) {

                $xml = $xml."<" . $key . ">" . $val . "</" . $key . ">";

            } else{

                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";

            }

        }

        $xml .= "</xml>";

        return $xml;
    }

    /**
     * 微信支付回调
     * @param type $pay_result
     */
    public function wechatPay($pay_result) {

        $attach = explode('-', $pay_result['attach']);

        $where_user = array();

        $where_user['wx_openid'] = $openid = $attach[1];

        $list_user = UserSv::queryList($where_user);

        $data_record = array();

        $info_user = $list_user['list'];

        $data_record['uid'] = $info_user['uid'];

        $data_record['from_type'] = 4;

        $data_record['text'] = '会员微信充值，流水号：' . $pay_result['transaction_id'];

        $data_record['account_type'] = 2;

        $data_record['sign'] = '+';

        $data_record['create_time'] = date("Y-m-d H:i:s");

        $data_record['number'] = $pay_result['total_fee']/100;

        // 添加会员流水账
        $data_record_info = MemberAccountRecordSv::add($data_record);

        if (!$data_record_info) {

            // 记录流水写入失败日志

        }

        $data_account['balance'] = new \NotORM_Literal("balance + " . $data_record['number']);

        $data_account['uid'] = $info_user['uid'];

        // 修改会员余额
        $data_record_info = MemberAccountSv::updates($data_account);

        // 记录修改日志

        return true;

    }

    /**
     * 订单处理
     *
     * @param string $orderNo
     *
     * @return boolean true/false
     */
    protected function processOrder($orderNo) {

      $processor = self::$orderNoProcessor[substr($orderNo, 0, 3)];

      if (is_array($processor)) {
      
        return call_user_func_array(array($processor[0], $processor[1]), array('orderNo' => $orderNo));
      
      } else {
      
        return false;
      
      }
    
    }

}
