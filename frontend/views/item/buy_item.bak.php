<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/15
 * Time: 下午4:34
 */


use yii\bootstrap\Dropdown;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = "购买装备";

?>


<script>
    $(function (e) {
        $("#singleitemform-type").change(function (e) {
            $.ajax({
                url:"index.php?r=item/item_type",
                type:"GET",
                data:"type_id="+$(this).val(),
                success: function (data) {
                    if(data == false)
                    {
                        return false;
                    }
                    data = eval("("+data+")");
                    var html_content = "<option>请选择</option>";
//                    for(var i=0;i<data.length;i++)
//                    {
//                        var data1 = data[i];
//                        for(var key in data1)
//                        {
//                            html_content += "<option value='"+key+"'>"+data1[key]+"</option>"
//                        }
//                    }
                    for (var i in data)//遍历json对象
                    {
                        html_content += "<option value='"+i+"'>"+data[i]+"</option>";
                    }
                    console.log(data);
                    $("#singleitemform-id").html(html_content);
                },
                error:function (data) {
                    alert("获取失败，请重新刷新");
                }
            });
        });
        $("#singleitemform-id").change(function (e) {
            $.ajax({
                url:"index.php?r=item/item_info",
                type:"GET",
                data:"id="+$(this).val(),
                success:function (data) {
                    data = eval("("+data+")");
                    var html_content = "<p>价格："+data.Prise+"</p>";
                    $(".item_info").html(html_content);
                }
            })
        });
    });
</script>


<div>
    <?php $form = ActiveForm::begin(['id' => 'buy-item']); ?>

    <?php echo $form->field($model,'type')->dropDownList($lists,['style'=>'width:400px;','prompt'=>'请先选择种类']);?>

    <?php echo $form->field($model,'id')->dropDownList([],['prompt'=>'请选择','style'=>'width:400px;']);?>

    <div class="item_info">

    </div>

    <div class="form-group">
        <?= Html::submitButton('购买', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>



<!--    <select class="form-control">-->
<!--    --><?php //foreach ($lists as $key=>$value){?>
<!--        <option value="--><?//= $key?><!--">--><?//= $value?><!--</option>-->
<!--    --><?php //}?>
<!--    </select>-->
