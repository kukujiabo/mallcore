<?php

namespace App\Model;

/**
 * [模型层] 全国地区类
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-24
 */
class NationwideArea extends BaseModel {

    protected $_table = 'common_region';

    protected $_queryOptionRule = array(

      'id' => 'in',

      'name' => 'like'

    );

    /**
     * 区域
     */
    public static function getAreaList($where) {

        return \PhalApi\DI()->notorm->area->where($where)->select('area_id as id, area_name as name')->fetchRows();

    }

    /**
     * 省
     */
    public static function getProvinceList($where) {

        return \PhalApi\DI()->notorm->province->where($where)->select('province_id as id, province_name as name, area_id as parent_id')->fetchRows();

    }

    /**
     * 市
     */
    public static function getCityList($where) {

        return \PhalApi\DI()->notorm->city->where($where)->select('city_id as id, city_name as name, province_id as parent_id')->fetchRows();

    }

    /**
     * 地区
     */
    public static function getDistrictList($where) {

        return \PhalApi\DI()->notorm->district->where($where)->select('district_id as id, district_name as name, city_id as parent_id')->fetchRows();

    }

}
