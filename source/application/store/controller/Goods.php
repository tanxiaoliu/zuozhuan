<?php

namespace app\store\controller;

use app\store\model\Category;
use app\store\model\Delivery;
use app\store\model\Goods as GoodsModel;
use app\store\model\Category as CategoryModel;

/**
 * 商品管理控制器
 * Class Goods
 * @package app\store\controller
 */
class Goods extends Controller
{

    /**
     * 商品列表(出售中)
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $category_id = input('category_id');
        $categoryModel = new CategoryModel;
        $category = $categoryModel->where('category_id', $category_id)->find();
        $model = new GoodsModel;
        if($category_id) {
            $list = $model->getList(null, $category_id);
            $types = $categoryModel->getGoodType($category_id);
            foreach ($list as $key=>$vl){
                $list[$key]['good_type_name'] = $types[$vl['good_type']];
            }
        } else {
            $list = $model->getList();
            foreach ($list as $key=>$vl){
                $types = $categoryModel->getGoodType($vl['category_id']);
                $list[$key]['good_type_name'] = $types[$vl['good_type']];
            }
        }
        return $this->fetch('index', compact('list', 'category'));
    }

    /**
     * 添加商品
     * @return array|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            //商品分类
            $category_id = input('category_id');
            $categoryModel = new CategoryModel;
            $good_type = $categoryModel->getGoodType($category_id);
            $this->assign('good_type', $good_type);
            // 商户
//            $catgory = Category::getCacheTree();
            // 配送模板
//            $delivery = Delivery::getAll();
            return $this->fetch('add', compact('catgory', 'delivery', 'category_id'));
        }
        $model = new GoodsModel;
        if ($model->add($this->postData('goods'))) {
            return $this->renderSuccess('添加成功', url('goods/index', ['category_id' => $model['category_id']]));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }

    /**
     * 删除商品
     * @param $goods_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($goods_id)
    {
        $model = GoodsModel::get($goods_id);
        if (!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 商品编辑
     * @param $goods_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($goods_id)
    {
        // 商品详情
        $model = GoodsModel::detail($goods_id);
        if (!$this->request->isAjax()) {
            //商品分类
            $categoryModel = new CategoryModel;
            $good_type = $categoryModel->getGoodType($model['category_id']);
            // 商品分类
//            $catgory = Category::getCacheTree();
            // 配送模板
//            $delivery = Delivery::getAll();
            // 多规格信息
//            $specData = 'null';
//            if ($model['spec_type'] == 20)
                $specData = json_encode($model->getManySpecData($model['spec_rel'], $model['spec']));
//            return $this->fetch('edit', compact('model', 'catgory', 'delivery', 'specData'));
            return $this->fetch('edit', compact('model', 'good_type', 'specData'));
        }
        // 更新记录
        if ($model->edit($this->postData('goods'))) {
            return $this->renderSuccess('更新成功', url('goods/index', ['category_id' => $model['category_id']]));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }

}
