<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PriceSnapshot */

$this->title = 'Update Price Snapshot: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Price Snapshots', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="price-snapshot-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
