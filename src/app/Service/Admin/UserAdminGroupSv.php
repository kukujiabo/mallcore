<?php

namespace App\Service\Admin;

use App\Service\BaseService;
use App\Interfaces\Admin\IUserAdminGroup;
use App\Model\UserAdminGroup;
use Core\Service\CurdSv;

/**
 * 后台管理员角色关联操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserAdminGroupSv extends BaseService implements IUserAdminGroup {

    use CurdSv;

}
