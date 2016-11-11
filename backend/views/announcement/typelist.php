<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/11
 * Time: 下午4:39
 */


use yii\helpers\Url;

?>


<div class="panel panel-success" style="margin: 20px auto;width: 95%">
    <?php foreach($lists as $list){ ?>
        <div class="panel-heading">
            <a href="<?php echo \yii\helpers\Url::toRoute('announcement/updatetype').'&id='.$list['announcement_id'] ?>"><?= $list['type_name']."-".$list['name'] ?></a>
            <a style="float: right;padding-left: 10px" href="#" onclick="del_blog(<?php echo $list['announcement_id'] ?>)">删除</a>
        </div>
    <?php } ?>
</div>

<div style="margin: 10px auto">
    <a href="index.php?r=announcement/updatetype">
        <button type="button" class="btn btn-info">新建公告</button>
    </a>
</div>


