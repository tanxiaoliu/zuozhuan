<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加商户</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商户名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[name]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商户分类 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="category[parent_id]"
                                            data-am-selected="{searchBox: 1, btnSize: 'sm'}">
                                        <?php if (isset($list)): foreach ($list as $first): ?>
                                            <option value="<?= $first['category_id'] ?>">
                                                <?= $first['name'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">商户封面 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <button type="button"
                                                class="upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择图片
                                        </button>
                                        <div class="uploader-list am-cf">
                                        </div>
                                    </div>
                                    <div class="help-block am-margin-top-sm">
                                        <small>尺寸150x150像素以上，大小2M以下</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">营业执照 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <button type="button"
                                                class="upload-zhao am-btn am-btn-secondary am-radius" style="font-size: 1.24rem;padding: .6em 1em;">
                                            <i class="am-icon-cloud-upload"></i> 选择图片
                                        </button>
                                        <div class="uploader-list am-cf">
                                        </div>
                                    </div>
                                    <div class="help-block am-margin-top-sm">
                                        <small>大小2M以下</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">卫生许可证 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <button type="button"
                                                class="upload-zheng am-btn am-btn-secondary am-radius" style="font-size: 1.24rem;padding: .6em 1em;">
                                            <i class="am-icon-cloud-upload"></i> 选择图片
                                        </button>
                                        <div class="uploader-list am-cf">
                                        </div>
                                    </div>
                                    <div class="help-block am-margin-top-sm">
                                        <small>大小2M以下</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">联系人 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[contact]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">联系人电话 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[phone]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">地址 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[address]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品分类（饮料、小吃） </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[good_type]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">满减（50-10）</label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[preferential]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">起送价 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="category[start_price]"
                                           value="10" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">配送费 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="category[send_price]"
                                           value="0" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">公告 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="category[notice]"
                                           value="">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商户状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="category[status]" value="1" data-am-ucheck
                                               checked>
                                        营业中
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="category[status]" value="0" data-am-ucheck>
                                        休业
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="category[status]" value="2" data-am-ucheck>
                                        下架
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">分类排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="category[sort]"
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

<script>
    $(function () {

        // 选择图片
        $('.upload-file').selectImages({
            name: 'category[image_id]'
        });

        // 许可证
        $('.upload-zheng').selectImages({
            name: 'category[zheng_id]'
        });

        // 执照
        $('.upload-zhao').selectImages({
            name: 'category[zhao_id]'
        });
        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
