<?php

use app\models\Attributes;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if(Yii::$app->controller->action->id == 'create')
    {
    	Html::activeHiddenInput($model, 'productId');

    
    	echo $form->field($model, 'attributeId')->dropDownList(ArrayHelper::map($attributes, 'id', 'name'))->label('Attribute');
    }?>


    <?= $form->field($model, 'value')->textInput(['maxlength' => 256]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
