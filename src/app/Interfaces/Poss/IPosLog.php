<?php
namespace App\Interfaces\Poss;

/**
 * pos接口调用记录
 */
interface IPosLog {

  /**
   * 1.新增调用记录
   * @param string $userId          用户id
   * @param string $channel         
   * @param string $ip              请求ip地址
   * @param string $apiName         请求接口名称
   * @param string $apiRequestData  接口请求数据
   * @param string $apiReturnData   接口返回数据
   */
  public function addLog($userId, $channel, $ip, $apiName, $apiRequestData, $apiReturnData);


  /**
   * 2.获取调用记录列表
   * @param array $query             查询数组
   * @param string $query['userId']  用户id
   * @param string $query['channel'] 渠道
   * @param string $query['ip']      ip地址
   * @param string $query['apiName'] api名称
   */
  public function getLogs($query);



}
