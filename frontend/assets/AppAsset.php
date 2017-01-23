<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/reset.css',
        'css/style.css',
        'css/top.css',
        'css/login.css',
        'css/swiper-3.3.1.min.css',
    ];
    public $js = [
    ];
    public $jsOptions = ['position'=>View::POS_HEAD];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
