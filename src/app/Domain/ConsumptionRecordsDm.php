<?php
namespace App\Domain;

use App\Service\Crm\ConsumptionRecordsSv;

/**
 * 用户消费记录接口
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-20
 */
class ConsumptionRecordsDm {

  /**
   * 新增
   */
  public function add($data) {

    return ConsumptionRecordsSv::addConsumptionRecords($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return ConsumptionRecordsSv::edit($data);
  
  }

  /**
   * 获取Poss数据详情
   */
  public function getPossDetail($condition) {

    return ConsumptionRecordsSv::getPossDetail($condition);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return ConsumptionRecordsSv::getDetail($condition);
  
  }

  /**
   * 获取Poss数据列表
   */
  public function queryPossList($condition) {

    return ConsumptionRecordsSv::getPossList($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return ConsumptionRecordsSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return ConsumptionRecordsSv::getCount($condition);

  }

}
