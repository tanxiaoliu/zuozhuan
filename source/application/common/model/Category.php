<?php

namespace app\common\model;

use think\Cache;

/**
 * 商品分类模型
 * Class Category
 * @package app\common\model
 */
class Category extends BaseModel
{
    protected $name = 'category';

    /**
     * 分类图片
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne('uploadFile', 'file_id', 'image_id');
    }

    /**
     * 证件图片
     * @return \think\model\relation\HasOne
     */
    public function zheng()
    {
        return $this->hasOne('uploadFile', 'file_id', 'zheng_id');
    }

    /**
     * 执照
     * @return \think\model\relation\HasOne
     */
    public function zhao()
    {
        return $this->hasOne('uploadFile', 'file_id', 'zhao_id');
    }

    /**
     * 所有分类
     * @param $type
     * @param $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getALL($type, $where)
    {
        $model = new static;
        if($type == 0) {
                $data = $model->with(['image'])->where($where)->order(['sort' => 'asc'])->select();
                $all = !empty($data) ? $data->toArray() : [];
                $tree = [];
                foreach ($all as $first) {
                    if ($first['parent_id'] != 0) continue;
                    $twoTree = [];
                    foreach ($all as $two) {
                        if ($two['parent_id'] != $first['category_id']) continue;
                        $threeTree = [];
                        foreach ($all as $three)
                            $three['parent_id'] == $two['category_id']
                            && $threeTree[$three['category_id']] = $three;
                        !empty($threeTree) && $two['child'] = $threeTree;
                        $twoTree[$two['category_id']] = $two;
                    }
                    if (!empty($twoTree)) {
                        array_multisort(array_column($twoTree, 'sort'), SORT_ASC, $twoTree);
                        $first['child'] = $twoTree;
                    }
                    $tree[$first['category_id']] = $first;
                }
//            Cache::set('category_' . $model::$wxapp_id, compact('all', 'tree'));
//            return Cache::get('category_' . $model::$wxapp_id);
            return compact('all', 'tree');
        } else if($type == 1) {
            $data = $model->with(['image'])->where('parent_id', 0)->where($where)->order(['sort' => 'asc'])->select();
            $all = !empty($data) ? $data->toArray() : [];
            $tree = [];
            foreach ($all as $first) {
                $tree[$first['category_id']] = $first;
            }
            return compact('all', 'tree');
        } else if($type == 2) {
            $data = $model->with(['image'])->where('parent_id', '>', 0)->where($where)->order(['sort' => 'asc'])->select();
            $all = !empty($data) ? $data->toArray() : [];
            $tree = [];
            foreach ($all as $first) {
                $first['category_name'] = $model->where('category_id', $first['parent_id'])->value('name');
                $tree[$first['category_id']] = $first;
            }
            return compact('all', 'tree');
        }
    }

    /**
     * 获取所有分类
     * @param int $type
     * @param array $where
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getCacheAll($type = 0, $where = array())
    {
        return self::getALL($type, $where)['all'];
    }

    /**
     * 获取所有分类(树状结构)
     * @param int $type
     * @param array $where
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getCacheTree($type = 0, $where = array())
    {
        return self::getALL($type, $where)['tree'];
    }

}
