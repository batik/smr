<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PriceSnapshot */

$this->title = 'Create Price Snapshot';
$this->params['breadcrumbs'][] = ['label' => 'Price Snapshots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-snapshot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
