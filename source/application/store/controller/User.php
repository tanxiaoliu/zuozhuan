<?php

namespace app\store\controller;

use app\store\model\User as UserModel;
use app\store\model\Category as CategoryModel;

/**
 * 用户管理
 * Class User
 * @package app\store\controller
 */
class User extends Controller
{
    /**
     * 用户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new UserModel;
        $list = $model->getList();
        $categoryModel = new CategoryModel;
        foreach ($list as $key=>$val){
            if($val['category_id']) {
                $category= $categoryModel->getCategoryDetail($val['category_id']);
                $list[$key]['category_name'] = $category['name'];
            } else {
                $list[$key]['category_name'] = '普通用户';
            }
        }
        return $this->fetch('index', compact('list'));
    }

    /**
     * 编辑用户
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        $model = new UserModel;
        if (!$this->request->isAjax()) {
            //商品分类
            $user_id = input('user_id');
            $user = $model->find($user_id);
            $categoryModel = new CategoryModel;
            $list = $categoryModel->getCacheTree(2);
            return $this->fetch('edit', compact('user', 'list'));
        }
        $user = $this->postData('user');
        if($user['category_id'] != 0 && $model->where('category_id', $user['category_id'])->where('user_id', 'neq', $user['user_id'])->find()){
            return $this->renderError('该商户已经绑定了其他用户，请重新绑定');
        }
        if ($model->where('user_id', $user['user_id'])->update($user)) {
            return $this->renderSuccess('更新成功', url('user/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }

}
