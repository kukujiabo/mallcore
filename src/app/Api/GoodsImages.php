<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\GoodsImagesDm;

/**
 * 8.6 商品图片接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsImages extends BaseApi {

    /**
     * 接口参数规则
     */
    public function getRules() {

        return $this->rules(array(

            'getAll' => array(

                'goods_id' => 'goods_id|int|true||商品ID',

                'sku_id' => 'sku_id|int|false||sku商品ID',

                'status' => 'status|int|false||商品状态 1-启用 2-禁用',

            ),
          
        ));

    }

    /**
     * 获取商品所有图片
     * @desc 获取商品所有图片
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果集
     * @return string msg 错误提示
     */
    public function getAll() {

        $regulation = array(
            'goods_id' => 'required',
        );

        $params = $this->retriveRuleParams(__FUNCTION__);

        \App\Verification($params, $regulation);

        return $this->dm->getAll($params);
  
    }

}
