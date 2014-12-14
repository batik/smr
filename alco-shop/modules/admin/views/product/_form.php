<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => 500]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => 7]) ?>

    <?= $form->field($model, 'isAvailable')->radioList(ArrayHelper::map([['value' => '1', 'label' => 'yes'],
                                                        ['value' => '0', 'label' => 'no']], 'value', 'label'),
                                                        ['style' => 'margin-bottom:5px']) ?>

    <?= $form->field($model, 'categoryId')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name'))->label('Category') ?>

    <?= $form->field($model, 'photo')->fileInput(['accept'=>"image/gif, image/jpeg, image/png"]) ?>

    <img src='<?= Url::to('@web/' . $model->photo ) ?>' style='margin-bottom:10px'/>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
