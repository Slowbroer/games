<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/25
 * Time: 上午11:21
 */



?>


<div >
    <?php echo \yii\bootstrap\Dropdown::widget(
        'items'
    );?>
</div>


<div class="panel panel-success" style="margin: 20px auto;width: 80%">
    <?php foreach($lists as $list){ ?>
        <div class="panel-heading">
            <a href="<?php echo \yii\helpers\Url::toRoute('item/edit').'&id='.$list['Id'] ?>"><?= $list['Name'] ?></a>
            <a style="float: right;padding-left: 10px" href="#" onclick="del_blog(<?php echo $list['Id'] ?>)">删除</a>
            <a style="float: right;" href="<?php echo \yii\helpers\Url::toRoute('item/edit').'&id='.$list['Id'] ?>">编辑</a>
        </div>
    <?php } ?>
</div>

<div style="text-align: center">
    <?php
    echo \yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
    ]);
    ?>
</div>

<div style="margin: 10px auto">
    <a href="index.php?r=blog/add">
        <button type="button" class="btn btn-info">新建博客</button>
    </a>
</div>