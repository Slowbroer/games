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
//        'css/style.css',
//        'css/top.css',
//        'css/login.css',
        'css/swiper-3.3.1.min.css',
//        'css/skin_black.css',
//        'css/common.css',
    ];
    public $js = [
        'js/swiper-3.3.1.jquery.min.js',
//        'js/skin_black.js',
        'js/jquery.validate.min.js'
    ];
    public $jsOptions = ['position'=>View::POS_HEAD];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
