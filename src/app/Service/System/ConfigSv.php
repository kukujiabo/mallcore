<?php
namespace App\Service\System;

use App\Service\BaseService;
use App\Interfaces\System\IConfig;
use App\Model\Config;
use Core\Service\CurdSv;
use App\Library\RedisClient;

class ConfigSv extends BaseService implements IConfig {

    public static $configValues = array();

    use CurdSv;

    /**
     * 1.根据模块获取配置项
     * @param string $module
     */
    public function getConfigByModule($module){
        
        $where['module'] = $module;

        return self::queryList($where);

    }

    /**
     * 2.根据key获取配置value
     * @param string $key
     */
    public function getConfigValueByKey($key){

      if (!self::$configValues[$key]) {

        $where['k_name'] = $key;

        self::$configValues[$key] = Config::getField($where, 'val');

      }

      return self::$configValues[$key];

    }

    /**
     * 添加
     */
    public function addConfig($data) {

        $data['created_at'] = date("Y-m-d H:i:s");

        return self::add($data);

    }

    /**
     * 修改
     */
    public function edit($data) {

        if ($condition['id']) {

            $id = $data['id'];

        }

        unset($data['id']);

        if (!$id) {

            return false;

        }

        return self::update($id, $data);
    }

    /**
     * 保存微信公众号配置信息
     *
     * @param array $params
     *
     * @return int num
     */
    public function saveWxPubSv($params) {
    
      return self::saveByKname($params);
    
    }

    /**
     * 获取微信公众号配置信息
     *
     * @param array $params
     *
     * @return array $list
     */
    public function getWxPubSv($params) {
    
      $results = self::all(array('sub_module' => $params['sub_module']));

      $configs = array();

      foreach($results as $result) {
      
        $configs[$result['k_name']] = $result['val'];
      
      }

      return $configs;

    }

    /**
     * 根据k_name保存数据
     *
     * @param array $params
     *
     * @return int num
     */
    public function saveByKname($data) {

      $keys = array();

      $values = array();

      $num = 0;

      foreach($data as $key => $val) {
      
        $where = array('k_name' => $key);

        $value = array('val' => $val);

        $num += self::batchUpdate($where, $value);
      
      }
    
      return $num;
    
    }

}

