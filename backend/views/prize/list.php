<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/6
 * Time: 上午11:15
 */
use yii\helpers\Url;


?>

<div>
    <?php foreach($lists as $list){ ?>
        <div class="panel-heading">
            <a href="<?php echo Url::toRoute('prize/edit').'&id='.$list['id'] ?>"><?= $list['name'] ?></a>
        </div>
    <?php } ?>
</div>