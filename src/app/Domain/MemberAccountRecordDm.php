<?php
namespace App\Domain;

use App\Service\Crm\MemberAccountRecordSv;

/**
 * 会员账户记录
 * 
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-07
 */
class MemberAccountRecordDm {

  /**
   * 新增
   */
  public function add($data) {

    return MemberAccountRecordSv::addAccountRecords($data);
  
  }

  /**
   * 编辑
   */
  public function update($data) {

    return MemberAccountRecordSv::edit($data);
  
  }

  /**
   * 获取详情
   */
  public function getDetail($condition) {

    return MemberAccountRecordSv::getDetail($condition);
  
  }

  /**
   * 获取Poss数据列表
   */
  public function queryPossList($condition) {
      
    return MemberAccountRecordSv::getPossList($condition);
  
  }

  /**
   * 获取列表
   */
  public function queryList($condition) {

    return MemberAccountRecordSv::getList($condition);
  
  }

  /**
   * 获取数量
   */
  public function queryCount($condition) {
  
    return MemberAccountRecordSv::getCount($condition);

  }

}
