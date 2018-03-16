<?php
namespace App\Domain;

use App\Service\Test\TestSv;

class TestDm {

  public function testSms() {
  
    return TestSv::testSendSms();
  
  }

}
