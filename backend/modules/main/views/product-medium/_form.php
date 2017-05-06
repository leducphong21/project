<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

?>
<div class="tabbable">
    <div class="widget-body">
        <div class="table-toolbar">
            <div class="widget">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-inline',
                        'role' => 'form'
                    ]
                ]); ?>
                <?php echo $form->errorSummary($model, [
                    'class' => 'alert alert-warning alert-dismissible',
                    'header' => ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Vui lòng sửa các lỗi sau</h4>'
                ]); ?>

                <h1>Thông tin sản phẩm</h1>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group ">Tên sản phẩm
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'name', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <span class="input-icon icon-right">
                         <label>Loại sản phẩm 1</label>
                            <?php
                            echo Select2::widget([
                                'model' => $model,
                                'attribute' => 'product_category_id',
                                'data' => $modelProductCategory,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'class' => 'form-control input-sm',
                                    'placeholder' => 'Chọn loại sản phẩm'
                                ],
                                'size' => Select2::SMALL,
                                'pluginOptions' => [
                                    'tags' => false,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 20
                                ],
                            ]);
                            ?>
                    </span>
                    </div>
                    <div class="col-sm-3">
                        <span class="input-icon icon-right">
                         <label>Dự án</label>
                            <?php
                            echo Select2::widget([
                                'model' => $model,
                                'attribute' => 'project_id',
                                'data' => $modelProject,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'class' => 'form-control input-sm',
                                    'placeholder' => 'Chọn dự án'
                                ],
                                'size' => Select2::SMALL,
                                'pluginOptions' => [
                                    'tags' => false,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 20
                                ],
                            ]);
                            ?>
                    </span>
                    </div>
                    <div class="col-sm-3">
                         <span class="input-icon icon-right">
                         <label>Chọn tỉnh thành</label>
                             <?php
                             echo Select2::widget([
                                 'model' => $model,
                                 'attribute' => 'city_id',
                                 'data' => $modelCity,
                                 'theme' => Select2::THEME_BOOTSTRAP,
                                 'options' => [
                                     'class' => 'form-control input-sm',
                                     'placeholder' => 'Chọn tỉnh thành'
                                 ],
                                 'size' => Select2::SMALL,
                                 'pluginOptions' => [
                                     'tags' => false,
                                     'tokenSeparators' => [',', ' '],
                                     'maximumInputLength' => 20
                                 ],
                             ]);
                             ?>
                    </span>
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                         <span class="input-icon icon-right">
                         <label>Chọn quận huyện</label>
                             <?php
                             echo Select2::widget([
                                 'model' => $model,
                                 'attribute' => 'county_id',
                                 'data' => $modelCounty,
                                 'theme' => Select2::THEME_BOOTSTRAP,
                                 'options' => [
                                     'class' => 'form-control input-sm',
                                     'placeholder' => 'Chọn quận huyện'
                                 ],
                                 'size' => Select2::SMALL,
                                 'pluginOptions' => [
                                     'tags' => false,
                                     'tokenSeparators' => [',', ' '],
                                     'maximumInputLength' => 20
                                 ],
                             ]);
                             ?>
                    </span>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Giá mết vuông
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'price', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Diện tích
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'acreage', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Lãi
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'interest', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>

                </div>
                <br>
                <h1>Thông tin chủ sở hữu</h1>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Chủ sở hữu</label>
                            <span class="input-icon icon-right">
                                        <div class="input-group input-group-sm group-select_car_no select2-bootstrap-append"><select id="select_car_no" class="form-control input-sm select2-hidden-accessible" name="CarTicket[id]" data-s2-options="s2options_6cc131ae" data-krajee-select2="select2_1b68687e" style="display:none" tabindex="-1" aria-hidden="true">
<option value="">Chọn chủ sở hữu ...</option>
<option value=""></option>
</select><span class="select2 select2-container select2-container--bootstrap" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-select_car_no-container"><span class="select2-selection__rendered" id="select2-select_car_no-container"><span class="select2-selection__placeholder">Chọn biển số xe ...</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span><span class="input-group-addon"><i id="btnAddNewCar" class="fa fa-plus blue imouse" title="Thêm mới xe"></i></span></div>                                     </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Địa chỉ
                            <span class="input-icon icon-right">
                             <input class="form-control" disabled="disabled" style="width: 100%" />
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Điện thoại
                            <span class="input-icon icon-right">
                             <input class="form-control" disabled="disabled" style="width: 100%" />
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Email
                            <span class="input-icon icon-right">
                             <input class="form-control" disabled="disabled" style="width: 100%" />
                         </span>
                        </div>
                    </div>
                </div>
                <br>
                <h1>Mô tả chi tiết sản phẩm</h1>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group ">Địa chỉ
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'address', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Số tầng
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'floors', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Tổng số phòng
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'rooms', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Số phòng ngủ
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'bedrooms', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group ">Số phòng về sinh
                            <span class="input-icon icon-right">
                             <?=Html::activeTextInput($model, 'bathrooms', ['class' => 'form-control', 'style' =>'width: 100%;'])?>
                         </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group ">Hình ảnh
                            <span class="input-icon icon-right">
                             <?= $form->field($modelImage, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                         </span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group ">Mô tả
                            <span class="input-icon icon-right">
                             <?=Html::activeTextarea($model, 'description', ['class' => 'form-control', 'style' =>'width: 500px; height: 200px;'])?>
                         </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class=" pull-right">
                    <div class="btn-group pull-right">
                        <button type="submit" class="btn btn-success" href="javascript:void(0);">
                            <i class="fa fa-save"></i>Lưu lại</button>
                        <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['index'])?>"><i class="fa fa-backward"></i>Quay lại</a>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
