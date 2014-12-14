<?php

use Yii as Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'price',
            'isAvailable:boolean',
            ['attribute' => 'Category', 'value' => $model->getCategory()->one()->name],
            ['attribute' => 'photo', 
                'value' => "<img src= '" . Url::to('@web/' . $model->photo ) . "' width='200px'></img>", 
                'format' => 'html'],
            'rating',
        ],
    ]) ?>

    <h2>Characteristics</h2>

    <?= GridView::widget([
        'dataProvider' => $modelAttributes,
        'columns' => [
            ['label' => 'Attribute', 'value' => 'categoryAttribute.name'],
            'value',
            ['label' => 'Unit', 'value' => 'categoryAttribute.unit'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'urlCreator' => 
                    function ($action, $model, $key, $index) {
                        $params = is_array($key) ? $key : ['id' => (string) $key];
                        $params[0] = '/admin/attributevalue' . '/' . $action;

                        return Url::toRoute($params);
                    }
            ],
        ],
    ]); ?>

    <?= Html::a('Add new', Url::toRoute('/admin/attributevalue/create?productId=' . $model->id), ['class' => 'btn btn-success']) ?>

    


</div>
