<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/16
 * Time: 下午8:48
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class CommonAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/common.css',
    ];

    public $depends =[
        'frontend\assets\AppAsset'
    ];
}