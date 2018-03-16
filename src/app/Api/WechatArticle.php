<?php
namespace App\Api;

/**
 * 22.3 获取微信公众号素材
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-12-20
 */
class WechatArticle extends BaseApi {

  public function getRules() {
  
    return $this->rules(array(

      'getMaterial' => array(

        'type' => 'type|string|true||素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）',

        'offset' => 'offset|int|true|0|从全部素材的该偏移位置开始返回，0表示从第一个素材 返回',

        'count' => 'count|int|true|20|返回素材的数量，取值在1到20之间',

      )
    
    ));
  
  }

  /**
   * 获取微信公众号素材
   * @desc 获取微信公众号素材
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集 <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1444738734" target="_blank">《文档》</a>
   * @return string msg 错误提示
   */
  public function getMaterial() {

    $condition = $this->retriveRuleParams(__FUNCTION__);

    $regulation = array(
      'type' => 'required',
      'offset' => 'required',
      'count' => 'required',
    );

    \App\Verification($condition, $regulation);

    return $this->dm->getMaterial($condition);
  
  }

}
