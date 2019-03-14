<?php

namespace app\api\controller;

use app\api\model\Category as CategoryModel;
use app\api\model\Goods as GoodsModel;
use app\api\model\Cart as CartModel;

/**
 * 商品分类控制器
 * Class Goods
 * @package app\api\controller
 */
class Category extends Controller
{
    /**
     * 首页商铺
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $category_id = input('category_id');
        $categoryModel = new CategoryModel;
        $goodsModel = new GoodsModel;
        $category = $categoryModel->getCategoryDetail($category_id);
        $list = $categoryModel->getGoodType($category_id);
        foreach ($list as $key=>$val){
            $goods_list[$key] = $goodsModel->getListByGoodType($category_id, $key);
        }

        $cart_total_num = 0;
        $user = $this->getUser();
        if($user) {
            $cartModel = new CartModel($user['user_id']);
            $cart_total_num = $cartModel->getTotalNum();
        }
        return $this->renderSuccess(compact('list', 'goods_list', 'category', 'cart_total_num'));
    }

    /**
     * 商铺列表
     * @param $category_id
     * @param $search
     * @param $sortType
     * @param $sortPrice
     * @return array
     * @throws \think\exception\DbException
     */
    public function categorylists($category_id, $search, $sortType, $sortPrice)
    {
        $categoryModel = new CategoryModel;
//        $model = new GoodsModel;
        $list = $categoryModel->getList(1, $category_id, $search, $sortType, $sortPrice);
        return $this->renderSuccess(compact('list'));
    }
}
