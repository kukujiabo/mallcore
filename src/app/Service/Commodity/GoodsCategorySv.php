<?php
namespace App\Service\Commodity;

use App\Service\BaseService;
use App\Interfaces\Commodity\IGoodsCategory;
use App\Model\GoodsCategory;
use Core\Service\CurdSv;
use PhalApi\Exception;
use App\Service\Commodity\GoodsCategoryViewSv;
use App\Service\Commodity\GoodSv;
use App\Exception\GoodsCategoryException;
use App\Exception\ErrorCode;

/**
 * 商品分类
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-15
 */
class GoodsCategorySv extends BaseService implements IGoodsCategory {

    use CurdSv;

    /**
     * 获取列表
     */
    public function getList($condition) {

        return GoodsCategoryViewSv::getList($condition);

    }

    /**
     * 获取子类列表
     */
    public function getSubclassList($list) {

        $where['is_visible'] = 1;

        foreach ($list as &$v) {

            $where['pid'] = $v['category_id'];
            
            $subclass = GoodsCategory::queryList($where, '*', '', 0, 100000);

            if ($subclass) {

                $subclass = self::getSubclassList($subclass);

                $v['subclass'] = $subclass;

            }

        }

        unset($v);

        return $list;

    }

    /**
     * 获取数量
     */
    public function getCount($condition) {

        return self::queryCount($condition);

    }

    /**
     * 获取详情
     */
    public function getDetails($condition) {

        $list = GoodsCategory::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

        return $list[0];

    }

    /**
     * 新增
     */
    public function addGoodsCategory($data) {

        $data['category_name'] = iconv('UTF-8', 'GBK', $data['category_name']);

        $data['category_id'] = time();

        $data['created_at'] = date("Y-m-d H:i:s");

        return self::add($data);

    }

    /**
     * 编辑
     *
     * @param array $data
     *
     * @return int num
     */
    public function updates($data) {

        if ($data['category_id']) {

            $condition['category_id'] = $data['category_id'];

            unset($data['category_id']);

        }

        return self::batchUpdate($condition, $data);

    }


    /**
     * 删除分类
     *
     * @param array $data
     * @param int $data.category_id
     */
    public function removeCategory($data) {
    
      /**
       * 先查询分类下是否有商品，若有商品，不允许删除该分类
       */
      $goods = GoodsSv::findOne(array('category_id' => $data['category_id']));

      if ($goods) {

        throw new GoodsCategoryException(
        
          ErrorCode::GoodsCategoryException['GOOD_CATEGORY_HAS_GOODS_MSG'],

          ErrorCode::GoodsCategoryException['GOOD_CATEGORY_HAS_GOODS_CODE'],

          $data['category_id']
        
        );

      }
    
      return self::remove($data['category_id'], false);
    
    }
    

}
