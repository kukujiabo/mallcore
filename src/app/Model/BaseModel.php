<?php
namespace App\Model;

use Core\Model\Model;
use Core\Model\CURD;
use Core\Model\FieldFilter;

/**
 * 模型层基类
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-11
 */
class BaseModel extends Model {

  use CURD;

  use FieldFilter;

}
