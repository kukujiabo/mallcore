<?php
namespace App\Library;

/**
 * 字段验证
 */
class Verification {

  /**
   * 字段验证
 * @param array $data 被验证的数组
 * @param array $regulation 验证的字段数组
 * @param array $regulation[].required|max:250|min:1|unique:posts|email|phone|numberMax:300|numberMin:1|identity 必传
   */
  public function index($data, $regulation) {
    foreach ($regulation as $k => $v) {
      $v_ay = explode('|', $v);
      foreach ($v_ay as $vo) {
        $v_ay_t = explode(':', $vo);
        if ($v_ay_t[0] == 'required' && !isset($data[$k])) {
            throw new \Exception($k."必填");
        }
        if ($v_ay_t[0] == 'max' && strlen($data[$k]) > $v_ay_t[1]) {
            throw new \Exception($k."长度不能大于".$v_ay_t[1]);
        }
        if ($v_ay_t[0] == 'min' && strlen($data[$k]) < $v_ay_t[1]) {
            throw new \Exception($k."长度不能小于".$v_ay_t[1]);
        }
        if ($data[$k] && $v_ay_t[0] == 'phone' && !\App\verifyPhone($data[$k])) {
            throw new \Exception('手机号格式错误');
        }
        if ($data[$k] && $v_ay_t[0] == 'email' && !\App\verifyEmail($data[$k])) {
          throw new \Exception('邮箱格式错误');
        }
        if ($v_ay_t[0] == 'numberMax' && $data[$k] > $v_ay_t[1]) {
            throw new \Exception($k."不能大于".$v_ay_t[1]);
        }
        if ($v_ay_t[0] == 'numberMin' && $data[$k] < $v_ay_t[1]) {
            throw new \Exception($k."不能小于".$v_ay_t[1]);
        }
        if ($data[$k] && $v_ay_t[0] == 'identity' && !\App\verifyIdentityCard($data[$k])) {
            throw new \Exception('身份证号格式错误');
        }
      }
      if ($k == 'way') {
        if ($data[$k] == 1 && !isset($data['token'])) {
          throw new \Exception('用户令牌token不能为空');
        }
      }
    }
  }

}
