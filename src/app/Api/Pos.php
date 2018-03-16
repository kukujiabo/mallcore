<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\PosDm;
// 非法请求
use PhalApi\Exception\BadRequestException;

/**
 * 13.1 POS接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-05
 */

class Pos extends BaseApi {

    public function getRules() {
        return $this->rules(array(
            'posLogin' => array(),
            'addUser' => array(
                'sVIPName'  => array('name' => 'sVIPName', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '顾客姓名，长度不超过30'),
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '会员卡号，通过Get_CardIDByAdd获取'),
                'sTypeID'  => array('name' => 'sTypeID', 'type' => 'string', 'require' => true, 'default' => '1', 'desc' => '卡类编码，默认卡类或可选值域通过Get_CardTypeList获'),
                'sSex'  => array('name' => 'sSex', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '性别[先生]/[女士]'),
                'sMobile'  => array('name' => 'sMobile', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '手机号码'),
                'sWXOpenID'  => array('name' => 'sWXOpenID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信OpenID，长度不超过30'),
                'sWXName'  => array('name' => 'sWXName', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信昵称，长度不超过50'),
                'iBirthMon'  => array('name' => 'iBirthMon', 'type' => 'string', 'require' => false, 'default' => '0', 'desc' => '顾客生日月份值(一年中的第几月)'),
                'iBirthDayA'  => array('name' => 'iBirthDayA', 'type' => 'string', 'require' => false, 'default' => '0', 'desc' => '顾客生日天数值(一月中的第几天)'),
                'sPhone'  => array('name' => 'sPhone', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '固定电话，仅允许数字，长度不超过20'),
                'sIDCard'  => array('name' => 'sIDCard', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '身份证号码，仅允许数字，长度15或18'),
                'sAddress'  => array('name' => 'sAddress', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '地址'),
                'dBirthday'  => array('name' => 'dBirthday', 'type' => 'date', 'require' => false, 'default' => '', 'desc' => '生日(日期格式:yyyy-MM-dd)'),
                'sEmail'  => array('name' => 'sEmail', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '邮箱地址'),
                'sMemo'  => array('name' => 'sMemo', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '备注信息'),
                'sShpCode'  => array('name' => 'sShpCode', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '办理店铺编码(渠道码)'),
                'sReCardID'  => array('name' => 'sReCardID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '介绍人卡号(推荐码)'),
                'sHealImgURL'  => array('name' => 'sHealImgURL', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '头像'),
            ),
            'increaseBalance' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '会员卡号'),
                'iAddValue'  => array('name' => 'iAddValue', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '充值金额，单位：元，增加用正数，减少用负数'),
                'iGiftValue'  => array('name' => 'iGiftValue', 'type' => 'string', 'require' => true, 'default' => '0', 'desc' => '赠送金额，单位：元，增加用正数，减少用负数'),
                'sMemo'  => array('name' => 'sMemo', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '充值备注'),
            ),
            'getBalanceRules' => array(),
            'getBalanceOrderStatus' => array(
                'sDocEntry'  => array('name' => 'sDocEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '订单主键'),
            ),
            'getAvailableCardId' => array(),
            'getCardTypeList' => array(),
            'getCouponList' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '会员卡号'),
                'sStatus'  => array('name' => 'sStatus', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '状态，可选值:全部/正常/已使用/已过期'),
            ),
            'getShopList' => array(
                'sShpType'  => array('name' => 'sShpType', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '店铺类型 可选值:[直营]/[加盟]/[联营]'),
                'sCity'  => array('name' => 'sCity', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '城市中文名称，不传则列出所有店铺'),
                'sShpName'  => array('name' => 'sShpName', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '店铺名称，通过输入店名搜索店铺'),
            ),
            'getMemberInfo' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '会员卡号'),
                'sMobile'  => array('name' => 'sMobile', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '手机号码'),
                'sWXOpenID'  => array('name' => 'sWXOpenID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信OpenID'),
            ),
            'getUpgradeInfo' => array(),
            'getMemberPayHistoryDetail' => array(
                'sDocEntry'  => array('name' => 'sDocEntry', 'type' => 'string', '`' => true, 'default' => '', 'desc' => '订单主键'),
            ),
            'getMemberPointHistory' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '会员卡号'),
                'sMobile'  => array('name' => 'sMobile', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '手机号码'),
                'sWXOpenID'  => array('name' => 'sWXOpenID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信OpenID'),
            ),
            'getMemberBalanceHistory' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '会员卡号'),
                'sMobile'  => array('name' => 'sMobile', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '手机号码'),
                'sWXOpenID'  => array('name' => 'sWXOpenID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信OpenID'),
            ),
            'getMemberSaleHistoryList' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '会员卡号'),
                'sMobile'  => array('name' => 'sMobile', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '手机号码'),
                'sWXOpenID'  => array('name' => 'sWXOpenID', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信OpenID'),
            ),
            'getMemberSaleHistoryByDetail' => array(
                'sDocEntry'  => array('name' => 'sDocEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '订单主键'),
            ),
            'getMemberSaleHistoryDetail' => array(
                'sDocEntry'  => array('name' => 'sDocEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '订单主键'),
            ),
            'setBalanceOrderStatus' => array(
                'sDocEntry'  => array('name' => 'sDocEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '订单主键'),
                'sStatus'  => array('name' => 'sStatus', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '订单状态'),
            ),
            'setWXCardStatus' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '卡号'),
                'sStatus'  => array('name' => 'sStatus', 'type' => 'string', 'require' => true, 'default' => '0', 'desc' => '微信状态，值域:0-未加入卡包;1-已加入卡包'),
            ),
            'setWXCouponStatus' => array(
                'sCouponNO'  => array('name' => 'sCouponNO', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '券号'),
                'sStatus'  => array('name' => 'sStatus', 'type' => 'string', 'require' => true, 'default' => '0', 'desc' => '微信状态，值域:0-未加入卡包;1-已加入卡包'),
            ),
            'setPoint' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '会员卡号'),
                'iChangeValue'  => array('name' => 'iChangeValue', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '调整值，增加用正数，减少用负数'),
                'sMemo'  => array('name' => 'sMemo', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '调整原因'),
            ),
            'updateMemberInfo' => array(
                'sDocEntry'  => array('name' => 'sDocEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '主键'),
                'sVIPName'  => array('name' => 'sVIPName', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '顾客姓名，长度不超过30'),
                'sSex'  => array('name' => 'sSex', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '性别[先生]/[女士]'),
                'sMobile'  => array('name' => 'sMobile', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '手机号码'),
                'sWXName'  => array('name' => 'sWXName', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信昵称，长度不超过50'),
                'iBirthMon'  => array('name' => 'iBirthMon', 'type' => 'string', 'require' => false, 'default' => '0', 'desc' => '顾客生日月份值(一年中的第几月)'),
                'iBirthDayA'  => array('name' => 'iBirthDayA', 'type' => 'string', 'require' => false, 'default' => '0', 'desc' => '顾客生日天数值(一月中的第几天)'),
                'sPhone'  => array('name' => 'sPhone', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '固定电话，仅允许数字，长度不超过20'),
                'sIDCard'  => array('name' => 'sIDCard', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '身份证号码，仅允许数字，长度15或18'),
                'sAddress'  => array('name' => 'sAddress', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '地址'),
                'dBirthday'  => array('name' => 'dBirthday', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '生日(日期格式:yyyy-MM-dd)'),
                'sEmail'  => array('name' => 'sEmail', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '邮箱地址'),
                'sMemo'  => array('name' => 'sMemo', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '备注信息'),
            ),
            'setCouponUsed' => array(
                'sCouponNO'  => array('name' => 'sCouponNO', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '券号'),
            ),
            'addBalanceOrder' => array(
                'sCardID'  => array('name' => 'sCardID', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '会员卡号'),
            ),
            'getBrandList' => array(
                'sShpEntry'  => array('name' => 'sShpEntry', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '店铺系统编码（可通过Get_ShpList返回值查询）'),
            ),
            'getGroupList' => array(
                'sShpEntry'  => array('name' => 'sShpEntry', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '店铺系统编码（可通过Get_ShpList返回值查询）'),
            ),
            'getCustom' => array(
                'sCardCode'  => array('name' => 'sCardCode', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '客户编号'),
            ),
            'getCustomHistory' => array(
                'sCardCode'  => array('name' => 'sCardCode', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '客户编号'),
                'dStartDate'  => array('name' => 'dStartDate', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '查询开始日期，格式:YYYY-MM-dd'),
                'dEndDate'  => array('name' => 'dEndDate', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '查询截止日期，格式:YYYY-MM-dd'),
            ),
            'getItemList' => array(
                'sDate'  => array('name' => 'sCardCode', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '档案建立日期或更新日期，格式:yyyy-MM-dd'),
                'iPage'  => array('name' => 'dEndDate', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '页号(从第1页开始)'),
                'iPageSize'  => array('name' => 'dStartDate', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '页大小，页记录数。(默认每页300条记录)'),
            ),
            'getItemListBySale' => array(
                'iShpEntry'  => array('name' => 'iShpEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '店铺系统编码（可通过Get_ShpList返回值获得）'),
                'sGroupName'  => array('name' => 'sGroupName', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '商品分类名称（不传则列出所有可售商品）'),
                'sItemCode'  => array('name' => 'sItemCode', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '商品编码（不传则列出所有可售商品）'),
            ),
            'getItemListWithStock' => array(
                'sDate'  => array('name' => 'sDate', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '档案建立日期或更新日期，格式:yyyy-MM-dd'),
                'iWhsEntry'  => array('name' => 'iWhsEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '仓库主键'),
                'iPage'  => array('name' => 'dEndDate', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '页号(从第1页开始)'),
                'iPageSize'  => array('name' => 'dStartDate', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '页大小，页记录数。(默认每页300条记录)'),
            ),
            'getOrderDetail' => array(
                'sDocEntry'  => array('name' => 'sDocEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '订单系统编码'),
            ),
            'getShpInfor' => array(
                'sShpCode'  => array('name' => 'sShpCode', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '店铺编码'),
            ),
            'reportStockQuery' => array(
                'sItemCode'  => array('name' => 'sItemCode', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '商品编号'),
            ),
            'setPassword' => array(
                'sUserEntry'  => array('name' => 'sUserEntry', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '用户主键'),
                'sOldPassword'  => array('name' => 'sOldPassword', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '原密码'),
                'sNewPassword'  => array('name' => 'sNewPassword', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '修改后密码'),
            ),
            'reportStockQueryTotal' => array(
                'sItemCode'  => array('name' => 'sItemCode', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '商品编号'),
            ),
        ));
    }
    
    /**
     * 商品库存查询(汇总)
     * @desc 商品库存查询(汇总)
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function reportStockQueryTotal() {
        $data = $this->retriveRuleParams('reportStockQueryTotal');
        $regulation['sItemCode'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->reportStockQueryTotal($data);
    }
    
    /**
     * 修改当前用户密码
     * @desc 修改当前用户密码
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function setPassword() {
        $data = $this->retriveRuleParams('setPassword');
        $regulation['sUserEntry'] = 'required';
        $regulation['sOldPassword'] = 'required';
        $regulation['sNewPassword'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->setPassword($data);
    }
    
    /**
     * 商品库存查询
     * @desc 商品库存查询
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function reportStockQuery() {
        $data = $this->retriveRuleParams('reportStockQuery');
        $regulation['sItemCode'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->reportStockQuery($data);
    }
    
    /**
     * 获取门店详细信息
     * @desc 获取门店详细信息
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getShpInfor() {
        $data = $this->retriveRuleParams('getShpInfor');
        $regulation['sShpCode'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getShpInfor($data);
    }
    
    /**
     * 查询客户订单详情
     * @desc 查询客户订单详情
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getOrderDetail() {
        $data = $this->retriveRuleParams('getOrderDetail');
        $regulation['sDocEntry'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getOrderDetail($data);
    }
    
    /**
     * 获取商品列表
     * @desc 含库存
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getItemListWithStock() {
        $data = $this->retriveRuleParams('getItemListWithStock');
        $regulation['sDate'] = 'required';
        $regulation['iWhsEntry'] = 'required';
        $regulation['iPage'] = 'required';
        $regulation['iPageSize'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getItemListWithStock($data);
    }
    
    /**
     * 查询客户往来帐
     * @desc 查询客户往来帐
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getCustomHistory() {
        $data = $this->retriveRuleParams('getCustomHistory');
        $regulation['sCardCode'] = 'required';
        $regulation['dStartDate'] = 'required';
        $regulation['dEndDate'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getCustomHistory($data);
    }
    
    /**
     * 查询客户信息
     * @desc 查询客户信息
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getCustom() {
        $data = $this->retriveRuleParams('getCustom');
        return $this->dm->getCustom($data);
    }
    
    /**
     * 获取商品类别列表
     * @desc 获取商品类别列表
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getGroupList() {
        $data = $this->retriveRuleParams('getGroupList');
        return $this->dm->getGroupList($data);
    }
    
    /**
     * 获取商品列表
     * @desc 获取商品列表
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getItemList () {
        $data = $this->retriveRuleParams('getItemList');
        $regulation['sDate'] = 'required';
        $regulation['iPageSize'] = 'required';
        $regulation['iPage'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getItemList($data);
    }
    
    /**
     * 获取销售商品列表
     * @desc 获取销售商品列表
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getItemListBySale () {
        $data = $this->retriveRuleParams('getItemListBySale');
        $regulation['iShpEntry'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getItemListBySale($data);
    }
    
    /**
     * 获取商品品牌列表
     * @desc 获取商品品牌列表
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getBrandList() {
        $data = $this->retriveRuleParams('getBrandList');
        return $this->dm->getBrandList($data);
    }
    
    /**
     * POS登录接口服务
     * @desc POS登录接口服务，在调用其他POS接口前先调用一遍这个接口
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function posLogin() {
        return $this->dm->login();
    }
    
    /**
     * 会员注册接口服务
     * @desc 会员注册接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function addUser() {
        $data = $this->retriveRuleParams('addUser');
        $regulation['sVIPName'] = 'required';
        $regulation['sCardID'] = 'required';
        $regulation['sTypeID'] = 'required';
        $regulation['sSex'] = 'required';
        $regulation['sMobile'] = 'required|phone';
        \App\Verification($data, $regulation);
        return $this->dm->addUser($data);
    }
    
    /**
     * 储值卡充值接口服务
     * @desc 储值卡充值接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function increaseBalance() {
        $data = $this->retriveRuleParams('increaseBalance');
        $regulation['sCardID'] = 'required';
        $regulation['iAddValue'] = 'required';
        $regulation['iGiftValue'] = 'required';
        $regulation['sMemo'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->increaseBalance($data);
    }
    
    /**
     * 获取充值规则接口服务
     * @desc 获取充值规则接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getBalanceRules() {
        return $this->dm->getBalanceRules();
    }
    
    /**
     * 获取储值卡充值订单状态接口服务
     * @desc 获取储值卡充值订单状态接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getBalanceOrderStatus() {
        $data = $this->retriveRuleParams('getBalanceOrderStatus');
        $regulation['sDocEntry'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getBalanceOrderStatus($data);
    }
    
    /**
     * 获取有效的会员卡号接口服务
     * @desc 获取有效的会员卡号接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getAvailableCardId() {
        return $this->dm->getAvailableCardId();
    }
    
    /**
     * 获取会员卡种类接口服务
     * @desc 获取会员卡种类接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getCardTypeList() {
        return $this->dm->getCardTypeList();
    }
    
    /**
     * 查询会员卡用电子券列表接口服务
     * @desc 查询会员卡用电子券列表接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getCouponList() {
        $data = $this->retriveRuleParams('getCouponList');
        $regulation['sCardID'] = 'required';
        $regulation['sStatus'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getCouponList($data);
    }
    
    /**
     * 获取pos门店列表接口服务
     * @desc 获取pos门店列表接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getShopList() {
        $data = $this->retriveRuleParams('getShopList');
        return $this->dm->getShopList($data);
    }
    
    /**
     * 获取会员的基本信息接口服务
     * @desc 获取会员的基本信息接口服务，三个参数至少传入一个
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getMemberInfo() {
        $data = $this->retriveRuleParams('getMemberInfo');
        if ((!isset($data['sCardID']) || empty($data['sCardID'])) && (!isset($data['sMobile']) || empty($data['sMobile'])) && (!isset($data['sWXOpenID']) || empty($data['sWXOpenID']))) {
            throw new BadRequestException('三个参数至少传入一个 ', 1);
        }
        return $this->dm->getMemberInfo($data);
    }
    
    /**
     * 获取会员升级规则接口服务
     * @desc 获取会员升级规则接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getUpgradeInfo() {
        return $this->dm->getUpgradeInfo();
    }
    
    /**
     * 查询收银记录明细接口服务
     * @desc 查询收银记录明细(通过主键)接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getMemberPayHistoryDetail() {
        $data = $this->retriveRuleParams('getMemberPayHistoryDetail');
        $regulation['sDocEntry'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getMemberPayHistoryDetail($data);
    }
    
    /**
     * 查询积分记录接口服务
     * @desc 查询积分记录接口服务，三个参数至少传入一个
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getMemberPointHistory() {
        $data = $this->retriveRuleParams('getMemberPointHistory');
        if ((!isset($data['sCardID']) || empty($data['sCardID'])) && (!isset($data['sMobile']) || empty($data['sMobile'])) && (!isset($data['sWXOpenID']) || empty($data['sWXOpenID']))) {
            throw new BadRequestException('三个参数至少传入一个 ', 1);
        }
        return $this->dm->getMemberPointHistory($data);
    }
    
    /**
     * 查询余额记录接口服务
     * @desc 查询余额记录接口服务，三个参数至少传入一个
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getMemberBalanceHistory() {
        $data = $this->retriveRuleParams('getMemberBalanceHistory');
        if ((!isset($data['sCardID']) || empty($data['sCardID'])) && (!isset($data['sMobile']) || empty($data['sMobile'])) && (!isset($data['sWXOpenID']) || empty($data['sWXOpenID']))) {
            throw new BadRequestException('三个参数至少传入一个 ', 1);
        }
        return $this->dm->getMemberBalanceHistory($data);
    }
    
    /**
     * 查询消费记录接口服务
     * @desc 查询消费记录接口服务，三个参数至少传入一个
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string data.Status 1:登录成功;-1:登录出错
     * @return string msg 错误提示
     */
    public function getMemberSaleHistoryList() {
        $data = $this->retriveRuleParams('getMemberSaleHistoryList');
        if ((!isset($data['sCardID']) || empty($data['sCardID'])) && (!isset($data['sMobile']) || empty($data['sMobile'])) && (!isset($data['sWXOpenID']) || empty($data['sWXOpenID']))) {
            throw new BadRequestException('三个参数至少传入一个 ', 1);
        }
        return $this->dm->getMemberSaleHistoryList($data);
    }
    
    /**
     * 查询消费记录(根据主键)
     * @desc 查询消费记录(根据主键)
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getMemberSaleHistoryDetail() {
        $data = $this->retriveRuleParams('getMemberSaleHistoryDetail');
        $regulation['sDocEntry'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getMemberSaleHistoryDetail($data);
    }
    
    /**
     * 查询消费记录明细接口服务
     * @desc 查询消费记录明细接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function getMemberSaleHistoryByDetail() {
        $data = $this->retriveRuleParams('getMemberSaleHistoryByDetail');
        $regulation['sDocEntry'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->getMemberSaleHistoryByDetail($data);
    }
    
    /**
     * 设定储值卡充值订单状态接口服务
     * @desc 设定储值卡充值订单状态接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function setBalanceOrderStatus() {
        $data = $this->retriveRuleParams('setBalanceOrderStatus');
        $regulation['sDocEntry'] = 'required';
        $regulation['sStatus'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->setBalanceOrderStatus($data);
    }
    
    /**
     * 设置卡在微信卡包中的状态接口服务
     * @desc 设置卡在微信卡包中的状态接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function setWXCardStatus() {
        $data = $this->retriveRuleParams('setWXCardStatus');
        $regulation['sDocEntry'] = 'required';
        $regulation['sStatus'] = 'required';
        \App\Verification($data, $regulation);
        if (!in_array($data['sStatus'], array(0,1))) {
            throw new BadRequestException('sStatus必填', 3);
        }
        return $this->dm->setWXCardStatus($data);
    }
    
    /**
     * 设置券在微信卡包中的状态接口服务
     * @desc 设置券在微信卡包中的状态接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function setWXCouponStatus() {
        $data = $this->retriveRuleParams('setWXCouponStatus');
        $regulation['sDocEntry'] = 'required';
        $regulation['sStatus'] = 'required';
        \App\Verification($data, $regulation);
        if (!in_array($data['sStatus'], array(0,1))) {
            throw new BadRequestException('sStatus必填', 3);
        }
        return $this->dm->setWXCouponStatus($data);
    }
    
    /**
     * 积分调整接口服务
     * @desc 积分调整(用于抽奖)接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function setPoint() {
        $data = $this->retriveRuleParams('setPoint');
        $regulation['sCardID'] = 'required';
        $regulation['iChangeValue'] = 'required';
        $regulation['sMemo'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->setPoint($data);
    }
    
    /**
     * 修改会员信息接口服务
     * @desc 修改会员信息接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function updateMemberInfo() {
        $data = $this->retriveRuleParams('updateMemberInfo');
        $regulation['sDocEntry'] = 'required';
        $regulation['sVIPName'] = 'required';
        $regulation['sSex'] = 'required';
        $regulation['sMobile'] = 'required|phone';
        \App\Verification($data, $regulation);
        return $this->dm->updateMemberInfo($data);
    }
    
    /**
     * 设置券的状态为已用接口服务
     * @desc 设置券的状态为已用接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function setCouponUsed() {
        $data = $this->retriveRuleParams('setCouponUsed');
        $regulation['sCouponNO'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->setCouponUsed($data);
    }
    
    /**
     * 创建储值卡充值订单接口服务
     * @desc 创建储值卡充值订单接口服务
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return string msg 错误提示
     */
    public function addBalanceOrder() {
        $data = $this->retriveRuleParams('addBalanceOrder');
        $regulation['sCardID'] = 'required';
        \App\Verification($data, $regulation);
        return $this->dm->addBalanceOrder($data);
    }

}
