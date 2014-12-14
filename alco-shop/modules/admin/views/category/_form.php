<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'parentId')->dropDownList(array_merge([""], ArrayHelper::map(Category::find()->all(), 'id', 'name')))->label('Parent category') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'photo')->fileInput(['accept'=>"image/gif, image/jpeg, image/png"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
