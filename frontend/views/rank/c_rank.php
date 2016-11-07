<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/7
 * Time: 22:32
 */

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>



<div>
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

<!--    服务区-->
    <?= $form->field($model, 'server')->dropDownList(\yii\helpers\ArrayHelper::map($server,"ID",'ServerName')) ?>
<!--职业-->
    <?= $form->field($model, 'class')->dropDownList(\yii\helpers\ArrayHelper::map($class,"id",'name')) ?>
<!--条件-->
    <?= $form->field($model, 'condition')->dropDownList(\yii\helpers\ArrayHelper::map($condition,"ID",'ServerName')) ?>
<!--数量-->
    <?= $form->field($model, 'number')->dropDownList(\yii\helpers\ArrayHelper::map($number,"ID",'ServerName')) ?>


<!--    <label class="control-label col-md-1">分区：</label>-->
<!--    <div>-->
<!--        --><?//= Html::dropDownList('server', $server[0]['id'], ArrayHelper::map($server,"id",'name'), ['prompt' => '全部', 'class' => 'form-control']) ?>
<!--    </div>-->
<!---->
<!--    <label class="control-label col-md-1">职业：</label>-->
<!--    <div>-->
<!--        --><?//= Html::dropDownList('server', $server[0]['id'], ArrayHelper::map($server,"id",'name'), ['prompt' => '全部', 'class' => 'form-control']) ?>
<!--    </div>-->
<!---->
<!--    <label class="control-label col-md-1">条件：</label>-->
<!--    <div>-->
<!--        --><?//= Html::dropDownList('server', $server[0]['id'], ArrayHelper::map($server,"id",'name'), ['prompt' => '全部', 'class' => 'form-control']) ?>
<!--    </div>-->
<!---->
<!--    <label class="control-label col-md-1">查询数量：</label>-->
<!--    <div>-->
<!--        --><?//= Html::dropDownList('server', $server[0]['id'], ArrayHelper::map($server,"id",'name'), ['prompt' => '全部', 'class' => 'form-control']) ?>
<!--    </div>-->

    <button type="submit">查询</button>

    <?php ActiveForm::end(); ?>
</div>