<link rel="stylesheet" href="assets/store/css/goods.css">
<link rel="stylesheet" href="assets/store/plugins/umeditor/themes/default/css/umeditor.css">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">基本信息</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="goods[goods_name]"
                                           value="" required>
                                </div>
                            </div>
                            <input type="hidden" class="tpl-form-input" name="goods[category_id]"
                                   value="<?= $category_id ?>">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">选择商品分类 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="goods[good_type]" required
                                            data-am-selected="{searchBox: 1, btnSize: 'sm',  placeholder:'请选择商品分类'}">
                                        <?php if (isset($good_type)): foreach ($good_type as $key => $vl): ?>
                                            <option value="<?= $key ?>"><?= $vl ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品图片 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="am-form-file">
                                            <button type="button"
                                                    class="upload-file am-btn am-btn-secondary am-radius">
                                                <i class="am-icon-cloud-upload"></i> 选择图片
                                            </button>
                                            <div class="uploader-list am-cf">
                                            </div>
                                        </div>
                                        <div class="help-block am-margin-top-sm">
                                            <small>尺寸750x750像素以上，大小2M以下 (可拖拽图片调整显示顺序 )</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">规格/库存</div>
                            </div>
                            <div class="goods-spec-single">
<!--                                <div class="am-form-group">-->
<!--                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">商品编码 </label>-->
<!--                                    <div class="am-u-sm-9 am-u-end">-->
<!--                                        <input type="text" class="tpl-form-input" name="goods[spec][goods_no]"-->
<!--                                               value="">-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品价格 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <input type="number" class="tpl-form-input" name="goods[spec][goods_price]"
                                               required>
                                    </div>
                                </div>
<!--                                <div class="am-form-group">-->
<!--                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label">商品划线价 </label>-->
<!--                                    <div class="am-u-sm-9 am-u-end">-->
<!--                                        <input type="number" class="tpl-form-input" name="goods[spec][line_price]">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="am-form-group">-->
<!--                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">当前库存数量 </label>-->
<!--                                    <div class="am-u-sm-9 am-u-end">-->
<!--                                        <input type="number" class="tpl-form-input" name="goods[spec][stock_num]"-->
<!--                                               required>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="am-form-group">-->
<!--                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品重量(Kg) </label>-->
<!--                                    <div class="am-u-sm-9 am-u-end">-->
<!--                                        <input type="number" class="tpl-form-input" name="goods[spec][goods_weight]"-->
<!--                                               required>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>

<!--                            <div class="am-form-group">-->
<!--                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">库存计算方式 </label>-->
<!--                                <div class="am-u-sm-9 am-u-end">-->
<!--                                    <label class="am-radio-inline">-->
<!--                                        <input type="radio" name="goods[deduct_stock_type]" value="10" data-am-ucheck>-->
<!--                                        下单减库存-->
<!--                                    </label>-->
<!--                                    <label class="am-radio-inline">-->
<!--                                        <input type="radio" name="goods[deduct_stock_type]" value="20" data-am-ucheck-->
<!--                                               checked>-->
<!--                                        付款减库存-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="widget-head am-cf">-->
<!--                                <div class="widget-title am-fl">其他</div>-->
<!--                            </div>-->
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[goods_status]" value="10" data-am-ucheck
                                               checked>
                                        上架
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[goods_status]" value="20" data-am-ucheck>
                                        下架
                                    </label>
                                </div>
                            </div>
<!--                            <div class="am-form-group">-->
<!--                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">初始销量</label>-->
<!--                                <div class="am-u-sm-9 am-u-end">-->
<!--                                    <input type="number" class="tpl-form-input" name="goods[sales_initial]"-->
<!--                                           value="0">-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="goods[goods_sort]"
                                           value="100" required>
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 图片文件列表模板 -->
{{include file="layouts/_template/tpl_file_item" /}}

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<!-- 商品多规格模板 -->
{{include file="goods/_template/spec_many" /}}

<script src="assets/store/js/ddsort.js"></script>
<script src="assets/store/plugins/umeditor/umeditor.config.js"></script>
<script src="assets/store/plugins/umeditor/umeditor.min.js"></script>
<script src="assets/store/js/goods.spec.js"></script>
<script>
    $(function () {

        // 富文本编辑器
        UM.getEditor('container');

        // 选择图片
        $('.upload-file').selectImages({
            name: 'goods[images][]'
            , multiple: true
        });

        // 图片列表拖动
        $('.uploader-list').DDSort({
            target: '.file-item',
            delay: 100, // 延时处理，默认为 50 ms，防止手抖点击 A 链接无效
            floatStyle: {
                'border': '1px solid #ccc',
                'background-color': '#fff'
            }
        });

        // 注册商品多规格组件
        var specMany = new GoodsSpec({
            container: '.goods-spec-many'
        });

        // 切换单/多规格
        $('input:radio[name="goods[spec_type]"]').change(function (e) {
            var $goodsSpecMany = $('.goods-spec-many')
                , $goodsSpecSingle = $('.goods-spec-single');
            if (e.currentTarget.value === '10') {
                $goodsSpecMany.hide() && $goodsSpecSingle.show();
            } else {
                $goodsSpecMany.show() && $goodsSpecSingle.hide();
            }
        });

        /**
         * 表单验证提交
         * @type {*}
         */
//        $('#my-form').superForm({
//            // form data
//            buildData: function () {
//                return {
//                    goods: {
//                        spec_many: specMany.getData()
//                    }
//                };
//            },
//            // 自定义验证
//            validation: function () {
//                var specType = $('input:radio[name="goods[spec_type]"]:checked').val();
//                if (specType === '20') {
//                    var isEmpty = specMany.isEmptySkuList();
//                    isEmpty === true && layer.msg('商品规格不能为空');
//                    return !isEmpty;
//                }
//                return true;
//            }
//        });
        $('#my-form').superForm();

    });
</script>
