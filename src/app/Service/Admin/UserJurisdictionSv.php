<?php

namespace App\Service\Admin;

use App\Service\BaseService;
use App\Interfaces\Admin\IUserJurisdiction;
use App\Model\UserJurisdiction;
use Core\Service\CurdSv;

/**
 * 用户权限操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserJurisdictionSv extends BaseService implements IUserJurisdiction {

    use CurdSv;

}
