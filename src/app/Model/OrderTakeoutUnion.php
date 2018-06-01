<?php
namespace App\Model;

class OrderTakeoutUnion extends BaseModel {

  protected $_table = 'v_order_takeout_union_info';

  protected $_queryOptionRule = array(

   'id' => 'in',

   'sn' => 'in',

   'create_time' => 'range',

   'created_at' => 'range',

  );

}
