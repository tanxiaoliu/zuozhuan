<?php

namespace app\api\model;

use app\common\model\Category as CategoryModel;
use think\Request;

/**
 * 商品分类模型
 * Class Category
 * @package app\common\model
 */
class Category extends CategoryModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
//        'create_time',
        'update_time'
    ];

    /**
     * 获取商品列表
     * @param int $status
     * @param int $category_id
     * @param string $search
     * @param string $sortType
     * @param bool $sortPrice
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($status = null, $category_id = 0, $search = '', $sortType = 'all', $sortPrice = false)
    {
        // 筛选条件
        $filter = [];
        $filter['status'] = $status;
        !empty($search) && $filter['name'] = ['like', '%' . trim($search) . '%'];

        if($category_id > 0){
            $filter['parent_id'] = $category_id;
        } else {
            $filter['parent_id'] = array('<>', 0);
        }
        // 排序规则
        $sort = [];
        if ($sortType === 'all') {
            $sort = ['sort', 'category_id' => 'desc'];
        } elseif ($sortType === 'sales') {
            $sort = ['preferential' => 'desc'];
        }
//        elseif ($sortType === 'price') {
//            $sort = $sortPrice ? ['goods_max_price' => 'desc'] : ['goods_min_price'];
//        }
        // 商品表名称
//        $tableName = $this->getTable();
        // 多规格商品 最高价与最低价
//        $GoodsSpec = new GoodsSpec;
//        $minPriceSql = $GoodsSpec->field(['MIN(goods_price)'])
//            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();
//        $maxPriceSql = $GoodsSpec->field(['MAX(goods_price)'])
//            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();
        // 执行查询
        $list = $this->with(['image'])
            ->where($filter)
            ->order($sort)
            ->paginate(15, false, [
                'query' => Request::instance()->request()
            ]);
        return $list;
    }

    /**
     * 获取商户的商品分类
     * @param $category_id
     * @return array
     */
    public function getGoodType($category_id)
    {
        $category = $this->where('category_id', $category_id)->find();
        $good_type = explode('、', $category['good_type']);
        return $good_type;
    }

    /**
     * 获取分类详情
     * @param $category_id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCategoryDetail($category_id)
    {
        $data = $this->with(['image'])->where('category_id', $category_id)->find();
        return $data;
    }

}
