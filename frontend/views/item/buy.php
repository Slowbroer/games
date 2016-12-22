<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/20
 * Time: ÉÏÎç1:01
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '购买装备';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请选择想要购买的装备</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>




            <?= $form->field($model, 'zuoshou')->dropDownList($list[0],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'youshou')->dropDownList($list[1],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'tou')->dropDownList($list[2],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'kai')->dropDownList($list[3],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'shou')->dropDownList($list[4],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'tui')->dropDownList($list[5],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'xie')->dropDownList($list[6],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'fei')->dropDownList($list[7],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'xianglian')->dropDownList($list[8],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'zuoshouzhi')->dropDownList($list[9],['prompt'=>"请选择装备"]); ?>

            <?= $form->field($model, 'youshouzhi')->dropDownList($list[10],['prompt'=>"请选择装备"]); ?>




            <div class="form-group">
                <?= Html::submitButton('购买', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
