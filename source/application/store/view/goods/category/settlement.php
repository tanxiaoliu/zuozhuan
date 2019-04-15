
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">
                        <?= $category['name'] ?>商户结算列表</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>日期</th>
                                <th>销售额</th>
                                <th>销售订单数</th>
                                <th>是否结算</th>
                                <th>结算备注</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= date('Y-m-d', $item['statistics_date'])?></td>
                                    <td class="am-text-middle"><?= $item['price'] ?></td>
                                    <td class="am-text-middle"><?= $item['num'] ?></td>

                                    <?php if ($item['status'] == 1): ?>
                                        <td class="am-text-middle">是</td>
                                        <td class="am-text-middle"><?= $item['remark'] ?></td>
                                        <td class="am-text-middle"></td>
                                    <?php else: ?>
                                        <td class="am-text-middle">否</td>
                                        <td class="am-text-middle"></td>
                                        <td class="am-text-middle">
                                            <div class="tpl-table-black-operation">
                                                <a href="<?= url('goods.category/settlement_edit',
                                                    ['id' => $item['id'],]) ?>">
                                                    <i class="am-icon-pencil"></i> 结算
                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="9" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="am-u-lg-12 am-cf">
                        <div class="am-fr"><?= $list->render() ?> </div>
                        <div class="am-fr pagination-total am-margin-right">
                            <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
