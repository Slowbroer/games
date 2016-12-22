<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/13
 * Time: 上午9:50
 */
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = $name;

?>

<style>

    .control-label {
        width:auto;
    }
    .form-control {
        width: auto;
        display: inline-block;
        margin: 0 10px;
    }

    .form-group{
        display: inline-block;
    }
</style>

<script>
    $(function (e) {

        $("#form-rank").submit(function (e) {
            getList($(this));
            return false;
        });


//        rankForm = $("#form-rank");
//        getList(rankForm);
    });



    function getList(form) {
        console.log(form.serialize());
        $.ajax({
            url:form.attr("action"),
            type:form.attr('method'),
            data:form.serialize(),
            success:function (data) {
                data = eval("("+data+")");
                if(data.code==0)//error
                {

                    $(".rank_lists").html(data.message);
                }
                else //success
                {
//                    alert("test");
                    $(".rank_lists").html(data.message);
                }
            }
        })
    }
</script>


<div style="text-align: center">
    <?php $form = ActiveForm::begin(['id' => 'form-rank','action'=>'index.php?r=rank/characterlist']); ?>

    <?= $form->field($model,'server',['template'=>'{label}<div style="display: inline-block">{input}{hint}{error}</div>'])
        ->dropDownList(ArrayHelper::map($lists,'ID','ServerName'));?>

    <?= $form->field($model,'career',['template'=>'{label}<div style="display: inline-block">{input}{hint}{error}</div>'])
        ->dropDownList(ArrayHelper::map($class_lists,'class_id','class_name'),['prompt'=>'请选择职业']);?>

    <?= $form->field($model,'number',['template'=>'{label}<div style="display: inline-block">{input}{hint}{error}</div>'])
        ->dropDownList(['30'=>'30','60'=>"60",'90'=>"90"]);?>

    <div style="display: inline-block">
        <button type="submit" class="btn btn-success">
            查询
        </button>
    </div>

    <?php ActiveForm::end();?>

</div>

<div class="rank_lists">

</div>
