<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Interfaces\Commodity\IGoodsSku;
use App\Model\GoodsSku;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * sku商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsSkuSv extends BaseService implements IGoodsSku {

    use CurdSv;

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
    public function addGoodsSku($data) {

        $data['create_date'] = date("Y-m-d H:i:s");

        self::add($data);

        return $data['sku_id'];

    }

    /**
     * 编辑
     */
    public function edit($data) {

        $condition['sku_id'] = $data['sku_id'];

        unset($data['sku_id']);

        return self::batchUpdate($condition, $data);

    }

    /**
     * 验证
     */
    public function verifyGoods($data) {

        $condition['sku_id'] = $data['sku_id'];

        $condition['goods_id'] = $data['goods_id'];

        $info_sku = self::findOne($condition);

        if (!$info_sku) {

            throw new Exception('sku_id 错误，查不到sku商品数据', 850501);
            
        }

        if ($info_sku['active'] == 2) {

            throw new Exception('sku商品'. $info_sku['sku_name'] .'已下架', 850502);

        }

        if ($data['quantity'] > $info_sku['stock']) {

            throw new Exception('sku商品' . $info_sku['sku_name'] . '库存不足', 850503);

        }

        return $info_sku;

    }

}
