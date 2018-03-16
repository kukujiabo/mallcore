<?php

namespace App\Service\Admin;

use App\Service\BaseService;
use App\Interfaces\Admin\IUserGroup;
use App\Model\UserGroup;
use Core\Service\CurdSv;

/**
 * 系统用户组操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserGroupSv extends BaseService implements IUserGroup {

    use CurdSv;

}
