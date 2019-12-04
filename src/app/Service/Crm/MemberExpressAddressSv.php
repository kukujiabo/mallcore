<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IMemberExpressAddress;
use App\Model\MemberExpressAddress;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Shop\ShopSv;

/**
 * 用户收货地址类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */
class MemberExpressAddressSv extends BaseService implements IMemberExpressAddress {

    use CurdSv;
  
    /**
     * 获取收货地址列表
     */
    public function getList($condition) {

        $shop_id = $condition['shop_id'];
        
        unset($condition['shop_id']);

        $info_user = UserSv::getUserByToken($condition['token']);
        
        unset($condition['token']);

        $condition['uid'] = $info_user['uid'];

        $info = self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

        if ($shop_id) {

            $info_shop = ShopSv::findOne($shop_id);

            $id = [];

            foreach ($info['list'] as $key => $value) {

                $info['list'][$key]['is_out_of_range'] = 2;

                $info['list'][$key]['is_out_of_range'] = 1;

                $info['list'][$key]['distance'] = 0;

                $info['list'][$key]['latitude'] = 0;

                $info['list'][$key]['longitude'] = 0;

                $result = ShopSv::getQqCoordinate($value['address'], 1);

                if ($result) {

                    $latitude = $info['list'][$key]['latitude'] = $result['location']['lat'];

                    $longitude = $info['list'][$key]['longitude'] = $result['location']['lng'];

                    $distance = ShopSv::getdistance($info_shop['longitude'], $info_shop['latitude'], $longitude, $latitude);
                    
                    $info['list'][$key]['distance'] = $distance;

                    if ($info_shop['shop_scope'] == 0 || $distance <= $info_shop['shop_scope']) {

                        $info['list'][$key]['is_out_of_range'] = 2;

                    }
                }
                
                $id[$key] = $info['list'][$key]['is_out_of_range'];

            }

            array_multisort($id, SORT_DESC, $info['list']);

        }

        return $info;

    }

    /**
    * 添加收货地址
    */
    public function addAddress($data){

        $info_user = UserSv::getUserByToken($data['token']);

        unset($data['token']);

        $data['uid'] = $info_user['uid'];

        if (isset($data['is_default']) && $data['is_default'] == 1) {

            $condition['uid'] = $info_user['uid'];

            $condition['is_default'] = 2;

            self::updateAddress($condition);

        }

        // $data = eval('return '.iconv("UTF-8", "GBK//IGNORE", var_export($data,true)).';');

        //$data['id'] = rand(100000000, 999999999);

        return self::add($data);


    }
  
    /**
     * 修改收货地址
     */
    public function updateAddress($data){

        if ($data['uid']) {

            $condition['uid'] = $data['uid'];

            unset($data['uid']);

        }

        if ($data['token']) {

            $info_user = UserSv::getUserByToken($data['token']);

            unset($data['token']);

            $condition['uid'] = $info_user['uid'];

        }

        if (isset($data['is_default']) && $data['is_default'] == 1) {

            $data_pa['is_default'] = 2;
            
            self::batchUpdate($condition, $data_pa);

        }

        if ($data['address_id']) {

            $condition['id'] = $data['address_id'];

            unset($data['address_id']);

        }

        return self::batchUpdate($condition, $data);

    }
  
    /**
     * 修改默认收货地址
     */
    public function editDefault($data){

        $id = $data['address_id'];

        $info_user = UserSv::getUserByToken($data['token']);

        unset($data['token']);

        unset($data['address_id']);

        $condition['uid'] = $info_user['uid'];

        $data['is_default'] = 2;

        $info_status = self::batchUpdate($condition, $data);

        $condition['id'] = $id;

        $data['is_default'] = 1;

        return self::batchUpdate($condition, $data);

    }
  
    /**
     * 删除收货地址
     */
    public function remove($data){

        $condition['id'] = $data['address_id'];

        $info_user = UserSv::getUserByToken($data['token']);

        $condition['uid'] = $info_user['uid'];

        return self::batchRemove($condition);

    }
  
    /**
     * 获取收货地址总数
     */
    public function getAddressCount($condition){

        if ($condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['uid'] = $info_user['uid'];

        }

        unset($condition['way']);
        
        unset($condition['token']);

        return self::queryCount($condition);

    }
  
    /**
     * 获取收货地址详情
     */
    public function getAddressDetails($data){

        $shop_id = $data['shop_id'];
        
        unset($data['shop_id']);
        
        if ($data['token']) {

            $info_user = UserSv::getUserByToken($data['token']);

            unset($data['token']);

            $condition['uid'] = $info_user['uid'];

        }
        
        if ($data['address_id']) {

            $condition['id'] = $data['address_id'];

        }
        
        if ($data['is_default']) {

            $condition['is_default'] = $data['is_default'];

        }

        $info = self::findOne($condition);

        return $info;

    }


    public function searchAllAddress($data) {
    
      $user = UserSv::getUserByToken($data['token']);
    
      $content = $data['content'];

      $encodeContent = $content; //iconv('UTF-8', 'GBK', $content);

      $query = array( 'uid' => $user['uid'] );

      $or = "consigner like '%{$encodeContent}%' or mobile like '%{$content}%' or address like '%{$encodeContent}%'";
      
      return self::all($query, 'id desc', '*', $or);
    
    }

}
