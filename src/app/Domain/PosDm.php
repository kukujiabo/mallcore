<?php

namespace App\Domain;

use App\Service\Poss\PosSv;
use PhalApi\Exception;
/**
 * POS接口类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-05
 */
class PosDm {
  
    /**
     * 登录
     */
    public function login(){

        return PosSv::login();

    }
  
    /**
     * 会员注册
     */
    public function addUser($data){

        return PosSv::addUser($data);

    }
  
    /**
     * 储值卡充值
     */
    public function increaseBalance($data){

        return PosSv::increaseBalance($data);

    }
  
    /**
     * 获取充值规则
     */
    public function getBalanceRules(){

        return PosSv::getBalanceRules();

    }
  
    /**
     * 获取储值卡充值订单状态
     */
    public function getBalanceOrderStatus($data){

        return PosSv::getBalanceOrderStatus($data['sDocEntry']);

    }
  
    /**
     * 获取有效的会员卡号
     */
    public function getAvailableCardId(){

        return PosSv::getAvailableCardId();

    }
  
    /**
     * 获取会员卡类别列表
     */
    public function getCardTypeList(){
        
        return PosSv::getCardTypeList();

    }
  
    /**
     * 查询会员卡用电子券列表
     */
    public function getCouponList($data){

        return PosSv::getCouponList($data);

    }
  
    /**
     * 获取pos门店列表
     */
    public function getShopList($data){
        
        return PosSv::getShopList($data);

    }
  
    /**
     * 获取会员的基本信息
     * 参数至少传入一个
     */
    public function getMemberInfo($data){

        return PosSv::getMemberInfo($data);

    }
  
    /**
     * 获取会员升级规则
     */
    public function getUpgradeInfo(){

        return PosSv::getUpgradeInfo();

    }
  
    /**
     * 查询收银记录明细(通过主键)
     */
    public function getMemberPayHistoryDetail($data){

        return PosSv::getMemberPayHistoryDetail($data['sDocEntry']);

    }
  
    /**
     * 查询积分记录
     */
    public function getMemberPointHistory($data){

        return PosSv::getMemberPointHistory($data);

    }
  
    /**
     * 查询消费记录
     */
    public function getMemberSaleHistoryList($data){

        return PosSv::getMemberSaleHistoryList($data);

    }
  
    /**
     * 查询余额记录
     */
    public function getMemberBalanceHistory($data){

        return PosSv::getMemberBalanceHistory($data);

    }
  
    /**
     * 查询消费记录明细(通过主键)
     */
    public function getMemberSaleHistoryDetail($data){

        return PosSv::getMemberSaleHistoryDetail( $data['sDocEntry']);

    }
  
    /**
     * 设定储值卡充值订单状态
     */
    public function setBalanceOrderStatus($data){

        return PosSv::setBalanceOrderStatus($data);

    }
  
    /**
     * 设置卡在微信卡包中的状态
     */
    public function setWXCardStatus($data){

        return PosSv::setWXCardStatus($data);

    }
  
    /**
     * 设置券在微信卡包中的状态
     */
    public function setWXCouponStatus($data){

        return PosSv::setWXCouponStatus($data);

    }
  
    /**
     * 积分调整(用于抽奖)
     */
    public function setPoint($data){

        return PosSv::setPoint($data);

    }
  
    /**
     * 修改会员信息
     */
    public function updateMemberInfo($data){

        return PosSv::updateMemberInfo($data);

    }
  
    /**
     * 设置券的状态为已用
     */
    public function setCouponUsed($data){

        return PosSv::setCouponUsed($data['sCouponNO']);

    }
  
    /**
     * 创建储值卡充值订单
     */
    public function addBalanceOrder($data){

        return PosSv::addBalanceOrder($data['sCardID']);

    }
  
    /**
     * 获取商品品牌列表
     */
    public function getBrandList($data){

        return PosSv::getBrandList($data);

    }
  
    /**
     * 查询客户信息
     */
    public function getCustom($data){

        return PosSv::getCustom($data);

    }
  
    /**
     * 查询客户往来帐
     */
    public function getCustomHistory($data){

        return PosSv::getCustomHistory($data);

    }
  
    /**
     * 获取商品类别列表
     */
    public function getGroupList($data){

        return PosSv::getGroupList($data);

    }
  
    /**
     * 获取商品列表
     */
    public function getItemList($data){

        return PosSv::getItemList($data);

    }
  
    /**
     * 获取商品列表(含库存)
     */
    public function getItemListWithStock($data){

        return PosSv::getItemListWithStock($data);

    }
  
    /**
     * 获取销售商品列表
     */
    public function getItemListBySale($data){

        return PosSv::getItemListBySale($data);

    }
  
    /**
     * 查询客户订单详情
     */
    public function getOrderDetail($data){

        return PosSv::getOrderDetail($data);

    }
  
    /**
     * 获取门店详细信息
     */
    public function getShpInfor($data){

        return PosSv::getShpInfor($data);

    }
  
    /**
     * 商品库存查询
     */
    public function reportStockQuery($data){

        return PosSv::reportStockQuery($data);

    }
  
    /**
     * 商品库存查询（汇总）
     */
    public function reportStockQueryTotal($data){

        return PosSv::reportStockQueryTotal($data);

    }
  
    /**
     * 修改当前用户密码
     */
    public function setPassword($data){

        return PosSv::setPassword($data);

    }
  
    /**
     * 查询消费记录(根据主键)
     */
    public function getMemberSaleHistoryByDetail($data){

        return PosSv::getMemberSaleHistoryByDetail($data);

    }

}
