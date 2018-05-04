<?php
namespace App\Model;

class Provider extends BaseModel {

  protected $_queryOptionRule = array(
      'pname' => 'like',
      'contact' => 'like',
      'phone' => 'like'
  );

}
