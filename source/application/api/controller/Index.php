<?php

namespace app\api\controller;

use app\api\model\WxappPage;
use app\api\model\Goods as GoodsModel;
use app\api\model\Category as CategoryModel;

/**
 * 首页控制器
 * Class Index
 * @package app\api\controller
 */
class Index extends Controller
{
    /**
     * 首页diy数据
     * @return array
     * @throws \think\exception\DbException
     */
    public function page()
    {
        //分类
        $list = array_values(CategoryModel::getCacheAll(1));
        // 页面元素
        $wxappPage = WxappPage::detail();
        $items = $wxappPage['page_data']['array']['items'];
        //热门店铺
        $map['status'] = array('<', 2);
        $hodlist =  array_values(CategoryModel::getCacheAll(2, $map));
        // 新品推荐
//        $model = new GoodsModel;
//        $newest = $model->getNewList();
        // 猜您喜欢
//        $best = $model->getBestList();
        return $this->renderSuccess(compact('list', 'items', 'hodlist'));
    }

}
