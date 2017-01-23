<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/25
 * Time: 上午11:21
 */

use \yii\bootstrap\Html;


$type_list = array(
    '0'=>'剑',
    '1'=>'斧头',
    '2'=>'槌',
    '3'=>'矛',
    '4'=>'弓弩',
    '5'=>'手杖',
    '6'=>'头盔',
    '7'=>'铠甲',
    '8'=>'手套',
    '9'=>'裤子',
    '10'=>'靴子',
    '11'=>'盾牌',
    '12'=>'吊环，饰品',
    '13'=>'珠宝',
    '14'=>'翅膀',
    '15'=>'卷轴，魔法球，消费品',
);

?>

<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
        种类
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <?php foreach ($type_list as $key => $value){?>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= \yii\helpers\Url::toRoute(['item/list','type'=>$key])?>"><?= $value?></a></li>
        <?php }?>
    </ul>
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
        <button type="button" class="btn btn-info">新建装备</button>
    </a>
</div>