<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use \yii\bootstrap\Dropdown;

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
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];


    } else {

        $menuItems[] = [
            'label'=>'公告管理',
            'items'=>[
                ['label' => '公告列表', 'url' => 'index.php?r=announcement/list',
//                    'options'=>[
//                        'target'=>'.container'
//                    ]
                ],
//                   '<li class="divider"></li>',
//                   '<li class="dropdown-header">Dropdown Header</li>',
                ['label' => '公告类型', 'url' => 'index.php?r=announcement/typelist',
//                    'options'=>[
//                        'target'=>'.container'
//                    ]
                ],
                ['label' => '游戏介绍', 'url' => 'index.php?r=introduce/index',

                ],
            ],
        ];

        $menuItems[] = [
            'label'=>'商城管理',
            'items'=>[
                ['label' => '装备管理', 'url' => 'index.php?r=item/list',
                    'options'=>[
                        'target'=>'.container'
                    ]
                ],
//                   '<li class="divider"></li>',
//                   '<li class="dropdown-header">Dropdown Header</li>',
                ['label' => '套装管理', 'url' => 'index.php?r=package/list',
                    'options'=>[
                        'target'=>'.container'
                    ]
                ],
                ['label' => '订单管理', 'url' => '#',
                    'options'=>[
                        'target'=>'.container'
                    ]
                ],
            ],
        ];

        $menuItems[] = [
            'label'=>'系统管理',
            'items'=>[
                ['label' => '系统设置', 'url' => '#',
                    'options'=>[
                        'target'=>'.container'
                    ]
                ],
                ['label' => '管理员账户管理', 'url' => '#',
                    'options'=>[
                        'target'=>'.container'
                    ]
                ],
//                   '<li class="divider"></li>',
//                   '<li class="dropdown-header">Dropdown Header</li>',
                ['label' => '管理员操作日志', 'url' => '#',
                    'options'=>[
                        'target'=>'.container'
                    ]
                ],
                ['label' => '管理员', 'url' => '#',
                    'options'=>[
                        'target'=>'.container'
                    ]
                ],
            ],
        ];

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->admin_name . ')',
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
