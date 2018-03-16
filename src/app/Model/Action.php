<?php

namespace App\Model;

/**
 * [模型层] 系统定义操作
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-20
 */
class Action extends BaseModel {

  protected $_queryOptionRule = array(

    'created_at' => 'range',

    'updated_at' => 'range',

  );

}
