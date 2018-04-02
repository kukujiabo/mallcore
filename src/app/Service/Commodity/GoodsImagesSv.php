<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Interfaces\Commodity\IGoodsImages;
use App\Model\GoodsImages;
use Core\Service\CurdSv;
use PhalApi\Exception;

/**
 * 商品图片接口
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-12-27
 */
class GoodsImagesSv extends BaseService implements IGoodsImages {

    use CurdSv;

    /**
     * 获取列表 */
    public function getList($condition) {

        return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

    }

    /**
     * 获取详情
     */
    public function getDetail($condition) {

        return self::findOne($condition);

    }

    /**
     * 新增
     */
    public function addData($data) {

        $data['created_at'] = date("Y-m-d H:i:s");

        return self::add($data);

    }

    /**
     * 编辑
     */
    public function edit($data) {

        $condition['id'] = $data['id'];

        unset($data['id']);

        return self::batchUpdate($condition, $data);

    }

}
