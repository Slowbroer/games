<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/6
 * Time: 下午1:38
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;



?>

<script>
    $(function () {
        $("#type").on("click",function (e) {
            get_prize_value(this);//这里的this是一个html对象
        });
    });

    function get_prize_value(type) {
        var type_value = $(type).val();
        var content = '';
        $.ajax({
            url:"index.php?r=prize/prize_value",
            type:"POST",
            data:"type="+type_value,
            success:function (data) {
                $(".prize_content").html(data);
            },
            error:function () {

            }
        });

    }
</script>

<div style="width: 300px;margin: 10px auto;">
    <?php $form = ActiveForm::begin(['id' => 'item-edit']);  ?>

    <?= $form->field($model,'id')->hiddenInput()->label(false);?>

    <?= $form->field($model,'name')->textInput(['placeholder'=>'名称'])->label(false);?>

    <?= $form->field($model,'type')->radioList([
        '0'=>'无',
        '1'=>'积分',
        '2'=>'装备',
        '3'=>'套装',
    ],['id'=>'type',]);?>

    <div class="prize_content">

    </div>

    <?= $form->field($model,'proportion')->textInput(['placeholder'=>'占比'])->label(false);?>

    <?= $form->field($model,'sort')->textInput(['placeholder'=>'排序'])->label(false);?>

    <?= $form->field($model,'limit_number')->textInput(['placeholder'=>'限制数量'])->label(false);?>

    <div class="form-group">
        <?= Html::submitButton('确认修改', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end();?>


</div>



