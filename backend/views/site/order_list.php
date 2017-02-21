<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/20
 * Time: 下午12:28
 */


?>



<div>
    <table>
        <thead>
            <tr>
                <th>序号</th>
                <th>种类</th>
                <th>用户名</th>
                <th>装备名</th>
                <th>购买时间</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($lists as $key=>$list){?>
            <tr>
                <td><?= $key;?></td>
                <td><?= $list['Iname'];?></td>
                <td><?= $list['acc'];?></td>
                <td><?= $list['name'];?></td>
                <td><?= $list['sentdate'];?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div style="text-align: center">
    <?php
    echo \yii\widgets\LinkPager::widget([
        'pagination' => $page,
    ]);
    ?>
</div>
