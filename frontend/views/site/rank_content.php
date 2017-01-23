<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/9
 * Time: 下午2:53
 */
use yii\bootstrap\Html;


?>

<div class="left_four">
    <div class="four_ban"><a href="#">更多</a> 等級排行榜</div>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th>序号</th>
            <th>名字</th>
            <th>等级</th>
            <th>职业</th>
            <th>PK状态</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lists as $key=>$list){ ?>
        <tr>
            <td><?= Html::encode($key+1);?></td>
            <td><?= Html::encode($list['Name']);?></td>
            <td><?= Html::encode($list['PkLevel']);?></td>
            <td><?= Html::encode($list['ZY_name']);?></td>
            <td><?= Html::encode($list['PK_name']);?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
