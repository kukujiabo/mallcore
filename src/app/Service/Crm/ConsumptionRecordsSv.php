<?php
namespace App\Service\Crm; 

use App\Service\BaseService;
use App\Interfaces\Crm\IConsumptionRecords;
use App\Model\ConsumptionRecords;
use Core\Service\CurdSv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Poss\PosSv;
use App\Service\Crm\UserSv;

/**
 *
 * 用户消费记录接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-20
 *
 */
class ConsumptionRecordsSv extends BaseService implements IConsumptionRecords {
  
  use CurdSv;

  /**
   * 添加
   */
  public function addConsumptionRecords($data) {

    $data['created_at'] = date('Y-m-d H:i:s');

    try{

      return self::add($data);

    } catch (\Exception $e){

      throw new InternalServerErrorException('新增失败', 1);

    }

  }

  /**
   * 获取poss消费记录列表
   */
  public function getPossList($condition) {

    $info_user = UserSv::getUserByToken($condition['token']);

    $condition['uid'] = $info_user['uid'];

    $where_member_account['uid'] = $condition['uid'];

    $info_member_account = MemberAccountSv::findOne($where_member_account);

    $list = PosSv::getMemberSaleHistoryList(array('sCardID'=>$info_member_account['card_id']), 'En');

    $info = \App\pageDispose($list, $condition['page'], $condition['page_size']);

    $list = array();

    foreach ($info['list'] as $k => $v) {

      $array = array();

      $array['id'] = $v['DocEntry'];

      $array['seq'] = $v['DocNum'];

      $array['created_at'] = $v['SaleDate'];

      $array['title'] = $v['ShpName'];

      $array['money'] = $v['Price'];

      $list[] = $array;

    }

    $info['list'] = $list;

    return $info;

  }

  /**
   * 获取列表
   */
  public function getList($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['token']);

    unset($condition['way']);

    return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

  }

  /**
   * 获取poss详情
   */
  public function getPossDetail($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

    }

    // 消费记录明细
    $list = PosSv::getMemberSaleHistoryByDetail($condition['id']);

    $record = $list[0];

    $info = array();

    $info['id'] = $record['主键'];
    
    $info['seq'] = $record['单号'];

    $info['created_at'] = $record['销售日期'];

    $info['title'] = $record['销售店铺'];

    $info['money'] = $record['金额'];

    $info['barcode'] = \App\barCode($record['单号'], 2, 66, array(1,1,1), true);

    // 消费记录明细
    $goods = PosSv::getMemberSaleHistoryDetail($condition['id']);

    $info['goods'] = array();

    foreach ($goods as $v) {

      $array = array();

      $array['goods_name'] = $v['商品名称'];

      $array['num'] = $v['数量'];

      $array['price'] = $v['单价'];

      $array['goods_money'] = $v['金额'];

      $info['goods'][] = $array;

    }

    // 收银记录明细
    $pay = PosSv::getMemberPayHistoryDetail($condition['id']);

    $info['pay'] = array();

    foreach ($pay as $v) {

      $array = array();

      $array['pay_mode'] = $v['PayMode'];

      $array['price'] = $v['Price'];

      $info['pay'][] = $array;

    }

    return $info;

  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    if ($condition['way'] == 1 && $condition['token']) {

      $info_user = UserSv::getUserByToken($condition['token']);

      $condition['uid'] = $info_user['uid'];

    }

    unset($condition['way']);

    unset($condition['token']);

    $list = ConsumptionRecords::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

    return $list[0];

  }

  /**
   * 获取总数
   */
  public function getCount($condition) {

    return self::queryCount($condition);

  }

  /**
   * 修改
   */
  public function edit($data) {

    if ($data['id']) {

      $condition['id'] = $data['id'];

      unset($data['id']);

    }

    return self::batchUpdate($condition, $data);

  }

}
