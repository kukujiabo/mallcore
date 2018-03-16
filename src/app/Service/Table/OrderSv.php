<?php

namespace App\Server\Table;

use App\Service\BaseService;
use App\Interfaces\TableOrder\IOrder;
use App\Model\Order;
use Core\Service\CurdSv;

/**
 * 点餐订单接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-09
 */
class OrderSv extends BaseService implements IOrder {

    use CurdSv;

    /**
     * 新增订单
     *
     * @param mixed $data
     * @param int    $data['order_type']        订单类型
     * @param int    $data['shipping_type']     订单配送方式
     * @param int    $data['order_from']        订单来源
     * @param int    $data['buyer_id']          买家
     * @param string $data['user_name']         买家会员昵称
     * @param string $data['receiver_name']     收货人姓名
     * @param string $data['receiver_mobile']   收货人的手机号码
     * @param int    $data['receiver_province'] 收货人所在省
     * @param int    $data['receiver_city']     收货人所在城市
     * @param int    $data['receiver_district'] 收货人所在街道
     * @param string $data['receiver_address']  详细地址
     * @param int    $data['shop_id']           卖家店铺id
     * @param string $data['shop_name']         卖家店铺名称
     * @param string $data['goods_money']       商品总价
     * @param string $data['order_money']       订单总价
     * @param int    $data['point']             订单消耗积分
     * @param string $data['point_money']       订单消耗积分抵多少钱
     * @param string $data['coupon_money']      订单代金券支付金额
     * @param int    $data['coupon_id']         订单代金券id
     * @param string $data['user_money']        订单余额支付金额
     * @param string $data['promotion_money']   订单优惠活动金额
     * @param string $data['shipping_money']    订单运费
     * @param string $data['pay_money']         订单实付金额
     * @param int    $data['order_status']      订单状态
     * @param int    $data['pay_status']        订单付款状态
     *
     * @return int $id
     */
    public function add ($data) {}
    
    /**
     * 订单号生成
     * @return type
     */
    public function createOrderSn($customer_id){
        $time = date('YmdHis');
        $order_sn = $time.$customer_id.rand(100,999);
        $order_count = CurdSv::queryCount(array('order_no' => $order_sn));
        if($order_count > 0){
            $order_sn = self::createOrderSn($customer_id);
        }
        return $order_sn;
    }

}
