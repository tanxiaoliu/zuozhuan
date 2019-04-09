<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">商户列表</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-form-group">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <a class="am-btn am-btn-default am-btn-success am-radius"
                                       href="<?= url('goods.category/mc_add') ?>">
                                        <span class="am-icon-plus"></span> 新增
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black ">
                            <thead>
                            <tr>
                                <th>商户ID</th>
                                <th>商户名称</th>
                                <th>所属分类</th>
                                <th>商户联系人</th>
                                <th>商户电话</th>
                                <th>商品数量</th>
                                <th>订单数</th>
                                <th>销售金额</th>
                                <th>实收金额</th>
                                <th>状态</th>
                                <th>商户排序</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($list)): foreach ($list as $first): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $first['category_id'] ?></td>
                                    <td class="am-text-middle"><?= $first['name'] ?></td>
                                    <td class="am-text-middle"><?= $first['category_name'] ?></td>
                                    <td class="am-text-middle"><?= $first['contact'] ?></td>
                                    <td class="am-text-middle"><?= $first['phone'] ?></td>
                                    <td class="am-text-middle"> <a href="<?= url('/store/goods/index',
                                            ['category_id' => $first['category_id']]) ?>"><?= $first['good_counts'] ?></a></td>
                                    <td class="am-text-middle"> <a href="<?= url('/store/order/delivery_list',
                                            ['category_id' => $first['category_id']]) ?>"><?= $first['order_counts'] ?></a></td>
                                    <td class="am-text-middle"><?= $first['total_prices'] ?></td>
                                    <td class="am-text-middle"><?= $first['pay_prices'] ?></td>
                                    <td class="am-text-middle">
                                            <span class="<?= $first['status'] == 1 ? 'x-color-green'
                                                : 'x-color-red' ?>">
                                            <?= $first['status_name'] ?>
                                            </span>
                                    </td>
                                    <td class="am-text-middle"><?= $first['sort'] ?></td>
                                    <td class="am-text-middle"><?= $first['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <a href="<?= url('goods.category/settlement',
                                                ['category_id' => $first['category_id']]) ?>">
                                                <i class="am-icon-pencil"></i> 结算
                                            </a>
                                            <a href="<?= url('/store/goods/add',
                                                ['category_id' => $first['category_id']]) ?>">
                                                <i class="am-icon-plus"></i> 添加商品
                                            </a>
                                            <a href="<?= url('goods.category/mc_edit',
                                                ['category_id' => $first['category_id']]) ?>">
                                                <i class="am-icon-pencil"></i> 编辑
                                            </a>
                                            <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                               data-id="<?= $first['category_id'] ?>">
                                                <i class="am-icon-trash"></i> 删除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="12" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        // 删除元素
        var url = "<?= url('goods.category/delete') ?>";
        $('.item-delete').delete('category_id', url);

    });
</script>

