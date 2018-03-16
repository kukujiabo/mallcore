<?php
namespace App;

use App\Library\EventTrigger;
/**
 * 公共调用函数
 */

use App\Library\Verification;
use PhalApi\Exception;
use App\Library\QRcode;
use Milon\Barcode\DNS1D;
use App\Library\WxShareErrorCode;

/**
 * 手机正则
 * @param string $phone 手机号
 */
function verifyPhone($phone) {
  $pattern = '/^(1)\d{10}$/';
  // 验证手机号
  $b = preg_match($pattern, $phone);
  if ($b == false) {
      return false;
  } else {
      return true;
  }
}

/**
 * 身份证正则
 * @param string $data 身份证
 */
function verifyIdentityCard ($data) {
  $pattern = '/^\d{15}|\d{18}$/';
  return preg_match($pattern, $data);
}

/**
 * 邮箱正则
 * @param string $data 邮箱
 */
function verifyEmail ($data) {
  $pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
  return preg_match($pattern, $data);
}

/**
 * 事件触发函数
 */
function success_trigger($action, $token) {

  $et = new EventTrigger($action, $token);

  $et->run();

}

function error_trigger($aciton, $requestData, $responseData) {


}

/**
 * 获取数字随机数
 * @param int $figures 随机数的位数
 */
function getRandomDigit ($figures) {

  return rand(pow(10, $figures - 1), pow(10, $figures) - 1);

}

/**
 * 获取随机字符串
 * @param int $len 位数
 * @param string $chars 字符串
 */
function getRandomString ($len, $chars = null) {

  if (is_null($chars)){

    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

  }

  mt_srand(10000000*(double)microtime());

  for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){

    $str .= $chars[mt_rand(0, $lc)]; 

  }

  return $str;

}

/**
 * 验证字段
 * @param array $array 被验证的数组
 * @param array $data 验证的字段数组
 */
function Verification($array, $data) {
  try{
    Verification::index($array, $data);
  } catch (\Exception $e){
    throw new Exception($e->getMessage(), 1001);
  }
}

/**
 * 生成二维码图片
 * @param string $data 二维码内容
 */
function qrCode($data, $base64 = false){

  $level = 'L'; // 纠错级别：L、M、Q、H

  $size = 8; // 点的大小：1到10,用于手机端4就可以了

  $time = time();

  $times = date('Ymd');
  
  $errorCorrectionLevel = intval($level); //容错级别 

  $matrixPointSize = intval($size); //生成图片大小 

  $object = new QRcode();

  /**
   * 只需要生成base64时，$base64参数设为true
   */
  if (!$base64) {

    // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
    $path = API_ROOT . '/static/qr_code_img/' . $times . '/';

    if (!file_exists($path))
      mkdir($path, 0777, true);

    $images = $time . '_' . $data . '.png';

    $filename = $path . $images;


    $return = $object->png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    return 'qr_code_img/' . $times . '/'. $images;

  } else {
  
    $object->png($data, false, $errorCorrectionLevel, $matrixPointSize, 2);

    $base64code = base64_encode(ob_get_contents());

    ob_clean();

    return  "data:image/png;base64," . $base64code;
  
  }

}

/**
 * 图片base64处理
 * @param string $image_file 图片所在的路径
 */
function base64EncodeImage ($image_file) {

  $base64_image = '';

  $image_info = getimagesize($image_file);

  $image_data = fread(fopen($image_file, 'r'), filesize($image_file));

  $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));

  return $base64_image;

}

/**
 * 生成base64条形码图片
 * @param status $name 图片内容
 * @param int $width 图片宽
 * @param int $height 图片高
 * @param array $colour 图片颜色
 * @return status 图片相对路径
 */
function barCode($name, $width = 2, $height = 66, $colour = array(1, 1, 1), $base64 = false) {

  $d = new DNS1D();

  $d->setStorPath(API_ROOT."/cache/");
  
  $base64_image_content = 'data:image/png;base64,'.$d->getBarcodePNG($name, "C128C", $width, $height, $colour, true);

  if (!$base64) {

    return base64Image($base64_image_content, $name, "bar_code_img/");

  } else {
  
    return $base64_image_content;
  
  }

}

/**
 * 保存base64图片
 * @param status $base64_image_content base64格式图片
 * @param status $name 图片名称
 * @param status $path 图片路径名称
 * @return status 图片相对路径
 */
function base64Image($base64_image_content, $name, $path = "bar_code_img/") {

  header('Content-type:text/html;charset=utf-8');

  if (!$name) {

    $name = getRandomDigit(6);

  }

  //匹配出图片的格式
  if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){

    $type = $result[2];

    $times = date('Ymd');

    $new_file = API_ROOT . '/static/' . $path . $times . "/";

    if(!file_exists($new_file))
      mkdir($new_file, 0777, true);

    $img = time() . '_' . $name . ".{$type}";

    $new_file .= $img;

    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){

      return $path . $times . "/" . $img;

    }

  }

}

/**
 * 微信数据解密
 *
 */
function decodeWxdata($appid, $sessionKey, $encryptedData, $iv) {

  $decoder = new WXBizDataCrypt($appid, $sessionKey);

  $errCode = $decorder->decryptData($encryptData, $iv, $data);

  if ($errCode == 0) {
  
    return $data;
  
  } else {
  
  
  }


}

/**
 * 在数组中根据条件取出一段值，并返回
 */
function pageDispose($list, $page = 1, $pageSize = 20) {

  $totalCount = count($list);

  $queryResult = array();

  $queryPage = 1;

  if ($totalCount > 0) {

    $querySize = (INT)($pageSize < 1 ? 20 : ( $pageSize > $totalCount ? $totalCount : $pageSize));

    $pageNum = ceil($totalCount/$querySize);

    $queryPage = (INT)($page > $pageNum ? $pageNum : ($page < 1 ? 1 : $page));

    $offset = ($queryPage - 1) * (INT)$querySize;

    $queryResult = array_slice($list, $offset, $querySize, false);

  }

  $response = array(
    
    'list' => $queryResult,

    'total' => $totalCount,

    'page' => $queryPage
  
  );

  return $response;

}
