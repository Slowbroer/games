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
<!--            <form class="item-edit" action="index.php?r=package/saveitem" method="post">-->
<!--            --><?php ////$form = ActiveForm::begin(['options'=>['class' => 'item-edit',],'action'=>\yii\helpers\Url::toRoute('package/saveitem'),'method'=>"POST"]); ?>
<!--            <tr style="width: 100%">-->
<!--                <td><label style="width: 60px;">--><?php //echo Html::encode($item['type_name']);?><!--</label></td>-->
<!--                <td>--><?php //echo Html::dropDownList('MuItem[Id]',$item['Id'],$item['type_list'],['style'=>'width:200px;','prompt'=>"请选择",'class'=>'id_list']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[naijiu]',$item['naijiu'],['style'=>'width:40px;']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[PVP]',$item['PVP'],['style'=>'width:40px;']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[taozhuang]',$item['taozhuang'],['style'=>'width:40px;']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[qianghua]',$item['qianghua'],['style'=>'width:40px;']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[level]',$item['level'],['style'=>'width:40px;']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[skill]',$item['skill'],['style'=>'width:40px;']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[luck]',$item['luck'],['style'=>'width:40px;']);?><!--</td>-->
<!--                <td>--><?php //echo Html::input('text','MuItem[add]',$item['add'],['style'=>'width:40px;']);?><!--</td>-->
<!--                --><?php ////echo Html::hiddenInput('MuItem[ZbIndex]',$item['ZbIndex'],['style'=>'width:40px;']);?>
<!---->
<!--                --><?php //echo Html::hiddenInput('type',$key);?>
<!--                --><?php //echo Html::hiddenInput('id',$model->Id);?>
<!--                <td>--><?php //echo Html::submitButton("保存",['style'=>'width:100px;']);?><!--</td>-->
<!---->
<!--            </tr>-->
<!--            --><?php ////ActiveForm::end(); ?>
<!--            </form>-->

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <tr>
                <td><?= Html::encode($item['type_name']);?></td>
                <td><?= $form->field($item['item'], 'Id')->dropDownList($item['type_list'],['prompt'=>'请选择'])->label(false); ?></td>
                <td><?= $form->field($item['item'], 'naijiu')->label(false); ?></td>
                <td><?= $form->field($item['item'], 'PVP')->label(false); ?></td>
                <td><?= $form->field($item['item'], 'taozhuang')->label(false); ?></td>
                <td><?= $form->field($item['item'], 'qianghua')->label(false); ?></td>
                <td><?= $form->field($item['item'], 'level')->label(false); ?></td>
                <td><?= $form->field($item['item'], 'add')->label(false); ?></td>
                <td><?= $form->field($item['item'], 'skill')->dropDownList(['0'=>"加",'1'=>'不加'])->label(false); ?></td>
                <td><?= $form->field($item['item'], 'luck')->dropDownList(['0'=>"加",'1'=>'不加'])->label(false); ?></td>


                <td><div style="display: inline-block"><?= Html::submitButton("保存",['style'=>'width:100px;','class'=>'btn btn-success']); ?></div></td>
            </tr>

            <?php ActiveForm::end(); ?>

        <?php }?>
        </tbody>
    </table>
</div>


<script type="text/javascript">

    $(".item-edit").submit(function (e) {
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


    $(".id_list").change(function (e) {
//        loadInfo($(this));
        console.log($(this).parent().parent());
    });

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