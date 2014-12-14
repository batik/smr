<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = "Order #" . $model->id;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            ['attribute' => 'User', 'value' => $model->getUser()->one()->name],
            ['attribute' => 'Total price', 'value' => '$' . $model->totalPrice],
            'date',
            ['attribute' => 'Payment status', 'value' => ($model->paymentStatus == 0 ? "not paid" : "paid")],
        ],
    ]) ?>

    <h2>Items</h2>

    <?= GridView::widget([
        'dataProvider' => $items,
        'columns' => [
            'product.name',
            'quantity',
            ['value' => 'price', 'label' => 'Unit price'],
            ['label' => 'Sum', 'value' => function($data){return $data->price * $data->quantity;},
                'format' => ['decimal', 2]],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ]
    ])
    ?>

</div>
