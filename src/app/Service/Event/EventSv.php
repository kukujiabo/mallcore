<?php
namespace App\Service\Event;

use App\Service\BaseService;
use App\Interfaces\Event\IActionEvent;
use Core\Service\CurdSv;

/**
 * 操作事件接口
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-21
 */
class EventSv extends BaseService {

  use CurdSv;

  const CODESEQ = array(
  
    'coupon' => '1000',

    'point' => '1001',
  
  );

  public function getCode($type) {

    return EventSv::CODESEQ[$type] . time();
  
  }


}
