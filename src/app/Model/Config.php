<?php
namespace App\Model;

/**
 * [模型层] 网站配置信息
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-05
 */
class Config extends BaseModel {

    protected $_table = 'configuration';

    protected $_queryOptionRule = array(

        'created_at' => 'range',

    );

    /**
     * 获取网站配置信息字段名
     * @param array  $where 查询条件
     * @param string $field 字段名
     */
    public static function getField(array $where, $field) {
        $info = \PhalApi\DI()->notorm->configuration->where($where)->fetchOne($field);
        return $info;
    }

}
