<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Interfaces\Commodity\IGoodsAttributeValue;
use App\Model\GoodsAttributeValue;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * 商品属性接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsAttributeValueSv extends BaseService implements IGoodsAttributeValue {

    use CurdSv;

    /**
     * 获取列表
     */
    public function getList($condition) {

        return self::queryList($condition, $condition['fields'], 'sort asc', $condition['page'], $condition['page_size']);

    }

    /**
     * 获取详情
     */
    public function getDetail($condition) {

        return self::findOne($condition);

    }

    /**
     * 新增
     */
    public function addGoodsAttributeValue($data) {

        $data['create_time'] = date("Y-m-d H:i:s");

        self::add($data);

        return $data['attr_value_id'];

    }

    /**
     * 编辑
     */
    public function edit($data) {

        $condition['attr_value_id'] = $data['attr_value_id'];

        unset($data['attr_value_id']);

        return self::batchUpdate($condition, $data);

    }

}
