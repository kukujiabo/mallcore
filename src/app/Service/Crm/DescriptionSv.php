<?php

namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IDescription;
use App\Model\Description;
use Core\Service\CurdSv;

/**
 * 网站说明
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-07
 */
class DescriptionSv extends BaseService implements IDescription {

    use CurdSv;

    public function add ($data) {

        $data['created_at'] = date('Y-m-d H:i:s');

        try{

            return self::add($data);

        } catch (\Exception $e){

            throw new InternalServerErrorException('新增失败', 1);

        }

    }

    public function getDetails ($condition) {

        $list = Description::queryList($condition,'*','id desc',0,20);

        return $list[0];

    }

    public function updates ($data) {

        if ($data['id']) {

            $condition['id'] = $data['id'];

            unset($data['id']);

        }

        $info = Description::batchUpdate($condition,$data);

        if ($info) {

            return $info;

        } else {

            return false;

        }

    }
  
    /**
     * 删除
     */
    public function remove($condition){

        $info = Description::batchRemove($condition);

        if ($info) {

            return $info;

        } else {

            return false;

        }

    }

    /**
     * 启用
     */
    public function enable($id) {

        $condition['id'] = $id;

        $data['status'] = 1;

        return Description::update($condition['id'], $data);

    }

    /**
     * 禁用
     */
    public function disable($id) {

        $condition['id'] = $id;

        $data['status'] = 2;

        return Description::update($condition['id'], $data);

    }

}
