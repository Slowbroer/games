<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/25
 * Time: 上午11:30
 */
use yii\helpers\Html;

$this->title = $name;

\frontend\assets\CommonAsset::register($this);

?>

<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="bg-success">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <div style="text-align: center">
        <a href="javascript:history.go(-1);">返回上一页</a>
    </div>

</div>


