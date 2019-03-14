<?php

namespace app\api\model;

use think\Cache;

/**
 * 购物车管理
 * Class Cart
 * @package app\api\model
 */
class Cart
{
    /* @var string $error 错误信息 */
    public $error = '';

    /* @var int $user_id 用户id */
    private $user_id;

    /* @var array $cart 购物车列表 */
    private $cart = [];

    /* @var bool $clear 是否清空购物车 */
    private $clear = false;

    /**
     * 构造方法
     * Cart constructor.
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->cart = Cache::get('cart_' . $this->user_id) ?: [];
    }

    /**
     * 购物车列表
     * @param \think\Model|\think\Collection $user
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList($user)
    {
        error_reporting(0);
        // 商品列表
        $goodsList = [];

        $goodsIds = array_unique(array_column($this->cart, 'goods_id'));
        foreach ((new Goods)->getListByIds($goodsIds) as $goods) {
            $goodsList[$goods['goods_id']] = $goods;
        }
        // 当前用户收货城市id
//        $cityId = $user['address_default'] ? $user['address_default']['city_id'] : null;
        // 是否存在收货地址
        $exist_address = !$user['address']->isEmpty();
        // 商品是否在配送范围
        $intraRegion = true;
        // 购物车商品列表
//        var_dump($this->cart);exit;
        $cartList = [];
//        $sendPrice = [];
//        $preferentialPrice = [];
        $category = [];
        foreach ($this->cart as $key => $cart) {
            // 判断商品不存在则自动删除
            if (!isset($goodsList[$cart['goods_id']])) {
                $this->delete($cart['goods_id'], $cart['goods_sku_id'], $cart['category_id']);
                continue;
            }

            /* @var Goods $goods */
            $goods = $goodsList[$cart['goods_id']];
            // 商品sku信息
            $goods['goods_sku_id'] = $cart['goods_sku_id'];
            // 商品sku不存在则自动删除
//            if (!$goods['goods_sku'] = $goods->getGoodsSku($cart['goods_sku_id'])) {
//                $this->delete($cart['goods_id'], $cart['goods_sku_id']);
//                continue;
//            }

            // 商家休业或者下架自动删除商品
            if ($goods['category']['status'] != 1) {
                $this->delete($cart['goods_id'], $cart['goods_sku_id'], $cart['category_id']);
                continue;
            }

            // 判断商品是否下架
            if ($goods['goods_status']['value'] != 10) {
                $this->setError('很抱歉，商品 [' . $goods['goods_name'] . '] 已下架');
            }
            // 判断商品库存
//            if ($cart['goods_num'] > $goods['goods_sku']['stock_num']) {
//                $this->setError('很抱歉，商品 [' . $goods['goods_name'] . '] 库存不足');
//            }

            // 商品单价
//            $goods['goods_price'] = $goods['goods_sku']['goods_price'];
            $goods['goods_price'] = $goods['spec'][0]['goods_price'];

            // 商品总价
            $goods['total_num'] = $cart['goods_num'];
            $goods['total_price'] = $total_price = bcmul($goods['goods_price'], $cart['goods_num'], 2);

            // 商品总重量
//            $goods['goods_total_weight'] = bcmul($goods['goods_sku']['goods_weight'], $cart['goods_num'], 2);
            // 验证用户收货地址是否存在运费规则中
//            if ($intraRegion = $goods['delivery']->checkAddress($cityId)) {
//                $goods['express_price'] = $goods['delivery']->calcTotalFee(
//                    $cart['goods_num'], $goods['goods_total_weight'], $cityId);
//            } else {
//                $exist_address && $this->setError("很抱歉，您的收货地址不在商品 [{$goods['goods_name']}] 的配送范围内");
//            }

            //店铺总的商品价
//            $category_price = $goods['spec'][0]['goods_price'] * $cart['goods_num'];

            //判断起送价
//            if ($goods['category']['start_price'] > $category_price) {
//                $this->setError('商铺'.$goods['category']['name'].'订单起送价不足，请重新下单');
//            }
            //减免
//            if($goods['category']['preferential']) {
//                $preferential = explode('-', $goods['category']['preferential']);
//                if ($category_price > $preferential[0]) {
//                    $preferentialPrice[$goods['category']['category_id']] = $preferential[1];
//                }
//            }
            $category = $goods['category'];
            $cartList[] = $goods->toArray();
        }

        //减免总金额
//        $mjPrice = array_sum($preferentialPrice)?:0.00;

        // 商品总金额
        $orderTotalPrice = array_sum(array_column($cartList, 'total_price'));

        //减免金额
        $mjPrice = 0.00;
        if($category['preferential']) {
            $preferential = explode('-', $category['preferential']);
            if ($orderTotalPrice > $preferential[0]) {
                $mjPrice = $preferential[1];
            }
        }


        //判断起送价
        if ($category['start_price'] > $orderTotalPrice) {
            $this->setError('商铺'.$category['name'].'订单起送价不足，请重新下单');
        }

        // 满减商品总金额
        $mjTotalPrice = bcsub($orderTotalPrice, $mjPrice, 2);
        // 所有商品的运费金额
