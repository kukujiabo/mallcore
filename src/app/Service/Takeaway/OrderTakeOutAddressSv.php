<?php
namespace App\Service\Takeaway;

use App\Service\BaseService;
use App\Interfaces\Takeaway\IOrderTakeOutAddress;
use App\Model\OrderTakeOutAddress;
use Core\Service\CurdSv;
use App\Service\Crm\MemberExpressAddressSv;

/**
 * 外卖订单地址
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-11
 */
class OrderTakeOutAddressSv extends BaseService implements IOrderTakeOutAddress {

    use CurdSv;

    /**
     * 获取列表
     */
    public function getList($condition) {

        return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

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

        $list = OrderTakeOutAddress::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

        return $list[0];

    }

    /**
     * 新增
     */
    public function addOrderAddress($data) {

        $where_address['uid'] = $data_order_address['uid'] = $data['uid'];

        $data_order_address['order_take_out_id'] = $data['order_id'];

        $data_order_address['address_id'] = $data['address_id'];

        $where_address['address_id'] = $data['address_id'];

        $info_address = MemberExpressAddressSv::getAddressDetails($where_address);

        unset($info_address['id']);

        unset($info_address['uid']);

        unset($info_address['alias']);

        unset($info_address['is_default']);

        unset($info_address['deleted_at']);

        $data_order_address = array_merge($data_order_address,$info_address);
        
        return self::add($data_order_address);

    }

    /**
     * 编辑
     */
    public function updates($data) {

        if ($data['id']) {

            $condition['id'] = $data['id'];

            unset($data['id']);

        }

        return self::batchUpdate($condition, $data);

    }

}
