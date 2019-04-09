<?php

namespace app\store\model;
use think\Model;
use think\Request;

/**
 * 结算列表模型
 * Class Category
 * @package app\store\model
 */
class Settlement extends Model
{

    /**
     * 获取商户每日订单结算列表
     * @param $category_id
     * @return \think\Paginator
     */
    public function getSettlementList($category_id)
    {
        return $this->where('category_id', $category_id)->order(['create_time' => 'desc'])->paginate(10, false, [
            'query' => Request::instance()->request()
        ]);
    }

    /**
     * 获取商户每日订单结算列表
     * @param $id
     * @param $data
     * @return $this
     */
    public function editSettlement($id, $data)
    {
        return $this->where('id', $id)->update($data);
    }
}
