<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/30
 * Time: 下午4:17
 */



?>

<div class="panel panel-success" style="margin: 20px auto;width: 95%">
    <?php foreach($lists as $list){ ?>
        <div class="panel-heading">
            <a href="<?php echo \yii\helpers\Url::toRoute('package/edit').'&id='.$list['Id'] ?>"><?= $list['Name'] ?></a>
        </div>
        <!--    <div class="panel-body">--><?php //echo Html::encode($list['brief'])?><!--</div>-->
    <?php } ?>
</div>





