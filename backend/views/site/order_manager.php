<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/7
 * Time: 下午8:46
 */
use yii\bootstrap\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use yii\bootstrap\Html;

$this->title = "订单查看";
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
    .form-group {
        display: inline-block;
    }
    .input-group {
        display: inline-flex;
    }
    .input-group-addon {
        width: auto;
    }
</style>

<div>
    <?php $form = ActiveForm::begin(['id' => 'order-filter','method'=>'get','action'=>'index.php?r=site/order-manager']); ?>

    <label>用户名：</label>

    <?php echo $form->field($model,"user_name")->label(false);?>

<!--    &nbsp&nbsp<label>金额：</label>-->

    <?php //echo $form->field($model,"min_money")->label(false);?>

<!--    <label>到</label>-->

    <?php //echo $form->field($model,"max_money")->label(false);?>

    <br><br><label>购买时间：</label>

    <?php echo $form->field($model,"start_time")->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => '输入购买开始时间',
            'style'=>"width:150px;"
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-dd'
        ]
    ])->label(false);?>

    <label>到</label>

    <?php echo $form->field($model,"end_time")->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => '输入购买开始时间',
            'style'=>"width:150px;"
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-dd'
        ]
    ])->label(false);?>

    <div class="form-group" style="float: right">
        <?= Html::submitButton('筛选', ['class' => 'btn btn-primary', 'name' => 'order-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="order_list">

    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>序号</th>
                <th>装备名</th>
                <th>用户id</th>
                <th>用户名</th>
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
</div>

<script>
//    $(function () {
//        load_order();
//    });
//
//    function load_order() {
//        $.ajax({
//            url:"index.php?r=site/order-all",
//            success:function (data) {
//
//            },
//            error:
//        })
//    }
</script>