//        $allExpressPrice = array_column($cartList, 'express_price');
        // 订单总运费金额
//        $expressPrice = $allExpressPrice ? Delivery::freightRule($allExpressPrice) : 0.00;
        $expressPrice = $category['send_price']?:0.00;
        return [
            'goods_list' => $cartList,                       // 商品列表
            'category' => $category,                       // 商品列表
            'order_total_num' => $this->getTotalNum(),       // 商品总数量
            'order_total_price' => round($orderTotalPrice, 2),              // 商品总金额 (不含运费)
            'order_pay_price' => bcadd($mjTotalPrice, $expressPrice, 2),    // 实际支付金额
            'address' => $user['address_default'],  // 默认地址
            'exist_address' => $exist_address,      // 是否存在收货地址
            'express_price' => $expressPrice,       // 配送费用
            'mj_price' => $mjPrice,       // 减免金额
            'intra_region' => $intraRegion,         // 当前用户收货城市是否存在配送规则中
            'has_error' => $this->hasError(),
            'error_msg' => $this->getError(),
        ];
    }

    /**
     * 添加购物车
     * @param $goods_id
     * @param $goods_num
     * @param $goods_sku_id
     * @param $category_id
     * @return bool
     * @throws \think\exception\DbException
     */
    public function add($goods_id, $goods_num, $goods_sku_id, $category_id)
    {
        // 购物车商品索引
//        $index = $goods_id . '_' . $goods_sku_id;
        $index = $category_id. '_' . $goods_id ;
        // 商品信息
        $goods = Goods::detail($goods_id);
        // 商品sku信息
//        $goods['goods_sku'] = $goods->getGoodsSku($goods_sku_id);
        // 判断商品是否下架
        if ($goods['goods_status']['value'] != 10) {
            $this->setError('很抱歉，该商品已下架');
            return false;
        }
        // 判断商品库存
        $cartGoodsNum = $goods_num + (isset($this->cart[$index]) ? $this->cart[$index]['goods_num'] : 0);
//        if ($cartGoodsNum > $goods['goods_sku']['stock_num']) {
//            $this->setError('很抱歉，商品库存不足');
//            return false;
//        }
        $create_time = time();
        $data = compact('category_id', 'goods_id', 'goods_num', 'goods_sku_id', 'create_time');

        if (empty($this->cart)) {
            $this->cart[$index] = $data;
            return true;
        } else {
            foreach ($this->cart as $key=>$val){
                if($val['category_id'] != $category_id){
                    $idx = $val['category_id'] . '_' . $val['goods_id'];
                    unset($this->cart[$idx]);
                }
            }
            $this->cart[$index] = $data;
        }
        isset($this->cart[$index]) ? $this->cart[$index]['goods_num'] = $cartGoodsNum : $this->cart[$index] = $data;
        return true;
    }

    /**
     * 减少购物车中某商品数量
     * @param $goods_id
     * @param $goods_sku_id
     * @param $category_id
     */
    public function sub($goods_id, $goods_sku_id, $category_id)
    {
//        $index = $goods_id . '_' . $goods_sku_id;
        $index = $category_id. '_' . $goods_id ;
        $this->cart[$index]['goods_num'] > 1 && $this->cart[$index]['goods_num']--;
    }

    /**
     * 删除购物车中指定商品
     * @param $goods_id
     * @param $goods_sku_id
     * @param $category_id
     */
    public function delete($goods_id, $goods_sku_id, $category_id)
    {
//        $index = $goods_id . '_' . $goods_sku_id;
        $index = $category_id. '_' . $goods_id ;
        unset($this->cart[$index]);
    }

    /**
     * 获取当前用户购物车商品总数量
     * @return int
     */
    public function getTotalNum()
    {
        return array_sum(array_column($this->cart, 'goods_num'));
    }

    /**
     * 析构方法
     * 将cart数据保存到缓存文件
     */
    public function __destruct()
    {
        $this->clear !== true && Cache::set('cart_' . $this->user_id, $this->cart, 86400 * 15);
    }

    /**
     * 清空当前用户购物车
     */
    public function clearAll()
    {
        $this->clear = true;
        Cache::rm('cart_' . $this->user_id);
    }

    /**
     * 设置错误信息
     * @param $error
     */
    private function setError($error)
    {
        empty($this->error) && $this->error = $error;
    }

    /**
     * 是否存在错误
     * @return bool
     */
    private function hasError()
    {
        return !empty($this->error);
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

}
