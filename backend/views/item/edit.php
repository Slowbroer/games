<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/25
 * Time: 上午11:37
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $name;
$this->params['breadcrumbs'][] = $this->title;


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
        /*display: inline-block;*/
    }
</style>

<div class="edit" style="">

    <h3><?= $model->Name ?></h3>
    <?php $form = ActiveForm::begin(['id' => 'item-edit']); ?>

    <?= $form->field($model, 'Id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'ZbIndex')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'Name')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'Type')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'Prise')->textInput(['placeholdr'=>"请填写价格，单位为元宝"]); ?>


    <?= $form->field($model,'PVP')->textInput(['temp']);?>

    <?= $form->field($model,'naijiu');?>

    <?= $form->field($model,'excellent');?>

    <?= $form->field($model,'cate')->hiddenInput()->label(false);?>

    <?= $form->field($model,'qianghua');?>

    <h4>属性</h4>

    <?= $form->field($model,'level');?>

    <?= $form->field($model,'add');?>

    <?= $form->field($model,'skill')->checkbox();?>

    <?= $form->field($model,'luck')->checkbox();?>

    <div class="form-group">
        <?= Html::submitButton('确认修改', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>



