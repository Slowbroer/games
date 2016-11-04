<?php
/**
 * Created by PhpStorm.
 * User: linpeiyu
 * Date: 2016-11-01
 * Time: 15:40
 */


use yii\ueditor\Ueditor;
use yii\ueditor\UeditorAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;

//UeditorAsset::register($this);//不能再这里调用这个是因为没有进行别名设置，@yii\ueditor\assets，，，而在Ueditor中会进行别名的设置并进行   UeditorAsset::register($this);

?>

<div>

    <?php $form = ActiveForm::begin(['id' => 'ann-form']); ?>


    <?php echo $form->field($model,"title")->label(false)->textInput(['placeholder'=>"请填写标题"]);?>

    <?php if(!empty($model['id'])){
        echo $form->field($model,"id")->label(false)->hiddenInput();
    }?>

    <?php echo $form->field($model,"type_id")->label(false)->dropDownList(ArrayHelper::map($type_list,"id",'name'));?><!--这里要添加数组-->

    <?php echo $form->field($model,'content')->widget('common\widgets\ueditor\Ueditor',[
        'options'=>[
            'initialFrameHeight' => 850,
        ]
    ]); ?>




    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

