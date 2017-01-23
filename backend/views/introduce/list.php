<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/12
 * Time: 下午5:23
 */

?>


<div class="panel panel-success" style="margin: 20px auto;width: 80%">
    <?php foreach($lists as $list){ ?>
        <div class="panel-heading">
            <a href="#" onclick="editIntroduce(<?php echo $list['id'];?>)"><?= $list['title'] ?></a>
            <a style="float: right;padding-left: 10px" href="#" onclick="del_blog(<?php echo $list['id'] ?>)">显示</a>
            <a style="float: right;" href="<?php echo \yii\helpers\Url::toRoute('item/edit').'&id='.$list['id'] ?>">删除</a>
        </div>
    <?php } ?>
</div>

<div style="text-align: center">
    <?php
    echo \yii\widgets\LinkPager::widget([
        'pagination' => $page,
    ]);
    ?>
</div>


