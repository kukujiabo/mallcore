<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\GoodsDm;

/**
 * 8.1 商品接口服务
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-14
 */
class Goods extends BaseApi {

  /**
   * 接口参数规则
   */
  public function getRules() {

    return $this->rules(array(

        'add' => array(

            'goods_name' => 'goods_name|string|true||商品名称',

            'shop_id' => 'shop_id|int|false||店铺id',

            'category_id' => 'category_id|int|false||商品分类id',

            'brand_id' => 'brand_id|int|false||品牌id',

            'promotion_type' => 'promotion_type|int|true|0|促销类型 0无促销，1团购，2限时折扣',

            'promote_id' => 'promote_id|int|false||促销活动ID',

            'goods_type' => 'goods_type|int|true|1|实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
            
            'cost_price' => 'cost_price|float|true||成本价',
            
            'price' => 'price|float|true||商品原价格',

            'market_price' => 'market_price|float|false||市场价',

            'promotion_price' => 'promotion_price|float|false||商品促销价格',

            'point_exchange_type' => 'point_exchange_type|int|true||积分兑换类型 0 非积分兑换 1 只能积分兑换 ',

            'point_exchange' => 'point_exchange|int|true||兑换积分额度',

            'give_point' => 'give_point|int|true||购买商品赠送积分',

            'is_member_discount' => 'is_member_discount|int|true||参与会员折扣 1-是 0-否',

            'shipping_fee' => 'shipping_fee|float|false||运费 0为免运费',

            'shipping_fee_id' => 'shipping_fee_id|int|false||售卖区域id(物流模板id)',

            'stock' => 'stock|int|true||商品库存',

            'max_buy' => 'max_buy|int|false||限购 0-不限购',

            'clicks' => 'clicks|int|false||商品点击数量',

            'min_stock_alarm' => 'min_stock_alarm|int|false||库存预警值',

            'sales' => 'sales|int|false||销售数量',

            'collects' => 'collects|int|false||收藏数量',

            'star' => 'star|int|false||好评星级',

            'evaluates' => 'evaluates|int|false||评价数',

            'shares' => 'shares|int|false||分享数',

            'picture' => 'picture|string|true||商品主图',

            'keywords' => 'keywords|string|false||商品关键词',

            'introduction' => 'introduction|string|false||商品简介，促销语',

            'description' => 'description|string|false||商品详情',

            'QRcode' => 'QRcode|string|false||商品二维码',

            'is_stock_visible' => 'is_stock_visible|int|true|0|页面不显示库存 1-显示 0-不显示',

            'is_hot' => 'is_hot|int|true|0|是否热销商品 1-是 0-否',

            'is_recommend' => 'is_recommend|int|true|0|是否推荐 1-是 0-否',

            'is_new' => 'is_new|int|true|0|是否新品 1-是 0-否',

            'is_pre_sale' => 'is_pre_sale|int|true|0|是否预售 1-是 0-否',

            'is_bill' => 'is_bill|int|true|0|是否开具增值税发票 1-是 0-否',

            'state' => 'state|int|true|1|商品状态 0下架，1正常，10违规（禁售）',

            'sort' => 'sort|int|false||排序',

            'img_id_array' => 'img_id_array|string|false||商品图片序列',

            'sku_img_array' => 'sku_img_array|string|false||商品sku应用图片列表  属性,属性值，图片ID',

            'match_point' => 'match_point|float|false||实物与描述相符（根据评价计算）',

            'match_ratio' => 'match_ratio|float|false||实物与描述相符（根据评价计算）百分比',

            'goods_attribute_id' => 'goods_attribute_id|int|false||商品类型',

            'match_ratio' => 'match_ratio|string|false||商品规格',

            'goods_weight' => 'goods_weight|float|false||商品重量',

            'goods_volume' => 'goods_volume|float|false||商品体积',

            'shipping_fee_type' => 'shipping_fee_type|int|true||计价方式1.重量2.体积3.计件',

            'supplier_id' => 'supplier_id|int|false||供货商id',

        ),

        'queryList' => array(

            'city_code' => 'city_code|int|false||城市代码',

            'user_level' => 'user_level|int|false||用户等级',

            'goods_id' => 'goods_id|int|false||表序号',

            'goods_name' => 'goods_name|string|false||商品名称',

            'shop_id' => 'shop_id|int|false||店铺id',

            'category_id' => 'category_id|int|false||商品分类id',

            'brand_id' => 'brand_id|int|false||品牌id',

            'promotion_type' => 'promotion_type|int|false||促销类型 0无促销，1团购，2限时折扣',

            'promote_id' => 'promote_id|int|false||促销活动ID',

            'goods_type' => 'goods_type|int|false||实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
            
            'cost_price' => 'cost_price|float|false||成本价',
            
            'price' => 'price|float|false||商品原价格',

            'market_price' => 'market_price|float|false||市场价',

            'promotion_price' => 'promotion_price|float|false||商品促销价格',

            'point_exchange_type' => 'point_exchange_type|int|false||积分兑换类型 0 非积分兑换 1 只能积分兑换 ',

            'point_exchange' => 'promote_id|int|false||兑换积分额度',

            'give_point' => 'promote_id|int|false||购买商品赠送积分',

            'is_member_discount' => 'is_member_discount|int|false||参与会员折扣 1-是 0-否',

            'shipping_fee' => 'shipping_fee|float|false||运费 0为免运费',

            'shipping_fee_id' => 'shipping_fee_id|int|false||售卖区域id(物流模板id)',

            'stock' => 'stock|int|false||商品库存',

            'index_show' => 'index_show|int|false||首页展示',

            'max_buy' => 'max_buy|int|false||限购 0-不限购',

            'clicks' => 'clicks|int|false||商品点击数量',

            'min_stock_alarm' => 'min_stock_alarm|int|false||库存预警值',

            'sales' => 'sales|int|false||销售数量',

            'collects' => 'collects|int|false||收藏数量',

            'star' => 'star|int|false||好评星级',

            'evaluates' => 'evaluates|int|false||评价数',

            'shares' => 'shares|int|false||分享数',

            'picture' => 'picture|string|false||商品主图',

            'keywords' => 'keywords|string|false||商品关键词',

            'introduction' => 'introduction|string|false||商品简介，促销语',

            'description' => 'description|string|false||商品详情',

            'QRcode' => 'QRcode|string|false||商品二维码',

            'is_stock_visible' => 'is_stock_visible|int|false||页面不显示库存 1-显示 0-不显示',

            'is_hot' => 'is_hot|int|false||是否热销商品 1-是 0-否',

            'is_recommend' => 'is_recommend|int|false||是否推荐 1-是 0-否',

            'is_new' => 'is_new|int|false||是否新品 1-是 0-否',

            'is_pre_sale' => 'is_pre_sale|int|false||是否预售 1-是 0-否',

            'is_bill' => 'is_bill|int|false||是否开具增值税发票 1-是 0-否',

            'state' => 'state|int|false||商品状态 0下架，1正常，10违规（禁售）',
            
            'sale_date' => 'sale_date|string|false||上下架时间',
            
            'create_time' => 'create_time|string|false||商品添加时间',

            'update_time' => 'update_time|string|false||商品编辑时间',

            'sort' => 'sort|int|false||排序',

            'img_id_array' => 'img_id_array|string|false||商品图片序列',

            'sku_img_array' => 'sku_img_array|string|false||商品sku应用图片列表  属性,属性值，图片ID',

            'match_point' => 'match_point|float|false||实物与描述相符（根据评价计算）',

            'match_ratio' => 'match_ratio|float|false||实物与描述相符（根据评价计算）百分比',

            'goods_attribute_id' => 'goods_attribute_id|int|false||商品类型',

            'match_ratio' => 'match_ratio|string|false||商品规格',

            'goods_weight' => 'goods_weight|float|false||商品重量',

            'goods_volume' => 'goods_volume|float|false||商品体积',

            'shipping_fee_type' => 'shipping_fee_type|int|false||计价方式1.重量2.体积3.计件',

            'supplier_id' => 'supplier_id|int|false||供货商id',

            'fields' => 'fields|string|false|*|查询字段',

            'order' => 'order|string|false||排序',

            'page' => 'page|int|true|1|页码',

            'page_size' => 'page_size|int|true|20|每页数据条数'

        ),

        'getAll' => array(

            'goods_id' => 'goods_id|int|false||表序号',

            'goods_name' => 'goods_name|string|false||商品名称',

            'shop_id' => 'shop_id|int|false||店铺id',

            'category_id' => 'category_id|int|false||商品分类id',

            'brand_id' => 'brand_id|int|false||品牌id',

            'promotion_type' => 'promotion_type|int|false|0|促销类型 0无促销，1团购，2限时折扣',

            'promote_id' => 'promote_id|int|false||促销活动ID',

            'goods_type' => 'goods_type|int|false|1|实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
            
            'cost_price' => 'cost_price|float|false||成本价',
            
            'price' => 'price|float|false||商品原价格',

            'market_price' => 'market_price|float|false||市场价',

            'promotion_price' => 'promotion_price|float|false||商品促销价格',

            'point_exchange_type' => 'point_exchange_type|int|false||积分兑换类型 0 非积分兑换 1 只能积分兑换 ',

            'point_exchange' => 'promote_id|int|false||兑换积分额度',

            'give_point' => 'promote_id|int|false||购买商品赠送积分',

            'is_member_discount' => 'is_member_discount|int|false||参与会员折扣 1-是 0-否',

            'shipping_fee' => 'shipping_fee|float|false||运费 0为免运费',

            'shipping_fee_id' => 'shipping_fee_id|int|false||售卖区域id(物流模板id)',

            'stock' => 'stock|int|false||商品库存',

            'max_buy' => 'max_buy|int|false||限购 0-不限购',

            'clicks' => 'clicks|int|false||商品点击数量',

            'min_stock_alarm' => 'min_stock_alarm|int|false||库存预警值',

            'sales' => 'sales|int|false||销售数量',

            'collects' => 'collects|int|false||收藏数量',

            'star' => 'star|int|false||好评星级',

            'evaluates' => 'evaluates|int|false||评价数',

            'shares' => 'shares|int|false||分享数',

            'picture' => 'picture|string|false||商品主图',

            'keywords' => 'keywords|string|false||商品关键词',

            'introduction' => 'introduction|string|false||商品简介，促销语',

            'description' => 'description|string|false||商品详情',

            'QRcode' => 'QRcode|string|false||商品二维码',

            'is_stock_visible' => 'is_stock_visible|int|false|0|页面不显示库存 1-显示 0-不显示',

            'is_hot' => 'is_hot|int|false|0|是否热销商品 1-是 0-否',

            'is_recommend' => 'is_recommend|int|false|0|是否推荐 1-是 0-否',

            'is_new' => 'is_new|int|false|0|是否新品 1-是 0-否',

            'is_pre_sale' => 'is_pre_sale|int|false|0|是否预售 1-是 0-否',

            'is_bill' => 'is_bill|int|false|0|是否开具增值税发票 1-是 0-否',

            'state' => 'state|int|false|1|商品状态 0下架，1正常，10违规（禁售）',
            
            'sale_date' => 'sale_date|string|false||上下架时间',
            
            'create_time' => 'create_time|string|false||商品添加时间',

            'update_time' => 'update_time|string|false||商品编辑时间',

            'sort' => 'sort|int|false||排序',

            'img_id_array' => 'img_id_array|string|false||商品图片序列',

            'sku_img_array' => 'sku_img_array|string|false||商品sku应用图片列表  属性,属性值，图片ID',

            'match_point' => 'match_point|float|false||实物与描述相符（根据评价计算）',

            'match_ratio' => 'match_ratio|float|false||实物与描述相符（根据评价计算）百分比',

            'goods_attribute_id' => 'goods_attribute_id|int|false||商品类型',

            'match_ratio' => 'match_ratio|string|false||商品规格',

            'goods_weight' => 'goods_weight|float|false||商品重量',

            'goods_volume' => 'goods_volume|float|false||商品体积',

            'shipping_fee_type' => 'shipping_fee_type|int|false||计价方式1.重量2.体积3.计件',

            'supplier_id' => 'supplier_id|int|false||供货商id',

        ),

        'queryCount' => array(

            'goods_id' => 'goods_id|int|false||表序号',

            'goods_name' => 'goods_name|string|false||商品名称',

            'shop_id' => 'shop_id|int|false||店铺id',

            'category_id' => 'category_id|int|false||商品分类id',

            'index_show' => 'index_show|int|false||首页展示',

            'brand_id' => 'brand_id|int|false||品牌id',

            'promotion_type' => 'promotion_type|int|false|0|促销类型 0无促销，1团购，2限时折扣',

            'promote_id' => 'promote_id|int|false||促销活动ID',

            'goods_type' => 'goods_type|int|false|1|实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
            
            'cost_price' => 'cost_price|float|false||成本价',
            
            'price' => 'price|float|false||商品原价格',

            'market_price' => 'market_price|float|false||市场价',

            'promotion_price' => 'promotion_price|float|false||商品促销价格',

            'point_exchange_type' => 'point_exchange_type|int|false||积分兑换类型 0 非积分兑换 1 只能积分兑换 ',

            'point_exchange' => 'promote_id|int|false||兑换积分额度',

            'give_point' => 'promote_id|int|false||购买商品赠送积分',

            'is_member_discount' => 'is_member_discount|int|false||参与会员折扣 1-是 0-否',

            'shipping_fee' => 'shipping_fee|float|false||运费 0为免运费',

            'shipping_fee_id' => 'shipping_fee_id|int|false||售卖区域id(物流模板id)',

            'stock' => 'stock|int|false||商品库存',

            'max_buy' => 'max_buy|int|false||限购 0-不限购',

            'clicks' => 'clicks|int|false||商品点击数量',

            'min_stock_alarm' => 'min_stock_alarm|int|false||库存预警值',

            'sales' => 'sales|int|false||销售数量',

            'collects' => 'collects|int|false||收藏数量',

            'star' => 'star|int|false||好评星级',

            'evaluates' => 'evaluates|int|false||评价数',

            'shares' => 'shares|int|false||分享数',

            'picture' => 'picture|string|false||商品主图',

            'keywords' => 'keywords|string|false||商品关键词',

            'introduction' => 'introduction|string|false||商品简介，促销语',

            'description' => 'description|string|false||商品详情',

            'QRcode' => 'QRcode|string|false||商品二维码',

            'is_stock_visible' => 'is_stock_visible|int|false|0|页面不显示库存 1-显示 0-不显示',

            'is_hot' => 'is_hot|int|false|0|是否热销商品 1-是 0-否',

            'is_recommend' => 'is_recommend|int|false|0|是否推荐 1-是 0-否',

            'is_new' => 'is_new|int|false|0|是否新品 1-是 0-否',

            'is_pre_sale' => 'is_pre_sale|int|false|0|是否预售 1-是 0-否',

            'is_bill' => 'is_bill|int|false|0|是否开具增值税发票 1-是 0-否',

            'state' => 'state|int|false|1|商品状态 0下架，1正常，10违规（禁售）',
            
            'sale_date' => 'sale_date|string|false||上下架时间',
            
            'create_time' => 'create_time|string|false||商品添加时间',
            
            'update_time' => 'update_time|string|false||商品编辑时间',

            'sort' => 'sort|int|false||排序',

            'img_id_array' => 'img_id_array|string|false||商品图片序列',

            'sku_img_array' => 'sku_img_array|string|false||商品sku应用图片列表  属性,属性值，图片ID',

            'match_point' => 'match_point|float|false||实物与描述相符（根据评价计算）',

            'match_ratio' => 'match_ratio|float|false||实物与描述相符（根据评价计算）百分比',

            'goods_attribute_id' => 'goods_attribute_id|int|false||商品类型',

            'match_ratio' => 'match_ratio|string|false||商品规格',

            'goods_weight' => 'goods_weight|float|false||商品重量',

            'goods_volume' => 'goods_volume|float|false||商品体积',

            'shipping_fee_type' => 'shipping_fee_type|int|false||计价方式1.重量2.体积3.计件',

            'supplier_id' => 'supplier_id|int|false||供货商id',
      
        ),

        'update' => array(

            'goods_id' => 'goods_id|int|true||表序号',

            'goods_name' => 'goods_name|string|false||商品名称',

            'shop_id' => 'shop_id|int|false||店铺id',

            'category_id' => 'category_id|int|false||商品分类id',

            'brand_id' => 'brand_id|int|false||品牌id',

            'promotion_type' => 'promotion_type|int|false|0|促销类型 0无促销，1团购，2限时折扣',

            'promote_id' => 'promote_id|int|false||促销活动ID',

            'goods_type' => 'goods_type|int|false|1|实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
            
            'cost_price' => 'cost_price|float|false||成本价',
            
            'price' => 'price|float|false||商品原价格',

            'market_price' => 'market_price|float|false||市场价',

            'promotion_price' => 'promotion_price|float|false||商品促销价格',

            'point_exchange_type' => 'point_exchange_type|int|false||积分兑换类型 0 非积分兑换 1 只能积分兑换 ',

            'point_exchange' => 'promote_id|int|false||兑换积分额度',

            'give_point' => 'promote_id|int|false||购买商品赠送积分',

            'is_member_discount' => 'is_member_discount|int|false||参与会员折扣 1-是 0-否',

            'shipping_fee' => 'shipping_fee|float|false||运费 0为免运费',

            'shipping_fee_id' => 'shipping_fee_id|int|false||售卖区域id(物流模板id)',

            'stock' => 'stock|int|false||商品库存',

            'max_buy' => 'max_buy|int|false||限购 0-不限购',

            'clicks' => 'clicks|int|false||商品点击数量',

            'min_stock_alarm' => 'min_stock_alarm|int|false||库存预警值',

            'sales' => 'sales|int|false||销售数量',

            'collects' => 'collects|int|false||收藏数量',

            'star' => 'star|int|false||好评星级',

            'evaluates' => 'evaluates|int|false||评价数',

            'shares' => 'shares|int|false||分享数',

            'picture' => 'picture|string|false||商品主图',

            'keywords' => 'keywords|string|false||商品关键词',

            'introduction' => 'introduction|string|false||商品简介，促销语',

            'description' => 'description|string|false||商品详情',

            'QRcode' => 'QRcode|string|false||商品二维码',

            'is_stock_visible' => 'is_stock_visible|int|false|0|页面不显示库存 1-显示 0-不显示',

            'is_hot' => 'is_hot|int|false|0|是否热销商品 1-是 0-否',

            'is_recommend' => 'is_recommend|int|false|0|是否推荐 1-是 0-否',

            'is_new' => 'is_new|int|false|0|是否新品 1-是 0-否',

            'is_pre_sale' => 'is_pre_sale|int|false|0|是否预售 1-是 0-否',

            'is_bill' => 'is_bill|int|false|0|是否开具增值税发票 1-是 0-否',

            'state' => 'state|int|false|1|商品状态 0下架，1正常，10违规（禁售）',
            
            'sale_date' => 'sale_date|string|false||上下架时间',
            
            'create_time' => 'create_time|string|false||商品添加时间',
            
            'update_time' => 'update_time|string|false||商品编辑时间',

            'sort' => 'sort|int|false||排序',

            'img_id_array' => 'img_id_array|string|false||商品图片序列',

            'sku_img_array' => 'sku_img_array|string|false||商品sku应用图片列表  属性,属性值，图片ID',

            'match_point' => 'match_point|float|false||实物与描述相符（根据评价计算）',

            'match_ratio' => 'match_ratio|float|false||实物与描述相符（根据评价计算）百分比',

            'goods_attribute_id' => 'goods_attribute_id|int|false||商品类型',

            'match_ratio' => 'match_ratio|string|false||商品规格',

            'goods_weight' => 'goods_weight|float|false||商品重量',

            'goods_volume' => 'goods_volume|float|false||商品体积',

            'shipping_fee_type' => 'shipping_fee_type|int|false||计价方式1.重量2.体积3.计件',

            'supplier_id' => 'supplier_id|int|false||供货商id',
      
        ),

        'getDetail' => array(

            'city_code' => 'city_code|int|false||城市代码',

            'user_level' => 'user_level|int|false||用户等级',

            'goods_id' => 'goods_id|int|true||表序号',

            'goods_name' => 'goods_name|string|false||商品名称',

            'shop_id' => 'shop_id|int|false||店铺id',

            'category_id' => 'category_id|int|false||商品分类id',

            'brand_id' => 'brand_id|int|false||品牌id',

            'promotion_type' => 'promotion_type|int|false||促销类型 0无促销，1团购，2限时折扣',

            'promote_id' => 'promote_id|int|false||促销活动ID',

            'goods_type' => 'goods_type|int|false||实物或虚拟商品标志 1实物商品 0 虚拟商品 2 F码商品',
            
            'cost_price' => 'cost_price|float|false||成本价',
            
            'price' => 'price|float|false||商品原价格',

            'market_price' => 'market_price|float|false||市场价',

            'promotion_price' => 'promotion_price|float|false||商品促销价格',

            'point_exchange_type' => 'point_exchange_type|int|false||积分兑换类型 0 非积分兑换 1 只能积分兑换 ',

            'point_exchange' => 'promote_id|int|false||兑换积分额度',

            'give_point' => 'promote_id|int|false||购买商品赠送积分',

            'is_member_discount' => 'is_member_discount|int|false||参与会员折扣 1-是 0-否',

            'shipping_fee' => 'shipping_fee|float|false||运费 0为免运费',

            'shipping_fee_id' => 'shipping_fee_id|int|false||售卖区域id(物流模板id)',

            'stock' => 'stock|int|false||商品库存',

            'max_buy' => 'max_buy|int|false||限购 0-不限购',

            'clicks' => 'clicks|int|false||商品点击数量',

            'min_stock_alarm' => 'min_stock_alarm|int|false||库存预警值',

            'sales' => 'sales|int|false||销售数量',

            'collects' => 'collects|int|false||收藏数量',

            'star' => 'star|int|false||好评星级',

            'evaluates' => 'evaluates|int|false||评价数',

            'shares' => 'shares|int|false||分享数',

            'picture' => 'picture|string|false||商品主图',

            'keywords' => 'keywords|string|false||商品关键词',

            'introduction' => 'introduction|string|false||商品简介，促销语',

            'description' => 'description|string|false||商品详情',

            'QRcode' => 'QRcode|string|false||商品二维码',

            'is_stock_visible' => 'is_stock_visible|int|false||页面不显示库存 1-显示 0-不显示',

            'is_hot' => 'is_hot|int|false||是否热销商品 1-是 0-否',

            'is_recommend' => 'is_recommend|int|false||是否推荐 1-是 0-否',

            'is_new' => 'is_new|int|false||是否新品 1-是 0-否',

            'is_pre_sale' => 'is_pre_sale|int|false||是否预售 1-是 0-否',

            'is_bill' => 'is_bill|int|false||是否开具增值税发票 1-是 0-否',

            'state' => 'state|int|false||商品状态 0下架，1正常，10违规（禁售）',
            
            'sale_date' => 'sale_date|string|false||上下架时间',
            
            'create_time' => 'create_time|string|false||商品添加时间',
            
            'update_time' => 'update_time|string|false||商品编辑时间',

            'sort' => 'sort|int|false||排序',

            'img_id_array' => 'img_id_array|string|false||商品图片序列',

            'sku_img_array' => 'sku_img_array|string|false||商品sku应用图片列表  属性,属性值，图片ID',

            'match_point' => 'match_point|float|false||实物与描述相符（根据评价计算）',

            'match_ratio' => 'match_ratio|float|false||实物与描述相符（根据评价计算）百分比',

            'goods_attribute_id' => 'goods_attribute_id|int|false||商品类型',

            'match_ratio' => 'match_ratio|string|false||商品规格',

            'goods_weight' => 'goods_weight|float|false||商品重量',

            'goods_volume' => 'goods_volume|float|false||商品体积',

            'shipping_fee_type' => 'shipping_fee_type|int|false||计价方式1.重量2.体积3.计件',

            'supplier_id' => 'supplier_id|int|false||供货商id',

            // 'fields' => 'fields|string|false|*|查询字段',

            // 'order' => 'order|string|false||排序',
      
        ),

      'addSkuGoods' => array(

          'brand_id' => 'brand_id|int|true||商品品牌',

          'goods_name' => 'goods_name|string|true||商品名称',

          'shop_id' => 'shop_id|int|true||店铺id',

          'goods_number' => 'goods_number|string|true||商品编号',

          'category_id' => 'category_id|int|true||商品分类id',

          'no_code' => 'no_code|string|false||erp商品编码',

          'state' => 'state|int|true|0|商品状态 0下架，1正常，10违规（禁售）',

          'price' => 'price|float|true||本店售价（元）',

          'market_price' => 'market_price|float|true||市场售价（元）',

          'goods_weight' => 'goods_weight|float|true||重量（克）',

          'sales' => 'sales|int|false||销量（件 ）',

          'is_pinkage' => 'is_pinkage|int|false|1|是否包邮 1-是 2-否',

          'pinkage' => 'pinkage|string|false||快递公司（json格式字符串，如：[{"courier":"1","default":1,"freight":10},{"courier":"2","freight":5}]。courier为快递公司id，default为1表示默认快递公司，freight为运费，运费单位：元）',

          'stock' => 'stock|int|true||库存设置',

          'shape' => 'shape|int|false|1|减库存方式 1-拍下立减库存 2-付款减库存 3-永不减少库存',

          'goods_spec_format' => 'goods_spec_format|string|false||规格描述',

          'is_sku' => 'is_sku|int|false|2|规格类型 1-多规格 2-单规格',

          'attribute' => 'attribute|string|false||商品规格属性（json格式字符串，如：[{"attr_name":"规格1属性名称","attr_value":["属性1第1项规格","属性1第2项规格","属性1第3项规格"]},{"attr_name":"规格2属性名称","attr_value":["属性2第1项规格","属性2第2项规格","属性2第3项规格"]},{"attr_name":"规格3属性名称","attr_value":["属性3第1项规格","属性3第2项规格","属性3第3项规格"]}]。）',

          'goods_sku' => 'goods_sku|string|false||sku商品（json格式字符串，如：[{"sku":[{"attr_id":"规格1属性名称","attr_val":"属性1第1项规格"},{"attr_id":"规格2属性名称","attr_val":"属性2第1项规格"},{"attr_id":"规格3属性名称","attr_val":"属性3第1项规格"}],"attr_value_items":"规格1属性名称_属性1第1项规格;规格2属性名称_属性2第1项规格;规格3属性名称_属性3第1项规格","no_code":"123123","stock":10,"price":10,"market_price":12,"goods_weight":1.2,"picture":"kasjdhfjskhdf.jpg","sku_name":"1111"},{"sku":[{"attr_id":"规格1属性名称","attr_val":"属性1第2项规格"},{"attr_id":"规格2属性名称","attr_val":"属性2第2项规格"},{"attr_id":"规格3属性名称","attr_val":"属性3第3项规格"}],"attr_value_items":"规格1属性名称_属性1第2项规格;规格2属性名称_属性2第2项规格;规格3属性名称_属性3第3项规格","no_code":"123133","stock":10,"price":10,"market_price":12,"goods_weight":1.2,"picture":"kasjdhfjskhdf.jpg","sku_name":"heihei"}]。）',

          'introduction' => 'introduction|string|false||商品描述（商品简介，促销语）',

          'images' => 'images|string|true||商品图（json格式字符串，如：[{"img":"lsdhfjshgbojs.jpg","is_cover":2},{"img":"123123123.jpg"}]。img为图片地址，is_cover为2表示设为封面/主图）',
          
          'thumbnail' => 'thumbnail|string|false||商品缩略图',

          'description' => 'description|string|false||商品详情（图文）',

          'is_promotion' => 'is_promotion|int|false|1|促销秒杀 1-关闭 2-开启',

          'promotion_start_time' => 'promotion_start_time|string|false||促销开始日期',

          'promotion_end_time' => 'promotion_end_time|string|false||促销结束日期',

          'is_group' => 'is_group|int|false|1|拼团设置 1-关闭 2-开启',

          'group_day' => 'group_day|int|false||成团有效时间（单位：天，最大设置为3天）',

          'group_price' => 'group_price|float|false||拼团价',

          'group_number' => 'group_number|int|false||限定人数（最大限定人数为100人 ）',

          'is_bargain' => 'is_bargain|int|false|1|砍价设置 1-关闭 2-开启',

          'bargain_day' => 'bargain_day|int|false||砍价有效时间（单位：天，最大设置为5天）',

          'bargain_price' => 'bargain_price|float|false||砍后价格',

          'bargain_number' => 'bargain_number|int|false||砍价人数（最大限定人数为100人 ）',

          'is_recommend' => 'is_recommend|int|false|1|推荐到首页 1-关闭 2-开启',

          // 'recommend_img' => 'recommend_img|string|false||推荐封面',

          'recommend_title' => 'recommend_title|string|false||推荐标题',

          'sort' => 'sort|int|false|0|排序，数字越大，排在越前面',

          'index_show' => 'index_show|int|false|0|首页展示'

      ),

      'editSkuGoods' => array(

          'goods_id' => 'goods_id|int|true||商品id',

          'brand_id' => 'brand_id|int|true||品牌id',

          'goods_name' => 'goods_name|string|true||商品名称',

          'shop_id' => 'shop_id|int|true||店铺id',

          'goods_number' => 'goods_number|string|true||商品编号',

          'category_id' => 'category_id|int|true||商品分类id',

          'no_code' => 'no_code|string|false||erp商品编码',

          'state' => 'state|int|true|0|商品状态 0下架，1正常，10违规（禁售）',

          'price' => 'price|float|true||本店售价（元）',

          'market_price' => 'market_price|float|true||市场售价（元）',

          'goods_weight' => 'goods_weight|float|true||重量（克）',

          'sales' => 'sales|int|false||销量（件 ）',

          'is_pinkage' => 'is_pinkage|int|false|1|是否包邮 1-是 2-否',

          'pinkage' => 'pinkage|string|false||快递公司（json格式字符串，如：[{"courier":"1","default":1,"freight":10},{"courier":"2","freight":5}]。courier为快递公司id，default为1表示默认快递公司，freight为运费，运费单位：元）',

          'stock' => 'stock|int|true||库存设置',

          'shape' => 'shape|int|false|1|减库存方式 1-拍下立减库存 2-付款减库存 3-永不减少库存',

          'goods_spec_format' => 'goods_spec_format|string|false||规格描述',

          'is_sku' => 'is_sku|int|false|2|规格类型 1-多规格 2-单规格',

          'attribute' => 'attribute|string|false||商品规格属性（json格式字符串，如：[{"attr_name":"规格1属性名称","attr_value":["属性1第1项规格","属性1第2项规格","属性1第3项规格"]},{"attr_name":"规格2属性名称","attr_value":["属性2第1项规格","属性2第2项规格","属性2第3项规格"]},{"attr_name":"规格3属性名称","attr_value":["属性3第1项规格","属性3第2项规格","属性3第3项规格"]}]。）',

          'goods_sku' => 'goods_sku|string|false||sku商品（json格式字符串，如：[{"sku":[{"attr_id":"规格1属性名称","attr_val":"属性1第1项规格"},{"attr_id":"规格2属性名称","attr_val":"属性2第1项规格"},{"attr_id":"规格3属性名称","attr_val":"属性3第1项规格"}],"attr_value_items":"规格1属性名称_属性1第1项规格;规格2属性名称_属性2第1项规格;规格3属性名称_属性3第1项规格","no_code":"123123","stock":10,"price":10,"market_price":12,"goods_weight":1.2,"picture":"kasjdhfjskhdf.jpg","sku_name":"1111"},{"sku":[{"attr_id":"规格1属性名称","attr_val":"属性1第2项规格"},{"attr_id":"规格2属性名称","attr_val":"属性2第2项规格"},{"attr_id":"规格3属性名称","attr_val":"属性3第3项规格"}],"attr_value_items":"规格1属性名称_属性1第2项规格;规格2属性名称_属性2第2项规格;规格3属性名称_属性3第3项规格","no_code":"123133","stock":10,"price":10,"market_price":12,"goods_weight":1.2,"picture":"kasjdhfjskhdf.jpg","sku_name":"heihei"}]。）',

          'introduction' => 'introduction|string|false||商品描述（商品简介，促销语）',

          'images' => 'images|string|true||商品图（json格式字符串，如：[{"img":"lsdhfjshgbojs.jpg","is_cover":2},{"img":"123123123.jpg"}]。img为图片地址，is_cover为2表示设为封面/主图）',
          
          'thumbnail' => 'thumbnail|string|false||商品缩略图',

          'description' => 'description|string|false||商品详情（图文）',

          'is_promotion' => 'is_promotion|int|false|1|促销秒杀 1-关闭 2-开启',

          'promotion_start_time' => 'promotion_start_time|string|false||促销开始日期',

          'promotion_end_time' => 'promotion_end_time|string|false||促销结束日期',

          'is_group' => 'is_group|int|false|1|拼团设置 1-关闭 2-开启',

          'group_day' => 'group_day|int|false||成团有效时间（单位：天，最大设置为3天）',

          'group_price' => 'group_price|float|false||拼团价',

          'group_number' => 'group_number|int|false||限定人数（最大限定人数为100人 ）',

          'is_bargain' => 'is_bargain|int|false|1|砍价设置 1-关闭 2-开启',

          'bargain_day' => 'bargain_day|int|false||砍价有效时间（单位：天，最大设置为5天）',

          'bargain_price' => 'bargain_price|float|false||砍后价格',

          'bargain_number' => 'bargain_number|int|false||砍价人数（最大限定人数为100人 ）',

          'is_recommend' => 'is_recommend|int|false|1|推荐到首页 1-关闭 2-开启',

          'recommend_title' => 'recommend_title|string|false||推荐标题',

          'sort' => 'sort|int|false|0|排序，数字越大，排在越前面',

          'index_show' => 'index_show|int|false||首页展示'

      ),

      'getGoodsStock' => array(

            'goods_id' => 'goods_id|int|true||商品id',

            'sku_id' => 'sku_id|int|false||sku商品id',

      ),

      'getAllGoods' => array(
      
      )
      
    ));

  }
    
