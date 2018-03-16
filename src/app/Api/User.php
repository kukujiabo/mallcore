<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\UserDm;
use PhalApi\Exception;

/**
 * 2.1 用户接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-12
 */

class User extends BaseApi {
    
    public function getRules() {
        return $this->rules(array(
            'add' => array(
                'type'  => array('name' => 'type', 'type' => 'int', 'require' => true, 'default' => '2', 'desc' => '注册类型 1-后台用户 2-前台会员'),
                'user_name'  => array('name' => 'user_name', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '帐号（手机号码）'),
                'user_password'  => array('name' => 'user_password', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '密码明文'),
            ),
            'userLogin' => array(
                'type'  => array('name' => 'type', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '1-帐号登录 2-微信公众号登录 3-微信小程序登录'),
                'module'  => array('name' => 'module', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '1-会员 2-管理员'),
                'username'  => array('name' => 'username', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '帐号（手机号码）'),
                'password'  => array('name' => 'password', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '密码明文'),
                'code'  => array('name' => 'code', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '微信的code'),
            ),
            'update' => array(
                'way'  => array('name' => 'way', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '途径 1-前台会员 2-后台管理员'),
                'token'  => array('name' => 'token', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户令牌（way为1则必传）'),
                'uid'  => array('name' => 'uid', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户id（way为2则必传）'),
                'user_name'  => array('name' => 'user_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '帐号（手机号码）'),
                'user_password'  => array('name' => 'user_password', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '密码明文'),
                'user_headimg'  => array('name' => 'user_headimg', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户头像'),
                'real_name'  => array('name' => 'real_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '真实姓名'),
                'nick_name'  => array('name' => 'nick_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '昵称'),
                'birthday'  => array('name' => 'birthday', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '生日'),
                'location'  => array('name' => 'location', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '所在地'),
                // 'card'  => array('name' => 'card', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '身份证'),
                'sex'  => array('name' => 'sex', 'type' => 'int', 'require' => false, 'default' => '', 'desc' => '性别 0-保密 1-男 2-女'),
            ),
            'queryList' => array(
                'uid'  => array('name' => 'uid', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户id'),
                'user_name'  => array('name' => 'user_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '帐号（手机号码）'),
                'real_name'  => array('name' => 'real_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '真实姓名'),
                'nick_name'  => array('name' => 'nick_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '昵称'),
                'birthday'  => array('name' => 'birthday', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '生日'),
                'location'  => array('name' => 'location', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '所在地'),
                'sex'  => array('name' => 'sex', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '性别 0-保密 1-男 2-女'),
                'user_tel_bind' => 'user_tel_bind|int|false||手机号是否绑定 0 未绑定 1 绑定',
                'is_system' => 'is_system|int|false||是否是系统后台管理员 0-不是 1-是',
                'is_member' => 'is_member|int|false||是否是前台会员 0-不是 1-是',
                'reg_time' => 'reg_time|string|false||注册时间',
                'fields' => 'fields|string|false|*|查询字段',
                'order' => 'order|string|false||排序',
                'page' => 'page|int|true|1|页码',
                'page_size' => 'page_size|int|true|20|每页数据条数',
            ),
            'queryCount' => array(
                'uid'  => array('name' => 'uid', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户id'),
                'user_name'  => array('name' => 'user_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '帐号（手机号码）'),
                'real_name'  => array('name' => 'real_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '真实姓名'),
                'nick_name'  => array('name' => 'nick_name', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '昵称'),
                'birthday'  => array('name' => 'birthday', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '生日'),
                'location'  => array('name' => 'location', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '所在地'),
                'sex'  => array('name' => 'sex', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '性别 0-保密 1-男 2-女'),
                'user_tel_bind' => 'user_tel_bind|int|false||手机号是否绑定 0 未绑定 1 绑定',
                'is_system' => 'is_system|int|false||是否是系统后台用户 0-不是 1-是',
                'is_member' => 'is_member|int|false||是否是前台会员 0-不是 1-是',
                'reg_time' => 'reg_time|string|false||注册时间',
            ),
            'logout' => array(
                'token'  => array('name' => 'token', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '用户id'),
            ),
            'getCode' => array(
                'cache_skip_url'  => array('name' => 'cache_skip_url', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '域名'),
            ),
            'getUser' => array(
                'way'  => array('name' => 'way', 'type' => 'int', 'require' => true, 'default' => '1', 'desc' => '途径 1-前台会员 2-后台管理员'),
                'token'  => array('name' => 'token', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户令牌（way为1则必传）'),
                'uid'  => array('name' => 'uid', 'type' => 'string', 'require' => false, 'default' => '', 'desc' => '用户id（way为2则必传）'),
            ),
            'bindingsPhone' => array(
                'token'  => array('name' => 'token', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '用户令牌'),
                'phone'  => array('name' => 'phone', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '手机号码'),
                'code'  => array('name' => 'code', 'type' => 'string', 'require' => true, 'default' => '', 'desc' => '手机验证码'),
                'member_name' => 'member_name|string|false||用户姓名',
                'encryptedData' => 'encryptedData|string|false||加密数据（用户信息）',
                'iv' => 'iv|string|false||加密算法的初始向量（用户信息）',
                'session_key' => 'session_key|string|false||会员密钥',
                'appid' => 'appid|string|false||小程序appid',
                'share_code' => 'share_code|string|false||分享码',
            ),
            'changePhone' => array(
            
              'token' => 'token|string|true||用户令牌',

              'phone' => 'phone|string|true||手机号码',

              'code' => 'code|string|true||验证码',
            
            )

        ));
    }
    
    /**
     * 获取用户信息接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return int data.uid 表字段
     * @return int data.instance_id 实例信息
     * @return string data.user_name 用户名
     * @return int data.user_status 用户状态 用户状态1-可用
     * @return string data.user_headimg 用户头像
     * @return int data.is_system 是否是系统后台用户：0-不是，1-是
     * @return int data.is_member 是否是前台会员：0-不是，1-是
     * @return string data.user_tel 手机号
     * @return int data.user_tel_bind 手机号是否绑定：0-未绑定，1-绑定
     * @return string data.user_qq qq号
     * @return int data.qq_openid qq互联id
     * @return int data.qq_info qq账号相关信息
     * @return string data.user_email 邮箱
     * @return int data.user_email_bind 邮箱是否绑定
     * @return string data.wx_openid 微信用户openid
     * @return string data.wx_sub_time 微信用户关注时间
     * @return string data.wx_notsub_time 微信用户取消关注时间
     * @return int data.wx_is_sub 微信用户是否关注
     * @return string data.wx_info 微信用户信息
     * @return string data.other_info 附加信息
     * @return string data.reg_time 注册时间
     * @return string data.current_login_ip 当前登录ip
     * @return string data.current_login_time 当前登录时间
     * @return string data.current_login_type 当前登录的操作终端类型
     * @return string data.last_login_time 上次登录时间
     * @return string data.last_login_ip 上次登录ip
     * @return string data.last_login_type 上次登录的操作终端类型
     * @return int data.login_num 登录次数
     * @return string data.real_name 真实姓名
     * @return int data.sex 性别：0保密，1男，2女
     * @return string data.birthday 生日
     * @return string data.location 所在地
     * @return string data.nick_name 用户昵称
     * @return string data.wx_unionid 微信unionid
     * @return int data.qrcode_template_id 模板id
     * @return string msg 错误提示
     */
    public function getUser() {
        
        $regulation = array(

          'way' => 'required',

        );

        $conditions = $this->retriveRuleParams('getUser');

        \App\Verification($conditions, $regulation);

        if ($conditions['way'] == 2 && !isset($conditions['uid'])) {

            throw new Exception('用户uid不能为空', 2002);

        }

        return $this->dm->getUser($conditions);

    }
    
    /**
     * 获取用户列表接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果参数集
     * @return int data.total 数据总条数
     * @return int data.page 当前页码
     * @return int data.list[] 数据队列
     * @return int data.list[].uid 表字段
     * @return int data.list[].instance_id 实例信息
     * @return string data.list[].user_name 用户名
     * @return int data.list[].user_status 用户状态 用户状态1-可用
     * @return string data.list[].user_headimg 用户头像
     * @return int data.list[].is_system 是否是系统后台用户：0-不是，1-是
     * @return int data.list[].is_member 是否是前台会员：0-不是，1-是
     * @return string data.list[].user_tel 手机号
     * @return int data.list[].user_tel_bind 手机号是否绑定：0-未绑定，1-绑定
     * @return string data.list[].user_qq qq号
     * @return int data.list[].qq_openid qq互联id
     * @return int data.list[].qq_info qq账号相关信息
     * @return string data.list[].user_email 邮箱
     * @return int data.list[].user_email_bind 邮箱是否绑定
     * @return string data.list[].wx_openid 微信用户openid
     * @return string data.list[].wx_sub_time 微信用户关注时间
     * @return string data.list[].wx_notsub_time 微信用户取消关注时间
     * @return int data.list[].wx_is_sub 微信用户是否关注
     * @return string data.list[].wx_info 微信用户信息
     * @return string data.list[].other_info 附加信息
     * @return string data.list[].reg_time 注册时间
     * @return string data.list[].current_login_ip 当前登录ip
     * @return string data.list[].current_login_time 当前登录时间
     * @return string data.list[].current_login_type 当前登录的操作终端类型
     * @return string data.list[].last_login_time 上次登录时间
     * @return string data.list[].last_login_ip 上次登录ip
     * @return string data.list[].last_login_type 上次登录的操作终端类型
     * @return int data.list[].login_num 登录次数
     * @return string data.list[].real_name 真实姓名
     * @return int data.list[].sex 性别：0保密，1男，2女
     * @return string data.list[].birthday 生日
     * @return string data.list[].location 所在地
     * @return string data.list[].nick_name 用户昵称
     * @return string data.list[].wx_unionid 微信unionid
     * @return int data.list[].qrcode_template_id 模板id
     * @return string msg 错误提示
     */
    public function queryList() {

        $regulation = array(

          'page' => 'required',

          'page_size' => 'required',

        );

        $conditions = $this->retriveRuleParams('queryList');

        \App\Verification($conditions, $regulation);

        return $this->dm->queryList($conditions);

    }
    
    /**
     * 获取用户条数接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return int data 用户总数
     * @return string msg 错误提示
     */
    public function queryCount() {

        $regulation = array(

        );

        $params = $this->retriveRuleParams('queryCount');

        \App\Verification($params, $regulation);

        return $this->dm->queryCount($params);

    }
    
    /**
     * 用户注册接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return boolean data true
     * @return string msg 错误提示
     */
    public function add() {

        $regulation = array(

          'type' => 'required',

          'user_name' => 'required',

          'user_password' => 'required',

        );

        $params = $this->retriveRuleParams('add');

        \App\Verification($params, $regulation);

        return $this->dm->add($params);
    }
    
    /**
     * 用户登录接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data 用户令牌
     * @return string msg 错误提示
     */
    public function userLogin() {

        $regulation = array(

          'type' => 'required',

          'module' => 'required',

        );

        $conditions = $this->retriveRuleParams('userLogin');

        \App\Verification($conditions, $regulation);

        if (($conditions['type'] == 2 || $conditions['type'] == 3) && !isset($conditions['code'])) {

            throw new Exception('code 必传');

        } elseif ($conditions['type'] == 1 && (!isset($conditions['username']) || !isset($conditions['password']))) {

            throw new Exception('username 和 password必传');

        }

        return $this->dm->userLogin($conditions);

    }
    
    /**
     * 更新用户信息接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return int data 修改成功的条数
     * @return string msg 错误提示
     */
    public function update() {

        $regulation = array(

          'way' => 'required',

        );

        $params = $this->retriveRuleParams('update');

        \App\Verification($params, $regulation);

        if ($params['way'] == 1 && !$params['token']) {

            throw new Exception('token 必传');
            
        } elseif ($params['way'] == 2 && !$params['uid']) {

            throw new Exception('uid 必传');

        }

        return $this->dm->update($params);

    }
    
    /**
     * 用户等登出接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data true
     * @return string msg 错误提示
     */
    public function logout() {

        $regulation = array(

          'token' => 'required',

        );

        $params = $this->retriveRuleParams('logout');

        \App\Verification($params, $regulation);

        return $this->dm->logout($params);

    }
    
    /**
     * 获取code的uri接口服务
     * @desc 
     * @return int ret 操作状态：200表示成功
     * @return array data true
     * @return string msg 错误提示
     */
    public function getCode() {

        $regulation = array(

          'cache_skip_url' => 'required',

        );

        $params = $this->retriveRuleParams('getCode');

        \App\Verification($params, $regulation);

        return $this->dm->getCode($params);

    }
    
    /**
     * 绑定用户手机接口服务
     * @desc
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果集
     * @return string data.card_id 卡号
     * @return string msg 错误提示
     */
    public function bindingsPhone() {

        $regulation = array(

          'token' => 'required',

          'phone' => 'required|phone',

          'code' => 'required',

        );

        $params = $this->retriveRuleParams('bindingsPhone');

        \App\Verification($params, $regulation);

        return $this->dm->bindingsPhone($params);

    }

    /**
     * 修改用户手机号
     * @desc 修改用户手机号
     *
     * @return int ret 操作状态：200表示成功
     * @return array data[] 结果集
     * @return string int 卡号
     * @return string msg 错误提示
     */
    public function changePhone() {
    
      return $this->dm->changePhone($this->retriveRuleParams(__FUNCTION__));
    
    }

}
