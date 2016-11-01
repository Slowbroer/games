<?php
/**
 * Created by PhpStorm.
 * User: linpeiyu
 * Date: 2016-11-01
 * Time: 15:40
 */


use yii\ueditor\Ueditor;
use yii\ueditor\UeditorAsset;

UeditorAsset::register($this);

?>

<div>

    <?php $form = ActiveForm::begin(['id' => 'announcement-form']); ?>

    <?= $form->field($model, 'server')->dropDownList(ArrayHelper::map($server_list,"ID",'ServerName')) ?>

    <?php echo $form->field($model, 'newstext')->widget
    (Ueditor::className(),
    ['id'=> 'LoginForm[newstext]', 'ucontent'=>'初始化文本']
    ); ?>


    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

