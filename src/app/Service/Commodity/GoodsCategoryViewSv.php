<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Model\GoodsCategoryView;
use PhalApi\Exception;
use Core\Service\CurdSv;

/**
 * 商品分类视图类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2018-01-13
 */
class GoodsCategoryViewSv extends BaseService {

	use CurdSv;

    /**
     * 获取列表
     */
    public function getList($condition) {

        return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

    }

}
