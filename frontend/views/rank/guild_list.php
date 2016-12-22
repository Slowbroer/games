<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/13
 * Time: 下午4:50
 */
use yii\bootstrap\Html;

?>


<table class="table table-condensed">
    <thead>
    <tr>
        <th>序号</th>
        <th>名字</th>
        <th>盟主</th>
        <th>战盟介绍</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($lists as $key => $list){?>
        <tr>
            <td><?= Html::encode($key)?></td>
            <td><?= Html::encode($list['G_Name'])?></td>
            <td><?= Html::encode($list['G_Master'])?></td>
            <td><?= Html::encode($list['G_Notice'])?></td>
        </tr>
    <?php }?>
    </tbody>
</table>
