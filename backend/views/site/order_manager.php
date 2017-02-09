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
    <?php $form = ActiveForm::begin(['id' => 'order-filter']); ?>

    <label>用户名：</label>

    <?php echo $form->field($model,"user_name")->label(false);?>

    &nbsp&nbsp<label>金额：</label>

    <?php echo $form->field($model,"min_money")->label(false);?>

    <label>到</label>

    <?php echo $form->field($model,"max_money")->label(false);?>

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

<script>
    $(function () {
        load_order();
    });

    function load_order() {
        $.ajax({
            url:"index.php?r=site/order-all",
            success:function (data) {

            },
            error:
        })
    }
</script>
