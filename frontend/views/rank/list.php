<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/13
 * Time: 上午10:47
 */
use yii\bootstrap\Html;


?>



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
    <?php foreach ($lists as $key => $list){?>
        <tr>
            <td><?= Html::encode($key)?></td>
            <td><?= Html::encode($list['Name'])?></td>
            <td><?= Html::encode($list['cLevel'])?></td>
            <td><?= Html::encode($list['ZY_name'])?></td>
            <td><?= Html::encode($list['PK_name'])?></td>
        </tr>
    <?php }?>
    </tbody>
</table>
