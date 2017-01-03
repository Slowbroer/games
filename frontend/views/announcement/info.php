<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/28
 * Time: 下午4:17
 */
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

?>



<script>
    function load_comment() {
        var id = $(".id").val();
    }
</script>

<a href="#editComment">发表评论</a>
<a href="#commentLists">查看评论</a>
<div style="text-align: center;border-bottom: thick solid black">
    <h1>
        <?= Html::encode($model->name);?>
    </h1>
    <p>
        <?= date("Y-m-d H:i",$model->add_time);?>
    </p>

    <input type="hidden" class="id" value="<?= $model->announcement_id?>">
</div>

<div class="ann_content" style="margin: 20px auto;padding-top: 30px;max-width: 100%;">
    <?= $model->announcement_content;?>
</div>


<div id="commentLists" style="border: grey ">

</div>



<div id="editComment" style="padding-bottom: 100px;">

    <h3>评价区：</h3>

    <?php $form = ActiveForm::begin(['id' => 'form-signup','action'=>"index.php?r=announcement/comment"]); ?>

    <?= $form->field($comment, 'content')->textarea(['style'=>'height:200px;','holdplace'])->label(false);?>

    <div class="form-group" style="text-align: right">
        <?= Html::submitButton('提交评论', ['class' => 'btn btn-primary', 'name' => 'comment-button']) ?>
        <?= Html::submitButton('清空', ['class' => 'btn btn-warning', 'name' => 'comment-button']) ?>
    </div>


    <?= $form->field($comment,'id')->hiddenInput()->label(false);?>

    <?php ActiveForm::end(); ?>

</div>
