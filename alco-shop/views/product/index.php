<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';

if(isset($_GET['ProductSearch']))
{
    $params = $_GET['ProductSearch'];
    $name = isset($params['name']) ? $params['name'] : null;
    $categoryId = isset($params['categoryId']) ? $params['categoryId'] : null;
    $minPrice = isset($params['minPrice']) ? $params['minPrice'] : null;
    $maxPrice = isset($params['maxPrice']) ? $params['maxPrice'] : null;
}
else
{
    $name = $categoryId = $minPrice = $maxPrice = null;
}
?>
<div class="product-index">


    <div class="panel panel-default" style='margin:15px'>
        <div class="panel-body">
            <?=Html::beginForm('all', 'get') ?>
            <b>Category:</b> <?= Html::dropDownList('ProductSearch[categoryId]', $categoryId, ArrayHelper::map($categories, 'id', 'name')) ?>
            <b>Search:</b> <?= Html::input('text', 'ProductSearch[name]', $name, ['style' => 'margin-right:5px'])?>
            <b>Min price:</b> <?= Html::input('number', 'ProductSearch[minPrice]',$minPrice , ['style' => 'margin-right:5px'])?>
            <b>Max price:</b> <?= Html::input('number', 'ProductSearch[maxPrice]',$maxPrice, ['style' => 'margin-right:5px'])?>
            <input type='submit' class='btn btn-default' value='Filter product list'>
            <?=Html::endForm() ?>
        </div>
    </div>

    <?php 

        echo "<div class='l-sm-4 col-lg-4 col-md-4'>";
        for($i = 0; $i < ceil(count($models) / 3); $i++) {
            $model = $models[$i];
            echo $this->render('card', ['model' => $model]);
        }
        echo '</div>';

        echo "<div class='l-sm-4 col-lg-4 col-md-4'>";
        for($j = $i; $j < $i + round(count($models) / 3); $j++) {
            $model = $models[$j];
            echo $this->render('card', ['model' => $model]);
        }
        echo '</div>';

        echo "<div class='l-sm-4 col-lg-4 col-md-4'>";
        for($k = $j; $k < count($models); $k++) {
            $model = $models[$k];
            echo $this->render('card', ['model' => $model]);
        }
        echo '</div>';


     ?>

</div>
