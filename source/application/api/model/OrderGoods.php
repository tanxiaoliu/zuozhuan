<?php

namespace app\api\model;

use app\common\model\OrderGoods as OrderGoodsModel;

/**
 * 订单商品模型
 * Class OrderGoods
 * @package app\api\model
 */
class OrderGoods extends OrderGoodsModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'content',
        'wxapp_id',
        'create_time',
    ];

    /**
     * 返回购买商品的名称
     * @param $order_id
     * @return string
     */
    public function getGoodsNameByOrderId($order_id)
    {
        $result = $this->where('order_id', $order_id)->column('goods_name');
        $str = '';
        if($result){
            foreach ($result as $val){
                $str .= $val['goods_name'];
            }
        }
        return $str;
    }
}
