<?php
namespace App\Service\ThirdPartyApi\Notify;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Interfaces\ThirdPartyApi\Notify\IThirdPartyMessageLog;


class ThirdPartyMessageLogSv extends BaseService implements IThirdPartyMessageLog {

  use CurdSv;


}
