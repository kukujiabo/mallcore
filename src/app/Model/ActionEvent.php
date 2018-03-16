<?php
namespace App\Model;

class ActionEvent extends BaseModel {

  protected $_primaryKey = 'action_code';

  protected $_table = 'v_action_events';

  protected $_queryOptionRule = array(

    'validate_start' => 'range',

    'validate_end' => 'range',

  );

}
