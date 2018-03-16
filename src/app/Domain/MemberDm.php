<?php
namespace App\Domain;

use App\Service\Crm\MemberSv;
use App\Service\Crm\MemberUnionInfoSv;

/**
 * 会员
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class MemberDm {
  
  /**
   * 会员每日新增统计表
   */
  public function memberIncrease($data){

    return MemberSv::memberIncrease($data);

  }

  /**
   * 登录
   */
  public function login($data) {

    return MemberSv::login($data);
  
  }

  /**
   * 新增
   */
  public function add($data) {

    return MemberSv::add($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {
    
    return MemberSv::edit($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return MemberSv::getDetail($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return MemberSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return MemberSv::getCount($condition);

  }

  /**
   * 小程序注册
   */
  public function register($data) {
  
    return MemberSv::register($data);

  }

  /**
   * 小程序加密数据解密
   */
  public function decryptData($data) {

    $info = MemberSv::decryptData($data);

    unset($info['watermark']);
  
    return $info;

  }

  /**
   * 获取会员动态二维码
   */
  public function getQrCode($data) {

    return MemberSv::updatePayCode($data);

  }

  /**
   * 获取用户粉丝列表
   */
  public function getFansList($data) {

    return MemberSv::getFansList($data);

  }

  /**
   * 获取用户联合信息列表
   */
  public function memberUnionInfo($data) {
  
    return MemberUnionInfoSv::getList($data);
  
  }

}
