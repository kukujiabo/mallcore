<?php

namespace App\Service\Admin;

use App\Service\BaseService;
use App\Service\Crm\UserSv;
use App\Interfaces\Admin\IUserAdmin;
use App\Model\UserAdmin;
use Core\Service\CurdSv;

/**
 * 后台管理员操作接口
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-25
 */
class UserAdminSv extends BaseService implements IUserAdmin {

  use CurdSv;

  /**
   * 管理员登录
   *
   * @param array $data
   * @param string $data.username 管理员账号
   * @param string $data.password 管理员密码
   *
   * @return string $token 管理员令牌
   */
  public function login($data) {

    $data['type'] = 1;

    $data['module'] = 2;

    $token = UserSv::userLogin($data);

    return array( 'token' => $token );

  }

}
