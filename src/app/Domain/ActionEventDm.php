<?php
namespace App\Domain;

use App\Service\Event\ActionEventSv;

class ActionEventDm {

  public function queryList($data) {

    return ActionEventSv::queryList($data, $data['fields'], $data['order'], $data['page'], $data['page_size']); 
  
  }

}
