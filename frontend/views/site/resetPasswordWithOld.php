<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/5
 * Time: 下午8:00
 */

use yii\bootstrap\Html;
//use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveForm;

$this->title = "修改密码";
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>



    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'old_password')->passwordInput(['autofocus' => true]); ?>

            <p>请填写新密码:</p>

            <?= $form->field($model, 'new_password')->passwordInput(['autofocus' => true])->label(false); ?>

            <?= $form->field($model, 'confirm_password')->passwordInput(['autofocus' => true]); ?>

            <?= $form->field($model, 'memb_id')->hiddenInput()->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>



