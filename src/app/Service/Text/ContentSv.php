<?php
namespace App\Service\Text;

use App\Service\System\WxproPageConfigSv;
use App\Service\BaseService;


/**
 * 文本输出服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-07
 */
class ContentSv extends BaseService {

  /**
   * 输出小程序文案
   *
   * @param $data 
   *
   * @param html
   */
  public function getMiniPageText($data) {

    $options = array(
    
      'page_code' => $data['page_code'],

      'attr_code' => $data['attr_code']
    
    );
  
    $text = WxproPageConfigSv::findOne($options);

    return $text['value_text'];
  
  }


}
