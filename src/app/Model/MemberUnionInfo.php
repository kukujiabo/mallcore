<?php
namespace App\Model;

/**
 * 用户联合信息
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-09
 */
class MemberUnionInfo extends BaseModel {

  protected $_table = 'v_member_union_data';

  protected $_queryOptionRule = array(

    'reg_time' => 'range',

    'member_name' => 'like',

  );


}
