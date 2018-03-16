<?php
namespace App\Service\Test;

use App\Library\Sms;

class TestSv {

  public function testSendSms() {
  
    return Sms::sendSms('15201932985', 'zXuip3', array('code' => 123123));
  
  }


}
