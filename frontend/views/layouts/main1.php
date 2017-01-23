<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/11
 * Time: 下午4:09
 */
//use Yii;
use yii\bootstrap\Html;

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\helpers\Url;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php $this->beginBody() ?>
<div class="top">
    <div class="title">
        <ul class="clearfix">
            <li><a href="<?php echo Url::toRoute('site/index'); ?>">MU奇迹</a> </li>
            <li><a href="reg.php"></a> </li>
            <li><a href="download.php">游戏下载</a> </li>
            <li><a href="login.php"></a> </li>
            <li><a href="getPw.php"></a> </li>
            <li><a href="getintro.php">积分充值</a> </li>
            <li><a href="ToRmb.php"></a> </li>
            <li><a href="shop.php">装备商城</a> </li>
        </ul>
        <div class="logo"><img src="<?= Url::to("@web/images/home_page/logo.png");?>" alt=""></div>
    </div>
</div>
<div class="medium clearfix">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<script>
    var mySwiper = new Swiper ('.swiper-container', {
        direction: 'horizontal',
        loop: true,

        // 如果需要分页器
        pagination: '.swiper-pagination',

        // 如果需要前进后退按钮
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
    })
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
