<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Interfaces\Commodity\IGoodsAttribute;
use App\Model\GoodsAttribute;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * 商品属性接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsAttributeSv extends BaseService implements IGoodsAttribute {

    use CurdSv;

    /**
     * 检验属性唯一编码是否存在
     *
     * @return boolean true/false
     */
    public function existAttrUniKey($key){

    }

    /**
     * 生成属性唯一编码
     *
     * @return string $key
     */
    public function createAttrUniKey(){

    }

    /**
     * 获取列表
     */
    public function getList($condition) {

        return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

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
    public function addGoodsAttribute($data) { 

        $data['create_time'] = date("Y-m-d H:i:s");

        self::add($data);

        return $data['attr_id'];

    }

    /**
     * 编辑
     */
    public function edit($data) {

        $condition['attr_id'] = $data['attr_id'];

        unset($data['attr_id']);

        return self::batchUpdate($condition, $data);

    }

}
