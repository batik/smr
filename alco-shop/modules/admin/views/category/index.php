<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            ['attribute' => 'Parent category', 'value' => function($data)
                {
                    $parent = $data->getParent()->one();
                    if($parent)
                    {
                        return $parent->name;
                    }
                    return "";
                }
            ],
            'name',
            'photo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
