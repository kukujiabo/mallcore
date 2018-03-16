<?php

namespace App\Model;

/**
 * [模型层] 网站说明
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-11-07
 */
class Description extends BaseModel {

    protected $_queryOptionRule = array(

        'created_at' => 'range',
        
        'title' => 'like',

    );
    
}