      /**
       * 获取商品库存接口服务
       * @desc 
       * @return int ret 操作状态：200表示成功
       * @return array data[] 参数集
       * @return int data.stock 库存
       * @return string msg 错误提示
       */
      public function getGoodsStock() {

            $params = $this->retriveRuleParams(__FUNCTION__);

            $regulation = array(

                  'goods_id' => 'required',

            );

            \App\Verification($params, $regulation);

            return $this->dm->getGoodsStock($params);

      }

      /**
       * 获取所有商品
       * @desc 获取所有商品
       *
       * @return int ret 操作状态：200表示成功
       * @return array data[] 结果集
       * @return string msg 错误提示
       */
      public function getAll() {

            $conditions = $this->retriveRuleParams(__FUNCTION__);

            return $this->dm->getAll($conditions);

      }

  /**
   * 编辑商品（包含SUK）
   * @desc 编辑商品（包含SUK）
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function editSkuGoods() {

    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->editSkuGoods($params);
  
  }

  /**
   * 添加商品（包含SUK）
   * @desc 添加商品（包含SUK）
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function addSkuGoods() {

    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->addSkuGoods($params);
  
  }

  /**
   * 新增商品
   * @desc 新增商品
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function add() {

    $params = $this->retriveRuleParams('add');

    return $this->dm->add($params);
  
  }

  /**
   * 修改商品
   * @desc 修改商品
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function update() {

    $regulation = array(

      'goods_id' => 'required',

    );

    $params = $this->retriveRuleParams('update');

    \App\Verification($params, $regulation);

    return $this->dm->update($params);
  
  }

  /**
   * 查询商品详情
   * @desc 查询商品详情
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function getDetail() {

    $conditions = $this->retriveRuleParams('getDetail');

    return $this->dm->getDetail($conditions);
  
  }

  /**
   * 查询商品列表
   * @desc 查询商品列表
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryList() {

    $conditions = $this->retriveRuleParams('queryList');

    return $this->dm->queryList($conditions);

  }

  /**
   * 查询商品数量
   * @desc 查询商品数量
   *
   * @return int ret 操作状态：200表示成功
   * @return array data[] 结果参数集
   * @return string msg 错误提示
   */
  public function queryCount() {

    $conditions = $this->retriveRuleParams('queryCount');
  
    $regulation = array();

    \App\Verification($conditions, $regulation);

    return $this->dm->queryCount($conditions);
  
  }

  /**
   * 查询所有商品
   * @desc 查询所有商品
   *
   * @return int ret
   */
  public function getAllGoods() {
  
    return $this->dm->getAllGoods($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
