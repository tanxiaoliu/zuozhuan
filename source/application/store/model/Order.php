<?php

namespace app\store\model;

use app\common\model\Order as OrderModel;
use think\Request;

/**
 * 订单管理
 * Class Order
 * @package app\store\model
 */
class Order extends OrderModel
{
    /**
     * 订单列表
     * @param $filter
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($filter)
    {
        return $this->with(['goods.image', 'address', 'user'])
            ->where($filter)
            ->order(['create_time' => 'desc'])->paginate(10, false, [
                'query' => Request::instance()->request()
            ]);
    }

    /**
     * 确认发货
     * @param $data
     * @return bool|false|int
     */
    public function delivery($data)
    {
        if ($this['pay_status']['value'] == 10
            || $this['delivery_status']['value'] == 20) {
            $this->error = '该订单不合法';
            return false;
        }
        return $this->save([
            'express_company' => $data['express_company'],
            'express_no' => $data['express_no'],
            'delivery_status' => 20,
            'delivery_time' => time(),
        ]);
    }

    /**
     * 获取商户订单数量
     * @param $category_id
     * @return int|string
     */
    public function getCountByCate($category_id){
        return $this->where('category_id', $category_id)->count();
    }

    /**
     * 获取商户总销售金额
     * @param $category_id
     * @return int|string
     */
    public function getTotalPriceByCate($category_id){
        return $this->where('order_status', 30)->where('category_id', $category_id)->sum('total_price');
    }

    /**
     * 获取商户实付金额
     * @param $category_id
     * @return int|string
     */
    public function getPayPriceByCate($category_id){
        return $this->where('order_status', 30)->where('category_id', $category_id)->sum('pay_price');
    }

    /**
     * 获取商品分类
     * @param $category_id
     * @return array
     */
    public function getGoodType($category_id)
    {
        $category = $this->where('category_id', $category_id)->find();
        $good_type = explode('、', $category['good_type']);
        return $good_type;
    }
}
