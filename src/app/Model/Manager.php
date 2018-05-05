<?php
namespace App\Model;

/**
 * 项目经理
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class Manager extends BaseModel {

  protected $_queryOptionRule = array(

    'name' => 'like',

    'phone' => 'like',

  );

}
