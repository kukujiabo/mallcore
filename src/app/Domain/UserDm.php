<?php

namespace App\Domain;

use App\Service\Crm\UserSv;
/**
 * 用户接口类
 * 
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-09-12
 */
class UserDm {
  
    /**
     * 用户注册
     */
    public function add($data){

        return UserSv::addUser($data);

    }
  
    /**
     * 获取用户信息
     */
    public function getUser($condition){

        return UserSv::getUser($condition);

    }
  
    /**
     * 获取用户列表
     */
    public function queryList($condition){
        
        return UserSv::queryUserList($condition);

    }
  
    /**
     * 获取用户条数
     */
    public function queryCount($condition){
        
        return UserSv::queryCount($condition);

    }
  
    /**
     * 修改用户信息
     */
    public function update($data){

        return UserSv::updates($data);

    }
  
    /**
     * 用户启用
     */
    public function enable($data){

        return UserSv::unlockUser($data['uid']);

    }
  
    /**
     * 用户禁用
     */
    public function disable($data){

        return UserSv::lockUser($data['uid']);

    }
  
    /**
     * 登录
     */
    public function userLogin($data){

        return UserSv::userLogin($data);

    }
  
    /**
     * 注销登录
     */
    public function logout($data){

        return UserSv::logout($data);

    }
  
    /**
     * 获取微信code请求uri
     */
    public function getCode($data){

        return WeixinSv::getUserInfoCodeUri($data['cache_skip_url']);

    }

    /**
     * 绑定手机
     */
    public function bindingsPhone($condition){

        return UserSv::bindingsPhone($condition);

    }

    /**
     * 更换手机号
     */
    public function changePhone($condition) {
    
      return UserSv::changePhone($condition);
    
    }

}
