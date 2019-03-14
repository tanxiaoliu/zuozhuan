<?php

namespace app\store\controller;

use app\store\model\Order as OrderModel;
use app\store\model\Category as CategoryModel;
use think\Request;

/**
 * 订单管理
 * Class Order
 * @package app\store\controller
 */
class Order extends Controller
{

    /**
     * 待发货订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function delivery_list()
    {
        $category_id = input('category_id');
        return $this->getList('待发货', [
            'pay_status' => 20,
            'delivery_status' => 10,
            'category_id' => $category_id
        ]);
    }

    /**
     * 待收货订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function receipt_list()
    {
        $category_id = input('category_id', 0);
        return $this->getList('待收货', [
            'pay_status' => 20,
            'delivery_status' => 20,
            'receipt_status' => 10,
            'category_id' => $category_id
        ]);
    }

    /**
     * 待付款订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function pay_list()
    {
        $category_id = input('category_id', 0);
        return $this->getList('待付款', ['pay_status' => 10, 'order_status' => 10, 'category_id' => $category_id]);
    }

    /**
     * 已完成订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function complete_list()
    {
        $category_id = input('category_id', 0);
        return $this->getList('已完成订单列表', ['order_status' => 30, 'category_id' => $category_id]);
    }

    /**
     * 已取消订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function cancel_list()
    {
        $category_id = input('category_id', 0);
        return $this->getList('已取消', ['order_status' => 20, 'category_id' => $category_id]);
    }

    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function all_list()
    {
        $category_id = input('category_id', 0);
        return $this->getList('全部订单', ['category_id' => $category_id]);
    }

    /**
     * 订单列表
     * @param $title
     * @param $filter
     * @return mixed
     * @throws \think\exception\DbException
     */
    private function getList($title, $filter = [])
    {
        $model = new OrderModel;
        $category_id = $filter['category_id'];
        if($filter['category_id'] == 0){
            unset($filter['category_id']);
        }
        $list = $model->getList($filter);
        return $this->fetch('index', compact('title','list', 'category_id'));
    }

    /**
     * 订单详情
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        $detail = OrderModel::detail($order_id);
        return $this->fetch('detail', compact('detail'));
    }

    /**
     * 确认发货
     * @param $order_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delivery($order_id)
    {
        $model = OrderModel::detail($order_id);
        if ($model->delivery($this->postData('order'))) {
            return $this->renderSuccess('发货成功');
        }
        $error = $model->getError() ?: '发货失败';
        return $this->renderError($error);
    }

}
