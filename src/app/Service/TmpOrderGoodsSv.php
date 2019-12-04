<?php
namespace App\Service;

use Core\Service\CurdSv;
use App\Service\Takeaway\OrderTakeOutGoodsSv;
use App\Service\Takeaway\OrderTakeOutSv;
use App\Service\Commodity\GoodsSkuSv;

class TmpOrderGoodsSv extends BaseService {
	
	use CurdSv;

	public function transferData() {

		$datas = $this->all([]);

		$goodsDatas = [];

		foreach($datas as $key => $good) {

			$order = OrderTakeOutSv::findOne([ 'sn' => $good['order_no']]);

			if (!$order) {

				continue;

			}

			$sku = GoodsSkuSv::findOne([ 'no_code' => $good['nocode']]);

			$goodData = [

				'order_take_out_id' => $order['id'],
				'uid' => $order['buyer_id'],
				'goods_id' => $sku['goods_id'],
				'sku_id' => $sku['sku_id'],
				'sku_name' => $sku['sku_name'],
				'price' => $good['single_price'],
				'num' => $good['num'],
				'goods_money' => $good['total'],
				'no_code' => $good['nocode'],
				'returned' => 0,
				'shop_id' => 0

			];

			OrderTakeOutGoodsSv::add($goodData);

		}

	}

}