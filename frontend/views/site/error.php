<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

//$this->title = $name;
$this->title = "出错了－_－";
?>
<div class="site-error" style="background: aliceblue;padding: 20px;border-radius: 10px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <div style="text-align: center">
        <a href="javascript:history.go(-1);">返回上一页</a>
    </div>


    <p>
        如有疑问，请联系客服；
    </p>
    <p>
        客服QQ：312312312
    </p>

</div>
