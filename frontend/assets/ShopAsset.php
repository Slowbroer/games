<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/12
 * Time: 下午9:44
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ShopAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css =[
        'css/shop2.css'
    ];

    public $depends = [
        'frontend\assets\AppAsset'
    ];
}