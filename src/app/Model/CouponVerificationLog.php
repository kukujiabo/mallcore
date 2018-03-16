<?php
namespace App\Model;

/**
 * [模型层] 提领券核销记录
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-04
 */
class CouponVerificationLog extends BaseModel {


  protected $_queryOptionRule = array(

    'created_at' => 'range',

  );

}
