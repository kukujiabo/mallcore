<?php
namespace App\Api;

/**
 * 订单商品临时处理
 */
class TmpOrderGood extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'transferData' => [

			]

		]);

	}

	public function transferData() {

		return $this->dm->transferData($this->retriveRuleParams(__FUNCTION__));

	}

}