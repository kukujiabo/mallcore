<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\SynchronousPossDm;

/**
 * 13.2 同步POSS数据
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-23
 */
class SynchronousPoss extends BaseApi {

  public function getRules() {

    return $this->rules(array(

      'SynchronousGoods' => array(

        'sDate' => 'sDate|string|true||档案建立日期或更新日期，格式:yyyy-MM-dd',
      
        'iPage' => 'iPage|int|true||页号(从第1页开始)',
        
        'iPageSize' => 'iPageSize|int|true||页大小(默认每页300条记录)',

      ),
      
    ));

  }

  /**
   * 同步POSS商品数据
   * @desc 同步POSS商品数据
   *
   * @return int ret 操作状态：200表示成功
   * @return array data 
   * @return string msg 错误提示
   */
  public function SynchronousGoods() {

    $params = $this->retriveRuleParams('SynchronousGoods');

    $regulation = array(

      'sDate' => 'required',

      'iPage' => 'required',

      'iPageSize' => 'required',

    );

    \App\Verification($params, $regulation);

    return $this->dm->SynchronousGoods($params);
  
  }

}
