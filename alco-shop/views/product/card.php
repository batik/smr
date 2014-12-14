<?php

use yii\helpers\Url;
    
 $src = Url::to('@web/' . $model->photo );

?>


<div >
    <div class="thumbnail">
        <img src="<?=$src?>" alt="">
         <div class="caption">
            <h4 class="pull-right">$<?=$model->price?></h4>
            <h4><a href="view?id=<?=$model->id?>"><?=$model->name?></a>
            </h4>
            <p><?=$model->description?></p>
        </div>
        <div class="ratings" style='margin:0 10px'>
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
            </p>
        </div>
    </div>
</div>