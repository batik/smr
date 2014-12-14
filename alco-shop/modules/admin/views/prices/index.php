<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Price Snapshots';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-snapshot-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Price Snapshot', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            ['attribute' => 'Product',  'value' => function($data)
                { 
                    return "<a href='" . Url::to('@web/admin/product/view?id=' . $data->product->id)  . "'>" . 
                        $data->product->name . "</a>";
                },
             'format' => 'html',
            ],
            'price',
            'expireDate',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
        ],
    ]); ?>

</div>
