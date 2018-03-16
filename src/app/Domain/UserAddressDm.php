<?php

namespace App\Domain;

use App\Service\Crm\MemberExpressAddressSv;
use App\Service\Crm\UserSv;

/**
 * 收货地址接口类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */
class UserAddressDm {
  
    /**
     * 添加收货地址
     */
    public function addAddress($data){

        return MemberExpressAddressSv::addAddress($data);

    }
  
    /**
     * 修改收货地址
     */
    public function updateAddress($data){

        return MemberExpressAddressSv::updateAddress($data);

    }
  
    /**
     * 修改默认收货地址
     */
    public function editDefault($data){

        return MemberExpressAddressSv::editDefault($data);

    }
  
    /**
     * 删除收货地址
     */
    public function remove($data){

        return MemberExpressAddressSv::remove($data);

    }
  
    /**
     * 获取收货地址列表
     */
    public function getAddressList($condition){

        return MemberExpressAddressSv::getList($condition);

    }
  
    /**
     * 获取收货地址总数
     */
    public function getAddressCount($condition){

        return MemberExpressAddressSv::getAddressCount($condition);

    }
  
    /**
     * 获取收货地址详情
     */
    public function getAddressDetails($data){

        return MemberExpressAddressSv::getAddressDetails($data);

    }

}
