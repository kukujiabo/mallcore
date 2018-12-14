<?php
namespace Core\Response;

use PhalApi\Response\JsonResponse as PhalApi_Response;

/**
 * 自定义返回结构，触发接口访问事件
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-21
 */
class Response extends PhalApi_Response {

  /**
   * 格式化返回数据，触发相应事件
   *
   * @param array $result
   *
   * @return array $result
   */
  protected function formatResult($result) {

    // $data = eval('return '.iconv("GBK//IGNORE", "UTF-8", var_export($result,true)).';');
    //
    return $result;

   // if (!$data) {

   // 	return parent::formatResult($result);

   // } else {

   // 	return parent::formatResult($data);

   // }
  
  }

}
