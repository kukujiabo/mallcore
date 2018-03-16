<?php
namespace App\Service\Poss;

use App\Service\BaseService;
use App\Interfaces\Poss\ISynchronousPoss;
use PhalApi\Exception;
use App\Service\Commodity\GoodsSv;
use App\Service\Poss\PosSv;

/**
 * 同步POSS数据
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-23
 */
class SynchronousPossSv extends BaseService implements ISynchronousPoss {

    /**
     * 同步商品
     */
    public function SynchronousGoods($data) {

        $condition_pos['sDate'] = $data['sDate'];

        $condition_pos['iPage'] = $data['iPage'];

        $condition_pos['iPageSize'] = $data['iPageSize'];

        $goods_list = PosSv::getItemList($condition_pos);

        return $goods_list = json_decode($goods_list, true);

        $data_goods_all = array();

        foreach ($goods_list as $v) {

            $data_goods['DocEntry'] = $v['DocEntry'];

            $data_goods['poos_number'] = $v['商品编号'];

            $data_goods['goods_name'] = $v['商品名称'];

            $data_goods['introduction'] = $v['商品描述'];

            // $data_goods[''] = $v['颜色'];
            // $data_goods[''] = $v['规格型号'];
            // $data_goods[''] = $v['品牌'];
            // $data_goods[''] = $v['商品分类'];
            // $data_goods[''] = $v['年份'];
            // $data_goods[''] = $v['季节'];
            $data_goods['unit'] = $v['单位'];
            // $data_goods[''] = $v['商品中类'];
            // $data_goods[''] = $v['商品小类'];
            // $data_goods[''] = $v['ABC分类'];
            // $data_goods[''] = $v['订货属性'];
            // $data_goods[''] = $v['次级品牌'];
            // $data_goods[''] = $v['国标码'];
            // $data_goods[''] = $v['工厂货号'];
            // $data_goods[''] = $v['产地'];
            // $data_goods[''] = $v['生产厂家'];
            // $data_goods[''] = $v['质保期'];
            // $data_goods[''] = $v['原始编码'];
            // $data_goods[''] = $v['原始名称'];

            $data_goods['market_price'] = $v['进货价'];

            // $data_goods[''] = $v['批发价'];

            $data_goods['price'] = $v['零售价'];

            // $data_goods[''] = $v['商品属性'];
            // $data_goods[''] = $v['不积分'];
            // $data_goods[''] = $v['特价'];
            // $data_goods[''] = $v['允许赠送'];
            // $data_goods[''] = $v['不管库存'];
            // $data_goods[''] = $v['库位标志'];
            
            $data_goods['brand_id'] = $v['品牌编码'];

            $data_goods['category_id'] = $v['商品分类编码'];

            $data_goods['goods_spec_format'] = $v['规格型号编码'];
            $data_goods[''] = $v['色系编码'];
            $data_goods[''] = $v['颜色编码'];
            $data_goods[''] = $v['尺码组'];
            // $data_goods[''] = $v['数值预留C1'];
            // $data_goods[''] = $v['数值预留C2'];
            // $data_goods[''] = $v['数值预留C3'];
            // $data_goods[''] = $v['箱规格'];
            // $data_goods[''] = $v['零散转换'];
            // $data_goods[''] = $v['数值预留C6'];
            // $data_goods[''] = $v['数值预留C7'];
            // $data_goods[''] = $v['数值预留C8'];
            // $data_goods[''] = $v['建档日期'];
            // $data_goods[''] = $v['批次管理'];
            // $data_goods[''] = $v['序列号管理'];
            $data_goods['create_time'] = date('Y-m-d H:i:s');

            $data_goods_all[] = $data_goods;

        }

        return $data_goods_all;

        GoodsSv::batchAdd($data_goods_all);

    }

}
