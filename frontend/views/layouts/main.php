<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

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
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '奇迹MU',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '登陆', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label'=>'排行查询',
            'items'=>[
                ['label' => '角色排行', 'url' => 'index.php?r=rank/default',
                    'options'=>[
//                        'target'=>'.container'
                    ]
                ],
                ['label' => '战盟排行', 'url' => 'index.php?r=rank/guilddefault',
                    'options'=>[
//                        'target'=>'.container'
                    ]
                ],
            ],
        ];
        $menuItems[] = [
            'label'=>'商城',
            'items'=>[
                ['label' => '购买装备', 'url' => 'index.php?r=item/buy_single_item',
                    'options'=>[
//                        'target'=>'.container'
                    ]
                ],
                ['label' => '购买套装', 'url' => 'index.php?r=item/buypackage',
                    'options'=>[
//                        'target'=>'.container'
                    ]
                ],
                ['label' => '充值', 'url' => 'http://www.libaopay.com/',
                    'options'=>[
//                        'target'=>'.container'
                    ]
                ],
            ],
        ];

        $menuItems[] = [
            'label'=>'论坛公告',
            'items'=>[
                ['label' => '最新公告', 'url' => 'index.php?r=item/buy_single_item',
                    'options'=>[
//                        'target'=>'.container'/
                    ]
                ],
                ['label' => '全部公告', 'url' => 'index.php?r=announcement/all',
                    'options'=>[
                        'target'=>'content'
                    ]
                ],
            ],
        ];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '退出登陆 (' . Yii::$app->user->identity->memb___id . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
