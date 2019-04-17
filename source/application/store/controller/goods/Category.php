<?php

namespace app\store\controller\goods;

use app\store\controller\Controller;
use app\store\model\Category as CategoryModel;
use app\store\model\Goods as GoodsModel;
use app\store\model\Order as OrderModel;
use app\store\model\Settlement as SettlementModel;

/**
 * 商品分类
 * Class Category
 * @package app\store\controller\goods
 */
class Category extends Controller
{
    /**
     * 商品分类列表
     * @return mixed
     */
    public function index()
    {
        $model = new CategoryModel;
        $list = $model->getCacheTree(1);
        return $this->fetch('index', compact('list'));
    }

    /**
     * 商户列表
     * @return mixed
     */
    public function merchants()
    {
        $model = new CategoryModel;
        $list = $model->getCacheTree(2);
        $goodsModel = new GoodsModel;
        $orderModel = new OrderModel;
        foreach ($list as $key=>$val){
            $list[$key]['good_counts'] = $goodsModel->getCountByCate($val['category_id']);
            $list[$key]['order_counts'] = $orderModel->getCountByCate($val['category_id']);
            $list[$key]['total_prices'] = $orderModel->getTotalPriceByCate($val['category_id']);
            $list[$key]['pay_prices'] = $orderModel->getPayPriceByCate($val['category_id']);
            if($val['status'] == 0){
                $list[$key]['status_name'] = '休业中';
            } elseif ($val['status'] == 1){
                $list[$key]['status_name'] = '营业中';
            } elseif ($val['status'] == 2){
                $list[$key]['status_name'] = '下架';
            }
        }
        return $this->fetch('merchants', compact('list'));
    }

    /**
     * 删除商品分类
     * @param $category_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($category_id)
    {
        $model = CategoryModel::get($category_id);
        if (!$model->remove($category_id)) {
            $error = $model->getError() ?: '删除失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 添加商品分类
     * @return array|mixed
     */
    public function add()
    {
        $model = new CategoryModel;
        if (!$this->request->isAjax()) {
            // 获取所有地区
            $list = $model->getCacheTree();
            return $this->fetch('add', compact('list'));
        }
        // 新增记录
        if ($model->add($this->postData('category'))) {
            return $this->renderSuccess('添加成功', url('goods.category/index'));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }

    /**
     * 添加商户
     * @return array|mixed
     */
    public function mc_add()
    {
        $model = new CategoryModel;
        if (!$this->request->isAjax()) {
            // 获取所有地区
            $list = $model->getCacheTree(1);
            return $this->fetch('mc_add', compact('list'));
        }
        // 新增记录
        if ($model->add($this->postData('category'))) {
            return $this->renderSuccess('添加成功', url('goods.category/merchants'));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }

    /**
     * 编辑商品分类
     * @param $category_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($category_id)
    {
        // 模板详情
        $model = CategoryModel::get($category_id, ['image', 'zhao']);
        if (!$this->request->isAjax()) {
            // 获取所有地区
            $list = $model->getCacheTree();
            return $this->fetch('edit', compact('model', 'list'));
        }
        // 更新记录
        if ($model->edit($this->postData('category'))) {
            return $this->renderSuccess('更新成功', url('goods.category/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }

    /**
     * 编辑商户
     * @param $category_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function mc_edit($category_id)
    {
        // 模板详情
        $model = CategoryModel::get($category_id, ['image', 'zheng', 'zhao']);
        if (!$this->request->isAjax()) {
            // 获取所有地区
            $list = $model->getCacheTree(1);
            return $this->fetch('mc_edit', compact('model', 'list'));
        }
        // 更新记录
        if ($model->edit($this->postData('category'))) {
            return $this->renderSuccess('更新成功', url('goods.category/merchants'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }

    /**
     * 结算列表
     * @return mixed
     */
    public function settlement()
    {
        $category_id = input('category_id');
        if(!$category_id){
            $this->error('没有category_id');
        }
        $category = CategoryModel::get($category_id);

        $model = new SettlementModel;
        $list = $model->getSettlementList($category_id);
        return $this->fetch('settlement', compact('list', 'category'));
    }

    /**
     * 结算
     * @param $id
     * @return mixed
     */
    public function settlement_edit($id)
    {
        $this->updateSettlement();
        $model = SettlementModel::get($id);
        if (!$this->request->isPost()) {
            $category = CategoryModel::get($model['category_id']);
            return $this->fetch('settlement_edit', compact('model', 'category'));
        }
        $post = $this->postData('set');
        $post['status'] = 1;
        $model->editSettlement($post['id'], $post);
        $this->success('更新成功', 'goods.category/merchants');
    }

    /**
     * 更新结算
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function updateSettlement(){
        $dateArr = getDateFromRange('2019-03-01', date('Y-m-d', time()));
        foreach ($dateArr as $val){
            $beginYesterday = date('Y-m-d H:i:s', mktime(0,0,0,date('m', $val),date('d', $val)-1,date('Y', $val)));
            $endYesterday =date('Y-m-d H:i:s', mktime(0,0,0,date('m', $val),date('d', $val),date('Y', $val))-1);
            $category = model('category')->field('category_id, create_time')->where('parent_id','>',0)->select();
            foreach ($category as $vl) {
                if($val >= strtotime(date('Y-m-d', strtotime($vl['create_time'])))) {
                    $map['order_status'] = 30;
                    $map['receipt_status'] = 20;
                    $map['category_id'] = $vl['category_id'];
                    $num = model('order')->where($map)->whereTime('receipt_time', 'between', [$beginYesterday,$endYesterday])->count();
                    if($num > 0) {
                        $where['category_id'] = $vl['category_id'];
                        $where['statistics_date'] = $val;
                        $res = model('settlement')->where($where)->find();
                        if (!$res) {
                            $price = model('order')->where($map)->whereTime('receipt_time', 'between', [$beginYesterday,$endYesterday])->sum('pay_price');
                            $where['create_time'] = time();
                            $where['update_time'] = time();
                            $where['num'] = $num;
                            $where['price'] = $price;
                            model('settlement')->insert($where);
                        }
                    }
                }
            }
        }
    }

}
