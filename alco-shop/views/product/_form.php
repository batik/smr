<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'isAvailable')->textInput() ?>

    <?= $form->field($model, 'categoryId')->textInput() ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'ratingAmount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
