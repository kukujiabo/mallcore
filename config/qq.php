<?php

/**
 * QQ接口配置文件
 */
return array(

    // 逆地址解析（坐标位置描述）请求URL
    'get_address_uri' => 'http://apis.map.qq.com/ws/geocoder/v1/?location={LATITUDE},{LONGITUDE}&key={KEY}',

    // 地址解析（地址转坐标）请求URL
    'get_coordinate_uri' => 'http://apis.map.qq.com/ws/geocoder/v1/?address={ADDRESS}&key={KEY}',

    // 行政区划（获取全部行政区划数据）请求URL
    'get_administrative_region_uri' => 'http://apis.map.qq.com/ws/district/v1/list/?key={KEY}',

);
