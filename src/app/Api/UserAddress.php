<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\UserAddressDm;

/**
 * 2.2 收货地址接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-25
 */

class UserAddress extends BaseApi {

    public function getRules() {
        return $this->rules(array(
            // 所有规则都有的固定参数
            '*' => array(
                'token'  => array('name' => 'token', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '用户令牌'),
            ),
            'addAddress' => array(
                'consigner'  => array('name' => 'consigner', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '收件人'),
                'mobile'  => array('name' => 'mobile', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '手机'),
                'province'  => array('name' => 'province', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '省id'),
                'province_name'  => array('name' => 'province_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '省名称'),
                'city'  => array('name' => 'city', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '市id'),
                'city_name'  => array('name' => 'city_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '市名称'),
                'district'  => array('name' => 'district', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '区/县id'),
                'district_name'  => array('name' => 'district_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '区/县名称'),
                'address'  => array('name' => 'address', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '详细地址'),
                'zip_code'  => array('name' => 'zip_code', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '邮编'),
                'alias'  => array('name' => 'alias', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '地址别名'),
                'phone'  => array('name' => 'phone', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '固定电话'),
                'is_default'  => array('name' => 'is_default', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '默认收货地址 1-默认 2-不默认'),
            ),
            'updateAddress' => array(
                'address_id'  => array('name' => 'address_id', 'type' => 'int', 'require' => true, 'default' => '', 'desc' => '地址id'),
                'consigner'  => array('name' => 'consigner', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '收件人'),
                'mobile'  => array('name' => 'mobile', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '手机'),
                'province'  => array('name' => 'province', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '省id'),
                'province_name'  => array('name' => 'province_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '省名称'),
                'city'  => array('name' => 'city', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '市id'),
                'city_name'  => array('name' => 'city_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '市名称'),
                'district'  => array('name' => 'district', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '区/县id'),
                'district_name'  => array('name' => 'district_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '区/县名称'),
                'address'  => array('name' => 'address', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '详细地址'),
                'zip_code'  => array('name' => 'zip_code', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '邮编'),
                'alias'  => array('name' => 'alias', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '地址别名'),
                'phone'  => array('name' => 'phone', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '固定电话'),
                'is_default'  => array('name' => 'is_default', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '默认收货地址 1-默认 2-不默认'),
            ),
            'getAddressCount' => array(
                'address_id'  => array('name' => 'address_id', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '地址id'),
                'consigner'  => array('name' => 'consigner', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '收件人'),
                'mobile'  => array('name' => 'mobile', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '手机'),
                'province'  => array('name' => 'province', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '省id'),
                'province_name'  => array('name' => 'province_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '省名称'),
                'city'  => array('name' => 'city', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '市id'),
                'city_name'  => array('name' => 'city_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '市名称'),
                'district'  => array('name' => 'district', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '区/县id'),
                'district_name'  => array('name' => 'district_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '区/县名称'),
                'address'  => array('name' => 'address', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '详细地址'),
                'zip_code'  => array('name' => 'zip_code', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '邮编'),
                'alias'  => array('name' => 'alias', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '地址别名'),
                'phone'  => array('name' => 'phone', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '固定电话'),
                'is_default'  => array('name' => 'is_default', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '默认收货地址 1-默认 2-不默认'),
            ),
            'getAddressList' => array(
                'address_id'  => array('name' => 'address_id', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '地址id'),
                'consigner'  => array('name' => 'consigner', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '收件人'),
                'mobile'  => array('name' => 'mobile', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '手机'),
                'province'  => array('name' => 'province', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '省id'),
                'province_name'  => array('name' => 'province_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '省名称'),
                'city'  => array('name' => 'city', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '市id'),
                'city_name'  => array('name' => 'city_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '市名称'),
                'district'  => array('name' => 'district', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '区/县id'),
                'district_name'  => array('name' => 'district_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '区/县名称'),
                'address'  => array('name' => 'address', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '详细地址'),
                'zip_code'  => array('name' => 'zip_code', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '邮编'),
                'alias'  => array('name' => 'alias', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '地址别名'),
                'phone'  => array('name' => 'phone', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '固定电话'),
                'is_default'  => array('name' => 'is_default', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '默认收货地址 1-默认 2-不默认'),

                'shop_id' => 'shop_id|int|false||门店id',

                'fields' => 'fields|string|false|*|查询字段',

                'order' => 'order|string|false||排序',

                'page' => 'page|int|true|1|页码',

                'page_size' => 'page_size|int|true|20|每页数据条数'

            ),
            'getAddressDetails' => array(
                'address_id'  => array('name' => 'address_id', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '地址id'),
                'shop_id' => 'shop_id|int|false||门店id',
                'is_default'  => array('name' => 'is_default', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '默认收货地址 1-默认 2-不默认'),
            ),
            'editDefault' => array(
                'address_id'  => array('name' => 'address_id', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '地址id'),
            ),
            'remove' => array(
                'address_id'  => array('name' => 'address_id', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '地址id'),
            ),
        ));
    }
    
    /**
     * 添加收货地址接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function addAddress() {

        $regulation['token'] = 'required';
        $regulation['consigner'] = 'required';
        $regulation['mobile'] = 'required|phone';
        $regulation['province'] = 'required';
        $regulation['city'] = 'required';
        $regulation['district'] = 'required';
        $regulation['address'] = 'required';

        $params = $this->retriveRuleParams('addAddress');

        \App\Verification($params, $regulation);

        return $this->dm->addAddress($params);

    }
    
    /**
     * 修改收货地址接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function updateAddress() {

        $regulation['token'] = 'required';

        $regulation['address_id'] = 'required';
        
        $regulation['mobile'] = 'phone';

        $params = $this->retriveRuleParams('updateAddress');

        \App\Verification($params, $regulation);

        return $this->dm->updateAddress($params);
    }
    
    /**
     * 获取收货地址列表接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return int data.total 地址总条数
     * @return int data.page 当前页码
     * @return string data.list[] 
     * @return int data.list[].address_id 地址id
     * @return string data.list[].consigner 收件人
     * @return string data.list[].mobile 手机
     * @return string data.list[].phone 固定电话
     * @return int data.list[].province 省id
     * @return string data.list[].province_name 省名称
     * @return int data.list[].city 市id
     * @return string data.list[].city_name 市名称
     * @return int data.list[].district 区/县id
     * @return string data.list[].district_name 区/县名称
     * @return string data.list[].address 详细地址
     * @return int data.list[].zip_code 邮编
     * @return string data.list[].alias 地址别名
     * @return int data.list[].is_default 默认收货地址：1-默认，2-不默认
     * @return float data.list[].latitude 纬度
     * @return float data.list[].longitude 经度
     * @return int data.list[].is_out_of_range 是否超出配送范围 1-是 2-否
     * @return float data.list[].distance 距离，单位：米
     * @return string msg 错误提示
     */
    public function getAddressList() {

        $conditions = $this->retriveRuleParams('getAddressList');

        $regulation['token'] = 'required';
        $regulation['page'] = 'required';
        $regulation['page_size'] = 'required';

        \App\Verification($conditions, $regulation);

        return $this->dm->getAddressList($conditions);

    }
    
    /**
     * 获取收货地址总条数接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string data 地址总条数
     * @return string msg 错误提示
     */
    public function getAddressCount() {

        $conditions = $this->retriveRuleParams('getAddressCount');

        $regulation['token'] = 'required';

        \App\Verification($conditions, $regulation);

        return $this->dm->getAddressCount($conditions);

    }
    
    /**
     * 获取地址详情接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return int data.address_id 地址id
     * @return string data.consigner 收件人
     * @return string data.mobile 手机
     * @return string data.phone 固定电话
     * @return int data.province 省id
     * @return string data.province_name 省名称
     * @return int data.city 市id
     * @return string data.city_name 市名称
     * @return int data.district 区/县id
     * @return string data.district_name 区/县名称
     * @return string data.address 详细地址
     * @return int data.zip_code 邮编
     * @return string data.alias 地址别名
     * @return int data.is_default 默认收货地址：1-默认，2-不默认
     * @return float data.latitude 纬度
     * @return float data.longitude 经度
     * @return int data.is_out_of_range 是否超出配送范围 1-是 2-否
     * @return float data.distance 距离，单位：米
     * @return string msg 错误提示
     */
    public function getAddressDetails() {

        $regulation['token'] = 'required';

        $conditions = $this->retriveRuleParams('getAddressDetails');

        \App\Verification($conditions, $regulation);

        return $this->dm->getAddressDetails($conditions);

    }
    
    /**
     * 修改默认地址接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data 成功条数
     * @return string msg 错误提示
     */
    public function editDefault() {

        $regulation['token'] = 'required';

        $regulation['address_id'] = 'required';

        $conditions = $this->retriveRuleParams('editDefault');

        \App\Verification($conditions, $regulation);

        return $this->dm->editDefault($conditions);

    }
    
    /**
     * 删除地址接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data 成功条数
     * @return string msg 错误提示
     */
    public function remove() {

        $regulation['token'] = 'required';

        $regulation['address_id'] = 'required';

        $conditions = $this->retriveRuleParams('remove');

        \App\Verification($conditions, $regulation);

        return $this->dm->remove($conditions);

    }

}
