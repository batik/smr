<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$src = Url::to('@web/' . $model->photo );
?>
<div class="product-view">

    <div class="thumbnail clearfix">
        <div style="width:370px;float:left; margin-right:15px">
            <img class="img-responsive" src="<?=$src?>" alt="" style="max-height:250px; margin: 0 auto">
        </div>
        <div class="caption-full">
            <h4 class="pull-right" style="margin-right:10px; cursor:pointer" onclick='addToCart()'>
                <span class='glyphicon glyphicon-shopping-cart'></span>$<?=$model->price?>
            </h4>
            <h4><a href="#"><?=$model->name?></a>
            </h4>
            <p>Category: <?=$model->category->name?></p>
            <p><?=$model->description?></p>
            <?php
            foreach($model->attributevalues as $value)
            {
                echo $value->getCategoryAttribute()->one()->name . ": " . 
                    $value->value . " (" . $value->getCategoryAttribute()->one()->unit . ")<br>"; 
            }
            echo '<br>'
            ?>
        </div>
        <div class="ratings">
            <p class="pull-right" style="margin-right:10px;"><?= $model->getComments()->count()?> comments</p>
            <p>
                <?php

                $realRating = $model->rating == 0 ? 0 : $model->rating / $model->ratingAmount;
                for($i = 0; $i < $realRating; $i++)
                {
                    echo '<span class="glyphicon glyphicon-star"></span>';
                }
                for($j = 0; $j < 5 - $i; $j++)
                {
                    echo '<span class="glyphicon glyphicon-star-empty"></span>';
                }
                ?>
                (<?=$model->ratingAmount?> total)
            </p>
        </div>
    </div>

    <div class="well">
        <?php
        if(!Yii::$app->user->isGuest)
        { 
        ?>

            <div class="text-right">
            <a class="btn btn-success" onclick="openCommentModal()">Leave a Comment</a>
            </div>
        <?php
        }
        ?>

        <?php
            foreach($model->getComments()->all() as $comment)
            {
        ?>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <b><?=$comment->user->name?></b>
                <span class="pull-right"><?php $date = new DateTime($comment->date); echo $date->format('d-m-Y');?></span>
                <p><?= $comment->text?></p>
            </div>
        </div>
        <?php 
            }
        ?>

    </div>


    <div class="modal fade bs-example-modal-sm" id='myModal' tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modalLabel"></h4>
      </div>
      <div class="modal-body">
        <textarea rows=5 class="form-control" placeholder='Your comment here' id='comment'></textarea>
      </div>
      <div class="modal-footer">
        <button id='sendCommentButton' type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
    </div>
    </div>

</div>

<script>

var userId = <?= Yii::$app->user->isGuest ? -1 : Yii::$app->user->identity->id?>;
var prodId = <?= $model->id?>;
var price = <?= $model->price?>;

function openCommentModal()
{
    $('#modalLabel').text('Comment to <?= $model->name?>');
    $('#sendCommentButton').click(function()
    {
      var text = $('#comment').val();
      var date = new Date();
      date = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
      sendComment(text, date);
      $('#myModal').modal('hide');
    });
    $('#myModal').modal('show');
}

function sendComment(text, date)
{
    if(userId != -1)
    {
        $.ajax(
            {
                url:'create-comment',
                type: "POST",
                data: {'Comment':{'userId':userId, 'productId':prodId, 'text':text, 'date':date}},
                success: function() {
                    location.reload();
                }
            }
        );
    }
}

function addToCart()
{
    if(userId != -1) {
        if(getCookie('cart') == "") {
            setCookie('cart', '[]');
        }
        var cart = JSON.parse(getCookie('cart'));
        var count = getCookie('count');
        if(count == "") {
            setCookie('count', 0);
        }
        else {
            setCookie('count', +count + 1);
        }
        for(var i = 0; i < cart.length; i++)
        {
            if(cart[i].productId == prodId) 
            {
                cart[i].quantity = +cart[i].quantity + 1;
                setCookie('cart', JSON.stringify(cart));
                location.reload();
            }
        }
        cart.push({'userId':userId, 'productId':prodId, 'quantity':1, 'price':price});
        setCookie('cart', JSON.stringify(cart));
        location.reload();
    }
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
