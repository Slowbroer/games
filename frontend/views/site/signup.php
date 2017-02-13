<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .yii-form input {
        background-color: #fff;
    }
</style>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写注册所需信息:</p>

    <div class="row" style="margin: 0;">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup','options'=>['class'=>"yii-form"]]); ?>

                <?= $form->field($model, 'server')->dropDownList(\yii\helpers\ArrayHelper::map($server_list,"ID",'ServerName')) ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'nickname')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'confirm_password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
