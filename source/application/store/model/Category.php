<?php

namespace app\store\model;

use app\common\model\Category as CategoryModel;
use think\Cache;

/**
 * 商品分类模型
 * Class Category
 * @package app\store\model
 */
class Category extends CategoryModel
{
    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
//        if (!empty($data['image'])) {
//            $data['image_id'] = UploadFile::getFildIdByName($data['image']);
//        }
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }

    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }

    /**
     * 删除商品分类
     * @param $category_id
     * @return bool|int
     */
    public function remove($category_id)
    {
        // 判断是否存在商品
        if ($goodsCount = (new Goods)->where(compact('category_id'))->count()) {
            $this->error = '该分类下存在' . $goodsCount . '个商品，不允许删除';
            return false;
        }
        // 判断是否存在子分类
        if ((new self)->where(['parent_id' => $category_id])->count()) {
            $this->error = '该分类下存在子分类，请先删除';
            return false;
        }
        $this->deleteCache();
        return $this->delete();
    }

    /**
     * 删除缓存
     * @return bool
     */
    private function deleteCache()
    {
        Cache::rm('category_' . self::$wxapp_id);
        Cache::rm('category_one_' . self::$wxapp_id);
        return Cache::rm('category_two_' . self::$wxapp_id);
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
        $data = $this->where('category_id', $category_id)->find();
        return $data;
    }

}
