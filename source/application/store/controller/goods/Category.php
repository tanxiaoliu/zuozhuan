<?php

namespace app\store\controller\goods;

use app\store\controller\Controller;
use app\store\model\Category as CategoryModel;
use app\store\model\Goods as GoodsModel;
use app\store\model\Order as OrderModel;

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


}
