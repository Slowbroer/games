<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/3
 * Time: 下午5:07
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;



?>

<style>
    .form-group {
        margin-top: 15px;
    }
</style>


<div class="package_brief">
    <?php $form = ActiveForm::begin(['id' => 'item-edit']); ?>
    <?= $form->field($model, 'Id')->hiddenInput()->label(false); ?>

    <?= $form->field($model,'Name')->textInput(['style'=>"width:300px;"]);?>

    <?= $form->field($model,'Prise')->textInput(['style'=>"width:300px;"]);?>

    <div class="form-group">
        <?= Html::submitButton('保存基本信息', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div style="overflow: hidden">
    <table style="overflow: hidden;width: 100%">
        <thead>
            <tr>
                <td style="width: 20px;">类型</td>
                <td style="width: 20px;">装备名</td>
                <td style="width: 20px;">耐久</td>
                <td style="width: 20px;">PVP</td>
                <td style="width: 20px;">套装</td>
                <td style="width: 20px;">强化</td>
                <td style="width: 20px;">增加等级</td>
                <td style="width: 20px;">追加</td>
                <td style="width: 20px;">技能</td>
                <td style="width: 20px;">幸运</td>
                <td style="width: 20px;">操作</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $key => $item){?>
            <form class="item-edit" action="index.php?r=package/saveitem" method="post">
            <tr style="width: 100%;height: 30px;">
                <td><label style="width: 60px;"><?php echo Html::encode($item['type_name']);?></label></td>
                <td><?php echo Html::dropDownList('MuItem[Id]',$item['Id'],$item['type_list'],['style'=>'width:200px;','prompt'=>"请选择",'class'=>'id_list']);?></td>
                <td><?php echo Html::input('text','MuItem[naijiu]',$item['naijiu'],['style'=>'width:40px;','class'=>'naijiu']);?></td>
                <td><?php echo Html::input('text','MuItem[PVP]',$item['PVP'],['style'=>'width:40px;','class'=>'pvp']);?></td>
                <td><?php echo Html::input('text','MuItem[taozhuang]',$item['taozhuang'],['style'=>'width:40px;','class'=>'taozhuang']);?></td>
                <td><?php echo Html::input('text','MuItem[qianghua]',$item['qianghua'],['style'=>'width:40px;','class'=>'qianghua']);?></td>
                <td><?php echo Html::input('text','MuItem[level]',$item['level'],['style'=>'width:40px;','class'=>'level']);?></td>
                <td><?php echo Html::input('text','MuItem[skill]',$item['skill'],['style'=>'width:40px;','class'=>'skill']);?></td>
                <td><?php echo Html::input('text','MuItem[luck]',$item['luck'],['style'=>'width:40px;','class'=>'luck']);?></td>
                <td><?php echo Html::input('text','MuItem[add]',$item['add'],['style'=>'width:40px;','class'=>'add']);?></td>
                <?php echo Html::hiddenInput('MuItem[ZbIndex]',$item['ZbIndex'],['style'=>'width:40px;','class'=>'index']);?>

                <?php echo Html::hiddenInput('type',$key);?>
                <?php echo Html::hiddenInput('id',$model->Id);?>
                <td><?php echo Html::submitButton("保存",['style'=>'width:100px;']);?></td>
            </tr>
            </form>
        <?php }?>
        </tbody>
    </table>
</div>


<script type="text/javascript">

    $(".id_list").change(function (e) {
//        console.log($(this).parent().parent().html());

        var item = $(this).parent().parent();
        $.ajax({
            url:"index.php?r=item/info",
            data:"id="+$(this).val(),
            type:"GET",
            success:function (data) {
                data = eval("("+data+")");
                console.log(data);
                item.find(".naijiu").val(data.naijiu);
                item.find(".pvp").val(data.PVP);
                item.find(".taozhuang").val(data.taozhuang);
                item.find(".qianghua").val(data.qianghua);
                item.find(".level").val(data.level);
                item.find(".skill").val(data.skill);
                item.find(".luck").val(data.luck);
                item.find(".add").val(data.add);
                item.find(".index").val(data.ZbIndex);
//                console.log(item);
//                alert(item.find(".naijiu"));

            },
            error:function () {

            }
        });


    });

    $(".item-edit").on("beforeSubmit",function (e) {
        alert("test");
        formSubmit($(this));
        return false;
    });




    function formSubmit(form) {
        $.ajax({
            url:$(form).attr('action'),
            type:$(form).attr('method'),
            data:$(form).serialize(),
            success:function (data) {
                console.log(data);
                if(data == "success")
                {
                    alert('更新成功');
                }
                else
                {
                    alert('更新失败');
                }
            },
            error:function () {
                alert('提交失败');
            }
        });

    }




    function loadInfo(form) {
        $.ajax({
            url:"index.php?r=package/load_info",
            type:"get",
            data:"id="+form.val(),
            success:function (data) {
                form.parent()
            },
            error:function (data) {
                
            }
        })
    }



</script>