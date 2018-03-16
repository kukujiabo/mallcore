<?php

namespace App\Service\Admin;

use App\Service\BaseService;
use App\Interfaces\Admin\IUserGroupJurisdiction;
use App\Model\UserGroupJurisdiction;
use Core\Service\CurdSv;

/**
 * 用户组权限操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserGroupJurisdictionSv extends BaseService implements IUserGroupJurisdiction {

    use CurdSv;

}
