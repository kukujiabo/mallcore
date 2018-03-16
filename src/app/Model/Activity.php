<?php
namespace App\Model;

/**
 * [模型层] 系统定义活动
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-24
 */
class Activity extends BaseModel {

  protected $_queryOptionRule = array(

    'activity_name' => 'like',

    'activity_code' => 'like',

    'activity_shops' => 'like',

  );

}
