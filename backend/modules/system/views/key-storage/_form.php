<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\KeyStorageItem */
/* @var $form yii\bootstrap\ActiveForm */
?>
<div class="tabbable">
    <div class="widget-body">
        <div class="key-storage-item-form">

            <?php $form = ActiveForm::begin(); ?>

            <?php echo $form->field($model, 'key')->textInput() ?>

            <?php echo $form->field($model, 'value')->textInput() ?>

            <?php echo $form->field($model, 'comment')->textarea() ?>

            <div class="form-group">
                <?php echo Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>

