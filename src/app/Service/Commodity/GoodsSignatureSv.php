<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use Core\Service\CurdSv;

class GoodsSignatureSv extends BaseService {

  use CurdSv;

  public function getAll() {
  
    return self::all(array());
  
  }

}
