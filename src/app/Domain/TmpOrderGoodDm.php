<?php
namespace App\Domain;

use App\Service\TmpOrderGoodsSv;

class TmpOrderGoodDm {
	
	public function transferData() {

		$tosv = new TmpOrderGoodsSv();

		$tosv->transferData();

	}

}