<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
?>
<div class="user-view">

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
            'id',
            'name',
            ['attribute' => 'Role', 'value' => $model->getRole()->one()->name],
            'email:email'
        ],
    ])?>

    <h2>Orders</h2>

    <?= GridView::widget([
        'dataProvider' => $orders,
        'columns' => [
            'id',
            ['attribute' => 'totalPrice', 'format' => ['decimal', 2]],
            'date:date',
            'paymentStatus:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'urlCreator' => 
                    function ($action, $model, $key, $index) {
                        $params = is_array($key) ? $key : ['id' => (string) $key];
                        $params[0] = '/admin/order' . '/' . $action;

                        return Url::toRoute($params);
                    }
            ],
        ],
        ]
    )?>



</div>
