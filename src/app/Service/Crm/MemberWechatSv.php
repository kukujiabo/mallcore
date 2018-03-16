<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IMemberWechat;
use Core\Service\CurdSv;


/**
 * 微信公众号用户数据
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-13
 */
class MemberWechatSv extends BaseService implements IMemberWechat {

  use CurdSv;


}
