<?php
namespace App\Service\Wechat;

use App\Service\BaseService;
use App\Library\Http;
use App\Exception\WechatException;
use App\Exception\ErrorCode;
use App\Service\Wechat\WechatUtilsSv;

/**
 * 微信菜单服务
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-17
 */
class WechatMenuSv extends BaseService {

  /**
   * 创建微信公众号菜单
   *
   * @param array $menuData
   *
   * @return boolean true/false
   */
  public function create($data) {
  
    $accessToken = WechatUtilsSv::getAccessToken();

    $url = str_replace('{ACCESS_TOKEN}', $accessToken, \PhalApi\DI()->config->get('wechat.CREATE_WPS_MENU'));

    /**
     * 若有文字类型，则必须解析
     */
    $menus = json_decode($data['menus'], true);

    self::textMenu($menus['button']);

    $result = Http::httpPost($url, json_encode($menus, JSON_UNESCAPED_UNICODE));

    if ($result) {
    
      $resultArray = json_decode($result, true);

      if (empty($resultArray) || !empty($resultArray['errcode'])) {
      
        throw new WechatException(
          ErrorCode::WechatMenuSv['MENU_CREATE_RESPONSE_PARSE_MSG'],
          ErrorCode::WechatMenuSv['MENU_CREATE_RESPONSE_PARSE_CODE']
        );
      
      } elseif ($resultArray['errcode'] == 0) {

        return true;
      
      }

    } else {
    
      throw new WechatException(
        ErrorCode::WechatMenuSv['MENU_CREATE_FAIL_MSG'],
        ErrorCode::WechatMenuSv['MENU_CREATE_FAIL_CODE']
      );
    
    }
  
  }

  /**
   * 拉取微信公众号菜单
   *
   * @return array list
   */
  public function getMenu() {
  
    $accessToken = WechatUtilsSv::getAccessToken();

    $url = str_replace('{ACCESS_TOKEN}', $accessToken, \PhalApi\DI()->config->get('wechat.GET_WPS_MENU'));

    return iconv('UTF-8', 'GBK', Http::httpPost($url, $data['menus']));
  
  }

  public function textMenu(&$menus) {
  
    foreach($menus as $key => $menu) {
    
      if ($menu['type'] == 'click') {

        $text = $menus[$key]['text'];

          if ($text) {

          unset($menus[$key]['text']);

          $id = MenuTextSv::add(array('content' => $text, 'created_at' => date('Y-m-d H:i:s')));

          $eventId = "cm_{$id}";

          $menus[$key]['key'] = $eventId;

        }
      
      }
    
      if ($menu['type'] == 'image') {
      
        $menus[$key]['type'] = 'media_id';
      
      }

      if ($menu['sub_button']) {
      
        self::textMenu($menus[$key]['sub_button']);
      
      }
    
    } 
  
  }

}
