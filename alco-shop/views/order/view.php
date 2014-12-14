<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\order */

$this->title = 'My order';
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            'name',
            'quantity',
            'price'
        ],
    ]) ?>

    <h2 class='pull-right' style='margin:0'>Total: <?= $total ?></h2>
    <button class='btn btn-success' onclick="confirmOrder()">Submit</button>

</div>

<script>
    var user = <?= Yii::$app->user->isGuest ? -1 : Yii::$app->user->identity->id?>;

    function confirmOrder(userId) {
        
        var date = new Date();
        var dateTime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " 
            +  date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        $.ajax( {
            url: "create",
            type: "POST", 
            data: {"Order": {"userId": user,  "totalPrice":"<?=$total?>", "date": dateTime, "paymentStatus":0}},
            success: function() {location.reload()}
        });
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
        }
        return "";
    } 

    function setCookie(cname, cvalue) {
        document.cookie = cname + "=" + cvalue + "; path=/";
    } 
</script>
