<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/18
 * Time: 下午1:02
 */
use yii\bootstrap\ActiveForm;

?>

<div>
<?php $form = ActiveForm::begin(); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">公告类型编辑框</h4>
    </div>
    <div class="modal-body">
        <?= $form->field($model,"id")->hiddenInput()->label(false);?>

        <span>类型名称：</span>

        <?= $form->field($model,"type_name",['options'=>['style'=>"display:inline-block"]])->textInput()->label(false);?>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">确定</button>
    </div>
<?php ActiveForm::end(); ?>
</div>
