<?php
namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Interfaces\Takeaway\IOrderTakeOutGoods;
use App\Model\OrderTakeOutGoods;
use Core\Service\CurdSv;
use App\Service\Commodity\GoodsSv;
use App\Service\Crm\UserSv;
use App\Service\Commodity\GoodsSkuSv;
use PhalApi\Exception;
use App\Service\Takeaway\CartTakeOutSv;
use App\Service\Crm\ManagerSv;
use App\Library\Http;
use App\Service\Crm\MemberSv;

/**
 * 外卖订单商品
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutGoodsSv extends BaseService implements IOrderTakeOutGoods {

    use CurdSv;

    /**
     * 获取订单商品列表
     */
    public function getList($condition) {

        return self::all($condition, $condition['order'], '*');

    }

    /**
     * 添加订单商品
     */
    public function addOrderGoods($data) {

      $data['created_at'] = time();

      return self::add($data);

    }

    /**
     * 批量添加订单商品
     */
    public function addOrderGoodsAll($data, $invoice = 0) {

        $data_goods['uid'] = $data['uid'];

        $data_goods['order_take_out_id'] = $data['order_id'];

        $list_cart_goods = CartTakeOutSv::all(array('cart_id'=>$data['cart_id']));

        foreach ($list_cart_goods as $k => $v) {

            $data_goods['goods_id'] = $data_verify_goods['goods_id'] = $v['goods_id'];

            $data_goods['sku_id'] = $v['sku_id'];

            $data_goods['sku_name'] = $v['sku_name'];

            $data_verify_goods['quantity'] = $v['num'];

            if ($v['sku_id']) {

                $data_verify_goods['sku_id'] = $v['sku_id'];

                // 验证商品
                $info_goods = GoodsSkuSv::verifyGoods($data_verify_goods);

            } else {

                // 验证商品
                $info_goods = GoodsSv::verifyGoods($data_verify_goods);

            }

            $data_goods['goods_name'] = $v['goods_name'];

            $data_goods['price'] = $invoice ? $v['tax_off_price'] : $v['price'];

            $data_goods['cost_price'] = $info_goods['cost_price'];

            $data_goods['no_code'] = $info_goods['no_code'];

            $data_goods['num'] = $v['num'];

            $data_goods['goods_money'] = $v['num'] * ($invoice ? $v['tax_off_price'] : $v['price']);

            $data_goods['goods_picture'] = $v['goods_picture'];

            $data_goods['shop_id'] = $v['shop_id'];

            //$data_goods['id'] = rand(100000000, 999999999);

            $data_goods['created_at'] = time();

            $data_goods_all[] = $data_goods;

        }

        $i = 0;

        foreach($data_goods_all as $good) {
        
          $i++;

          self::add($good);
        
        }

        return $i;

    }

    public function getAll($data) {
    
      return self::all($data);
    
    }

    /**
     * 退货
     *
     */
    public function returnGoods($data) {
    
      $order = OrderTakeOutSv::findOne(array('sn' => $data['sn']));

      $goods = json_decode($data['goods'], true);

      $newOrderGoods = array();

      $i = 0;

      foreach($goods as $good) {
      
        $sku = self::findOne(array('order_take_out_id' => $order['id'], 'no_code' => $good['no_code']));

        unset($sku['id']);

        $sku['num'] = $good['num'] * -1;

        $sku['price'] = $sku['price'] * -1;

        $sku['shop_id'] = 0;

        $sku['goods_money'] = $sku['price'] * $good['num'];

        $sku['returned'] = 1;

        $sku['return_code'] = $data['return_code'];

        $sku['created_at'] = time();

        array_push($newOrderGoods, $sku);
      
      }

      return self::batchAdd($newOrderGoods);
    
    }

    /**
     * 批量退货
     *
     */
    public function batchReturnGoods($data) {
    
      $id = $data['order_take_out_id'];
  
      $info_order = OrderTakeOutSv::findOne($id);

      $goods = OrderTakeOutGoodsSv::all(array('id' => $data['goods_id']));

      $nums = explode(',', $data['num']);

      $goodIds = explode(',', $data['goods_id']);

      $matchIds = array();

      foreach($goodIds as $key => $goodId) {
      
        $matchIds[$goodId] = $nums[$key];
      
      }

      if ($info_order['audit'] == 1) {

        $userInfo = UserSv::findOne($info_order['buyer_id']);

        $member = MemberSv::findOne($info_order['buyer_id']);

        $manager = ManagerSv::findOne(array('phone' => $userInfo['user_tel']));

        $address = OrderTakeOutAddressSv::findOne(array('order_take_out_id' => $info_order['id']));

        $date = date('Y-m-d H:i:s');

        $cretcode = substr(trim($info_order['sn']) . rand(1000, 9999), 4, strlen(trim($info_order['sn'])));

        $signKey = "cretcode={$cretcode}ddate={$date}wechatphone={$userInfo['user_tel']}TunZhoush@$58h";

        $signSecret = md5($signKey);

        if ($userInfo['reference']) {
        
          $cbUser = UserSv::findOne($userInfo['reference']);
        
        }

        $newAsync = array(

          'sign'  => $signSecret,
          'userid' => $info_order['buyer_id'],
          'wechatcode' => $userInfo['wx_openid'],
          'wechatname' => $member['member_name'], //iconv("GBK//IGNORE", "UTF-8", $member['member_name']),
          'wechatphone' => $userInfo['user_tel'],
          'cretcode' => $cretcode,
          'csocode' => trim($info_order['sn']),
          'ddate' => $date,
          'cdepcode' => $info_order['city_code'],
          'binvoice' => $info_order['invoice'],
          "cbuserid" => $cbUser['uid'] ? $cbUser['uid'] : "",
          'cbuserphone' => $cbUser['user_tel'] ? $cbUser['user_tel'] : "",
          'creceiver' => $address['consigner'], // iconv("GBK//IGNORE", "UTF-8", $address['consigner']),
          'creceiveraddress' => $address['address'], // iconv("GBK//IGNORE", "UTF-8", $address['address']),
          'creceiverphone' => $address['mobile'],
          'cmemo' => $order['buyer_message'], // iconv("GBK//IGNORE", "UTF-8", $order['buyer_message']),
          'caccid' => $info_order['cas']
        
        );

        $newAsync['detail'] = array();

        $gids = explode(',', $data['goods_id']);

        foreach($goods as $key => $good) {

          foreach($gids as $ky => $gid) {

            if ($gid == $good['id']) {

              $orderGood = array(
              
                'autoid' => $good['id'],
                'iunsid' => $good['id'],
                'cinvcode' => $good['no_code'],
                'iquantity' => $matchIds[$good['id']],
                'iprice' => abs($good['price']),
                'imoney' => $good['price'] * $nums[$ky]
              
              );

            }

          }

          array_push($newAsync['detail'], $orderGood);

        }

        $header = array( 'Content-Type:application/json;charset=utf-8' );
        
        $response = Http::httpPost("http://58.247.168.34:8008/api/u8/interface/create_salereturnvoucher", json_encode($newAsync), $header);

        $result = json_decode($response, true);

        return $result;

      }
    
    }

}
