<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\NationwideAreaDm;
use PhalApi\Exception\BadRequestException;

/**
 * 4.1 全国地区接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class NationwideArea extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

      'queryList' => array(

        'type' => 'type|string|true||1-区域 2-省 3-市 4-区',

        'parent_id' => 'parent_id|int|false||父级id',

      ),

      'getAddress' => array(

        'latitude' => 'latitude|float|true||纬度，范围为-90~90，负数表示南纬',

        'longitude' => 'longitude|float|true||经度，范围为-180~180，负数表示西经',

      ),

      'cascadeList' => array(
      
      
      ),

      'update' => array(
      
        'id' => 'id|string|true||地区id',

        'name' => 'name|string|false||地区名',

        'parent' => 'parent|string|false||父级',

        'active' => 'active|int|false||状态：1，有效；0，无效',
      
      ),

      'queryCity' => array(
      
        'name' => 'name|string|false||城市名称',

        'id' => 'id|int|false||城市id'
      
      )
      
    ));

  }

  /**
   * 查询经纬度地址接口服务
   * @desc 获得经纬度所在的省市区
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string data.nation 国家名称
   * @return string data.province 省名称
   * @return string data.city 市名称
   * @return string data.district 区/县名称
   * @return string data.street 街道地址
   * @return string data.street_number 街道号码
   * @return int data.province_code 省 行政区划代码
   * @return int data.city_code 市 行政区划代码
   * @return int data.district_code 区/县 行政区划代码
   * @return string msg 错误提示
   */
  public function getAddress() {

    $conditions = $this->retriveRuleParams('getAddress');

    $regulation = array(

      'latitude' => 'required',

      'longitude' => 'required',

    );

    \App\Verification($conditions, $regulation);

    return $this->dm->getAddress($conditions);

  }

  /**
   * 查询全国地区接口服务
   * @desc 查询全国地区接口服务
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data[].id 序号
   * @return array data[].name 名称
   * @return array data[].parent_id 父类id
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    $regulation = array();

    \App\Verification($conditions, $regulation);

    if (!in_array($conditions['type'], array(1,2,3,4))) {

      throw new BadRequestException('type必须为有效值', 14);

    }

    /*if (($conditions['type'] == 3 || $conditions['type'] == 4) && empty($conditions['parent_id'])) {

      throw new BadRequestException('parent_id必须为有效值', 15);

    }*/

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询级联地区列表
   * @desc 查询级联地区列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return array data[].id 序号
   * @return array data[].name 名称
   * @return array data[].parent_id 父类id
   * @return string msg 错误提示
   */
  public function cascadeList() {
  
    return $this->dm->cascadeList();
  
  }

  /**
   * 更新行政区信息
   * @desc 更新行政区信息
   *
   * @return boolean true/false
   */
  public function update() {

    $data = $this->retriveRuleParams('update');
  
    return $this->dm->update($data);
  
  }

  /**
   * 查询城市数据
   * @desc 查询城市数据
   *
   * @return array list
   */
  public function queryCity() {
  
    $data = $this->retriveRuleParams('queryCity');
  
    return $this->dm->queryCity($data);
  
  }

}
