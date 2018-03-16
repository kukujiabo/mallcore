<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Interfaces\Crm\IShareAccept;
use App\Model\ShareAccept;

/**
 * 用户接受推荐记录表
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-09
 */
class ShareAcceptSv extends BaseService implements IShareAccept {

  use CurdSv;


}
